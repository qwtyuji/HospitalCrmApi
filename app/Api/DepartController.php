<?php
/**
 * Created by hupo.
 * @BLOG  : mycentos.com
 * @Date  : 2017/7/28-下午3:11
 * @Email : 317559272@qq.com
 */

namespace App\Api;


use App\Depart;
use App\Http\Requests\DepartRequest;
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
    public function __construct(Request $request, Depart $depart)
    {
        $this->request = $request;
        $this->depart = $depart;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $data = $this->depart->paginate();
        return response()->json($data);
    }

    /**
     * @param DepartRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(DepartRequest $request)
    {
        $data = $request->all();
        $this->depart->create($data);
        return $this->success('添加成功');
    }

    /**
     * @param DepartRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(DepartRequest $request)
    {
        $data = $request->all();
        $depart = $this->depart->findOrFail($request->id);
        $depart->update($data);
        return $this->success('修改成功');
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function destory()
    {
        $depart = $this->depart->findOrFail($this->request->id);
        $depart->delete();
        return $this->success();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function batchremove()
    {
        $ids = explode(',', $this->request->ids);
        $this->depart->destroy($ids);
        return $this->success();
    }

}