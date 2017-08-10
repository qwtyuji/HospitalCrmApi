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
        $keyword = $this->request->keyword;
        if ($keyword) {
            $data = $this->depart->where('name', 'like', '%' . $keyword . '%')
                ->orWhere('author', 'like', '%' . $keyword . '%')
                ->paginate();
        } else {
            $data = $this->depart->orderBy('id', 'desc')->paginate();
        }
        $data->each(function ($item) {
            $item->pidName = $this->depart->getParentName($item->pid);
        });
        return response()->json($data);
    }

    /**
     * @param DepartRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(DepartRequest $request)
    {
        $data = $request->all();
        $data['author'] = $this->author();
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
        $data['author'] = $this->author();
        $depart = $this->depart->findOrFail($request->id);
        $depart->update($data);
        return $this->success('修改成功');
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy()
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

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function list()
    {
        $data = $this->depart
            ->where('status', 1)
            ->select('id','name')->get();
        return response()->json($data);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkDepartName()
    {
        return $this->checkName('Depart');
    }

}