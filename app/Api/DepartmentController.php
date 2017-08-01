<?php
/**
 * Created by hupo.
 * @BLOG  : mycentos.com
 * @Date  : 2017/7/27-下午5:09
 * @Email : 317559272@qq.com
 */

namespace App\Api;


use App\Department;
use App\Http\Requests\DepartmentRequest;
use Illuminate\Http\Request;

/**
 * Class DepartmentController
 * @package App\Api
 */
class DepartmentController extends ApiController
{
    /**
     * @var Request
     */
    protected $request;
    /**
     * @var Department
     */
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


    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $keyword = $this->request->keyword;
        if ($keyword) {
            $data = $this->department
                ->where('name', 'like', '%' . $keyword . '%')
                ->orWhere('author', 'like', '%' . $keyword . '%')
                ->orWhereHas('hospital', function ($query) use ($keyword) {
                    $query->where('name', 'like', '%' . $keyword . '%');
                })
                ->with('hospital')
                ->paginate();
        } else {
            $data = $this->department->orderBy('id', 'desc')->with('hospital')->paginate();
        }
        return response()->json($data);
    }

    /**
     * @param DepartmentRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(DepartmentRequest $request)
    {
        $data = $request->all();
        $data['author'] = $this->author();
        $this->department->create($data);
        return $this->success('添加成功');
    }

    /**
     * @param DepartmentRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(DepartmentRequest $request)
    {
        $data = $request->all();
        $data['author'] = $this->author();
        $department = $this->department->findOrFail($request->id);
        $department->update($data);
        return $this->success('修改成功');
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy()
    {
        $department = $this->department->findOrFail($this->request->id);
        $department->delete();
        return $this->success();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function batchremove()
    {
        $ids = explode(',', $this->request->ids);
        $this->department->destroy($ids);
        return $this->success();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkDepartmentName()
    {
        return $this->checkName('Department');
    }
}