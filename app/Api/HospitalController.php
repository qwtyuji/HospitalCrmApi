<?php
/**
 * Created by hupo.
 * @BLOG  : mycentos.com
 * @Date  : 2017/7/27-下午5:08
 * @Email : 317559272@qq.com
 */

namespace App\Api;


use App\Hospital;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class HospitalController
 * @package App\Api
 */
class HospitalController
{
    /**
     * @var Hospital
     */
    protected $hospital;
    /**
     * @var Request
     */
    protected $request;

    /**
     * HospitalController constructor.
     * @param $hospital
     */
    public function __construct(Hospital $hospital, Request $request)
    {
        $this->hospital = $hospital;
        $this->request = $request;

    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $data = $this->hospital->with('department','disease','doctor','media','patient')->get();
        return response()->json($data);
    }
}