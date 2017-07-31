<?php
/**
 * Created by hupo.
 * @BLOG  : mycentos.com
 * @Date  : 2017/7/28-下午4:23
 * @Email : 317559272@qq.com
 */

namespace App\Api;


use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use App\Patient;
use App\PatientCallback;
use App\PatientLog;
use App\PatientRemark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $data = $this->patient->with('hospital', 'department', 'disease', 'doctor', 'user', 'media', 'patientRemark.user', 'patientLog.user', 'patientContent.user', 'patientCallback.user')->get();

        return response()->json($data);
    }

    /**
     * @param StorePatientRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StorePatientRequest $request)
    {
        $data = $request->all();
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
    public function destory()
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
        $data['patient_id'] = $patient->id;
        $data['content'] = $this->request->get('content');
        $data['chat_record'] = $this->request->get('chat_record');
        $data['user_id'] = Auth::id();
        if ($action == 'update') {
            $patient->patientContent()->detach($data);
        }
        $patient->patientContent()->attach($data);
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

}