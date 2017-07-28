<?php
/**
 * Created by hupo.
 * @BLOG  : mycentos.com
 * @Date  : 2017/7/28-下午3:11
 * @Email : 317559272@qq.com
 */

namespace App\Api;


use App\Depart;
use Illuminate\Http\Request;

/**
 * Class DepartController
 * @package App\Api
 */
class DepartController extends ApiController
{
    /**
     * @var Request
     */
    protected $request;
    /**
     * @var Depart
     */
    protected $depart;

    /**
     * DepartController constructor.
     * @param $request
     * @param $depart
     */
    public function __construct(Request $request,Depart $depart)
    {
        $this->request = $request;
        $this->depart = $depart;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $data  = $this->depart->get();
        return response()->json($data);
    }

}