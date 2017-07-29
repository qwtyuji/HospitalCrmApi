<?php
/**
 * Created by hupo.
 * @BLOG  : mycentos.com
 * @Date  : 2017/7/27-下午5:09
 * @Email : 317559272@qq.com
 */

namespace App\Api;


use App\Disease;
use App\Http\Requests\DiseaseRequest;
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
        $data = $this->disease->paginate();
        return response()->json($data);
    }


    /**
     * @param DiseaseRequest $request
     * @return mixed
     */
    public function store(DiseaseRequest $request)
    {
        $data = $request->all();
        $this->disease->create($data);
        return $this->success('添加成功');
    }


    /**
     * @param DiseaseRequest $request
     * @return mixed
     */
    public function update(DiseaseRequest $request)
    {
        $data = $request->all();
        $disease = $this->disease->findOrFail($request->id);
        $disease->update($data);
        return $this->success('修改成功');
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function destory()
    {
        $disease = $this->disease->findOrFail($this->request->id);
        $disease->delete();
        return $this->success();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function batchremove()
    {
        $ids = explode(',', $this->request->ids);
        $this->disease->destroy($ids);
        return $this->success();
    }
}