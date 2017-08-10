<?php
/**
 * Created by hupo.
 * @BLOG  : mycentos.com
 * @Date  : 2017/7/27-下午5:08
 * @Email : 317559272@qq.com
 */

namespace App\Api;


use App\Hospital;
use App\Http\Requests\HospitalRequest;
use Illuminate\Http\Request;

/**
 * Class HospitalController
 * @package App\Api
 */
class HospitalController extends ApiController
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
        $keyword = $this->request->keyword;
        if ($keyword) {
            $data = $this->hospital->where('name', 'like', '%' . $keyword . '%')
                ->orWhere('group', 'like', '%' . $keyword . '%')
                ->orWhere('author', 'like', '%' . $keyword . '%')
                ->paginate();
        } else {
            $data = $this->hospital->orderBy('id', 'desc')->paginate();
        }
        return response()->json($data);
    }


    /**
     * @param HospitalRequest $request
     * @return mixed
     */
    public function store(HospitalRequest $request)
    {
        $data = $request->all();
        $data['author'] = $this->author();
        $this->hospital->create($data);
        return $this->success('添加成功');
    }


    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function group()
    {
        $data = $this->hospital->groupBy('group')->select('group')->get()->toArray();
        $group = [];
        foreach ($data as $v) {
            $group[]['name'] = $v['group'];
        }
        return response()->json($group);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkHospitalName()
    {
        return $this->checkName('Hospital');
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function list()
    {
        $data = $this->hospital->where('status', '1')->get();
        return response()->json($data);
    }
    /**
     * @param HospitalRequest $request
     * @return mixed
     */
    public function update(HospitalRequest $request)
    {
        $data = $request->all();
        $data['author'] = $this->author();
        $hospital = $this->hospital->findOrFail($request->id);
        $hospital->update($data);
        return $this->success('修改成功');
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy()
    {
        $hospital = $this->hospital->findOrFail($this->request->id);
        $hospital->delete();
        return $this->success();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function batchremove()
    {
        $ids = explode(',', $this->request->ids);
        $this->hospital->destroy($ids);
        return $this->success();
    }
}