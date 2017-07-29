<?php
/**
 * Created by hupo.
 * @BLOG  : mycentos.com
 * @Date  : 2017/7/28-下午4:28
 * @Email : 317559272@qq.com
 */

namespace App\Api;


use App\Doctor;
use App\Http\Requests\DoctorRequest;
use Illuminate\Http\Request;

/**
 * Class DoctorController
 * @package App\Api
 */
class DoctorController
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
        $data = $this->doctor->with('department.hospital')->paginate();
        return response()->json($data);
    }


    /**
     * @param DoctorRequest $request
     * @return mixed
     */
    public function store(DoctorRequest $request)
    {
        $data = $request->all();
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
        $doctor = $this->doctor->findOrFail($request->id);
        $doctor->update($data);
        return $this->success('修改成功');
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function destory()
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

}