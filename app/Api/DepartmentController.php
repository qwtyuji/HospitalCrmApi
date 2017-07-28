<?php
/**
 * Created by hupo.
 * @BLOG  : mycentos.com
 * @Date  : 2017/7/27-下午5:09
 * @Email : 317559272@qq.com
 */

namespace App\Api;


use App\Department;
use Illuminate\Http\Request;

class DepartmentController
{
    protected $request;
    protected $department;

    /**
     * DepartmentController constructor.
     * @param $request
     * @param $department
     */
    public function __construct(Request $request, Department $department)
    {
        $this->request = $request;
        $this->department = $department;
    }

    public function index()
    {
        $data = $this->department->with('doctor', 'disease')->get();
        return response()->json($data);
    }
}