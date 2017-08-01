<?php
/**
 * Created by hupo.
 * @BLOG  : mycentos.com
 * @Date  : 2017/7/28-下午4:28
 * @Email : 317559272@qq.com
 */

namespace App\Api;


use App\Doctor;
use App\Hospital;
use App\Http\Requests\DoctorRequest;
use Illuminate\Http\Request;

/**
 * Class DoctorController
 * @package App\Api
 */
class DoctorController extends ApiController
{
    /**
     * @var Request
     */
    protected $request;
    /**
     * @var Doctor
     */
    protected $doctor;

    /**
     * DoctorController constructor.
     * @param $request
     * @param $doctor
     */
    public function __construct(Request $request, Doctor $doctor)
    {
        $this->request = $request;
        $this->doctor = $doctor;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $keyword = $this->request->keyword;
        if ($keyword) {
            $data = $this->doctor
                ->where('name', 'like', '%' . $keyword . '%')
                ->orWhere('author', 'like', '%' . $keyword . '%')
                ->orWhere('doctor_num', 'like', '%' . $keyword . '%')
                ->orWhereHas('department', function ($query) use ($keyword) {
                    $query->where('name', 'like', '%' . $keyword . '%');
                })
                ->orWhereHas('department.hospital', function ($query) use ($keyword) {
                    $query->where('name', 'like', '%' . $keyword . '%');
                })
                ->with('department.hospital')
                ->paginate();
        } else {
            $data = $this->doctor->orderBy('id', 'desc')->with('department.hospital')->paginate();
        }
        return response()->json($data);
    }


    /**
     * @param DoctorRequest $request
     * @return mixed
     */
    public function store(DoctorRequest $request)
    {
        $data = $request->all();
        $data['author'] = $this->author();
        $this->doctor->create($data);
        return $this->success('添加成功');
    }


    /**
     * @param DoctorRequest $request
     * @return mixed
     */
    public function update(DoctorRequest $request)
    {
        $data = $request->all();
        $data['author'] = $this->author();
        $doctor = $this->doctor->findOrFail($request->id);
        $doctor->update($data);
        return $this->success('修改成功');
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy()
    {
        $doctor = $this->doctor->findOrFail($this->request->id);
        $doctor->delete();
        return $this->success();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function batchremove()
    {
        $ids = explode(',', $this->request->ids);
        $this->doctor->destroy($ids);
        return $this->success();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkDoctorName()
    {
        return $this->checkName('Doctor');
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getHospitalDepartment()
    {
        $data = Hospital::with(['department' => function ($query) {
            $query->select('id as value', 'name as label', 'hospital_id');
        }])->select('id', 'name as label')->get();
        $data->each(function ($item) {
            $item['value'] = $item['id'];
            $item['children'] = $item['department'];
            $item['children']->each(function ($v) {
                unset($v['hospital_id']);
            });
            unset($item['id']);
            unset($item['department']);
        });
        return response()->json($data);
    }

}