<?php
/**
 * Created by hupo.
 * @BLOG  : mycentos.com
 * @Date  : 2017/7/28-下午4:23
 * @Email : 317559272@qq.com
 */

namespace App\Api;


use App\Department;
use App\Disease;
use App\Doctor;
use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use App\Media;
use App\Patient;
use App\PatientCallback;
use App\PatientContent;
use App\PatientLog;
use App\PatientRemark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Class PatientController
 * @package App\Api
 */
class PatientController extends ApiController
{
    /**
     * @var Request
     */
    protected $request;
    /**
     * @var Patient
     */
    protected $patient;

    /**
     * PatientController constructor.
     * @param $request
     * @param $patient
     */
    public function __construct(Request $request, Patient $patient)
    {
        $this->request = $request;
        $this->patient = $patient;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        DB::enableQueryLog();
        $keyword = $this->request->keyword;
        $hospital = $this->request->hospital;
        if ($keyword) {
            $data = $this->patient->where('hospital_id',$hospital)
                ->orWhereHas('hospital', function ($query) use ($keyword) {
                    $query->where('name', 'like', '%' . $keyword . '%');
                })
                ->orWhereHas('department', function ($query) use ($keyword) {
                    $query->where('name', 'like', '%' . $keyword . '%');
                })
                ->orWhereHas('disease', function ($query) use ($keyword) {
                    $query->where('name', 'like', '%' . $keyword . '%');
                })
                ->orWhereHas('user', function ($query) use ($keyword) {
                    $query->where('name', 'like', '%' . $keyword . '%');
                })
                ->orWhereHas('media', function ($query) use ($keyword) {
                    $query->where('name', 'like', '%' . $keyword . '%');
                })
                ->orwhere('name', 'like', '%' . $keyword . '%')
                ->orWhere('phone', 'like', '%' . $keyword . '%')
                ->orWhere('age', 'like', '%' . $keyword . '%')
                ->with('hospital', 'department', 'disease', 'doctor', 'user', 'media','depart', 'patientContent')
                ->paginate();
        } else {
            $data = $this->patient->orderBy('id', 'desc')->where('hospital_id',$hospital)
                ->with('department', 'hospital', 'disease', 'doctor', 'user', 'media','depart', 'patientContent')
                ->paginate();
        }
//        dump(DB::getQueryLog());
        $data->each(function ($item) {
            $item->patientRemark->each(function ($v, $key) use ($item) {
                $item->patientRemark[$key] = $v->created_at . ' ' . $v->user->name . ' ' . $v->content;
            });
            $item->patientLog->each(function ($v, $key) use ($item) {
                $item->patientLog[$key] = $v->user->created_at . ' ' . $v->user->name . ' ' . $v->content;
            });
            $item->patientCallback->each(function ($v, $key) use ($item) {
                $item->patientCallback[$key] = $v->user->created_at . ' ' . $v->user->name . ' ' . $v->content;
            });
            $item->each(function ($v) use ($item) {
                $item->status = config('hupo.status')[$v->status];
            });
        });
        return response()->json($data);
    }

    /**
     * @param StorePatientRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StorePatientRequest $request)
    {
        $data = $request->all();
        $data['user_id'] = Auth::id();
        $data['depart_id'] = Auth::id();
        $patient = $this->patient->create($data);
        //备注
        $this->patientRemark($patient);
        //咨询内容
        $this->patientContent($patient);
        return $this->success('添加成功');
    }

    /**
     * @param UpdatePatientRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdatePatientRequest $request)
    {
        $data = $request->all();
        $data['user_id'] = Auth::id();
        $patient = $this->patient->findOrFail($request->id);
        $patient->update($data);
        //增加记录
        $this->patientLog($data, $patient);
        //备注
        $this->patientRemark($patient);
        //咨询内容
        $this->patientContent($patient, $action = 'update');
        //回访
        $this->patientCallback($patient);
        return $this->success('修改成功');
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy()
    {
        $patient = $this->patient->findOrFail($this->request->id);
        $patient->delete();
        return $this->success();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function batchremove()
    {
        $ids = explode(',', $this->request->ids);
        $this->patient->destroy($ids);
        return $this->success();
    }

    /**
     * 修改操作增加记录
     * @param $content
     */
    protected function patientLog($data, $patient)
    {
        $log = [
            'user'    => $this->request->user(),
            'content' => $this->patient->createLog($data, $patient),
        ];
        PatientLog::create($log);
    }


    /**
     * 保存备注
     * @param $patient
     */
    protected function patientRemark($patient)
    {
        $data['patient_id'] = $patient->id;
        $data['content'] = $this->request->get('remark');
        $data['user_id'] = Auth::id();
        PatientRemark::create($data);
    }

    /**
     * 保存咨询内容
     * @param $patient
     */
    protected function patientContent($patient, $action = 'store')
    {


        $data['content'] = $this->request->get('content');
        $data['chat_record'] = $this->request->get('chatlog');
        $data['user_id'] = Auth::id();
        $patientContent = new PatientContent($data);
        if ($action == 'update') {
            $patient->patientContent()->associate($patientContent);
            $patient->save();
        }
        $patient->patientContent()->save($patientContent);
    }

    /**
     * 保存回访
     * @param $patient
     */
    protected function patientCallback($patient)
    {
        $data['patient_id'] = $patient->id;
        $data['content'] = $this->request->get('callback');
        $data['user_id'] = Auth::id();
        PatientCallback::create($data);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function mediaList()
    {
        if ($this->request->hospital) {
            $data = Media::where('hospital_id', $this->request->hospital)
                ->where('status', 1)
                ->get();
        } else {
            $data = Media::where('status', 1)
                ->get();
        }
        return response()->json($data);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function departmentList()
    {
        if ($this->request->hospital) {
            $data = Department::where('hospital_id', $this->request->hospital)
                ->where('status', 1)
                ->get();
        } else {
            $data = Department::where('status', 1)
                ->get();
        }
        return response()->json($data);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function doctorList()
    {
        if ($this->request->department) {
            $data = Doctor::where('department_id', $this->request->department)
                ->where('status', 1)
                ->get();
        } else {
            $data = Doctor::where('status', 1)
                ->get();
        }
        return response()->json($data);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function diseaseList()
    {
        if ($this->request->department) {
            $data = Disease::where('department_id', $this->request->department)
                ->where('status', 1)
                ->get();
        } else {
            $data = Disease::where('status', 1)
                ->get();
        }
        return response()->json($data);
    }

}