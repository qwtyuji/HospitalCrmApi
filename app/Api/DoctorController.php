<?php
/**
 * Created by hupo.
 * @BLOG  : mycentos.com
 * @Date  : 2017/7/28-下午4:28
 * @Email : 317559272@qq.com
 */

namespace App\Api;


use App\Doctor;
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
        $data = $this->doctor->with('department.hospital')->get();
        return response()->json($data);
    }

}