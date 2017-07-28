<?php
/**
 * Created by hupo.
 * @BLOG  : mycentos.com
 * @Date  : 2017/7/27-下午5:09
 * @Email : 317559272@qq.com
 */

namespace App\Api;


use App\Disease;
use Illuminate\Http\Request;

/**
 * Class DiseaseController
 * @package App\Api
 */
class DiseaseController
{
    /**
     * @var Request
     */
    protected $request;
    /**
     * @var Disease
     */
    protected $disease;

    /**
     * DiseaseController constructor.
     * @param $request
     * @param $disease
     */
    public function __construct(Request $request, Disease $disease)
    {
        $this->request = $request;
        $this->disease = $disease;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $data = $this->disease->get();
        return response()->json($data);
    }
}