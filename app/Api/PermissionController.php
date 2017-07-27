<?php

namespace App\Api;

use App\Permission;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * Class PermissionController
 * @package App\Api
 */
class PermissionController extends ApiController
{
    protected $request;

    /**
     * PermissionController constructor.
     * @param $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index()
    {
        $keyword = $this->request->keyword;
        if ($keyword) {
            $data = Permission::where('name', 'like', '%' . $keyword . '%')
                ->orWhere('cname', 'like', '%' . $keyword . '%')
                ->orWhere('group', 'like', '%' . $keyword . '%')
                ->paginate();
        } else {
            $data = Permission::orderBy('id', 'desc')->paginate();
        }
        return response()->json($data);
    }

    /**
     * 验证用户名唯一
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkName()
    {
        $data = $this->request->all();
        if (isset($data['id'])) {
            $rs = Permission::where('id', '<>', $data['id'])->where('name', $data['name'])->first();
        } else {
            $rs = Permission::where('name', $data['name'])->first();
        }
        return $this->check($rs);
    }

    public function store()
    {
        $rule = [
            'name' => 'required|unique:roles',
        ];
        $message = [
            'name.required' => '名称不能为空',
            'name.unique' => '角色已经存在!不可重复添加',
        ];
        $this->validate($this->request, $rule, $message);
        Permission::create($this->request->all());
        return $this->success();
    }

    public function update()
    {
        $permission = Permission::find($this->request->get('id'));
        $rule = [
            'name' => [
                'required',
                Rule::unique('roles')->ignore($permission->id)
            ]
        ];
        $messages = [
            'name.required' => '名称不能为空',
            'name.unique' => '名称不能重复',
        ];
        $this->validate($this->request, $rule, $messages);
        $permission->update($this->request->all());
        return $this->success();
    }

    public function destroy()
    {
        $user = Permission::findOrFail($this->request->id);
        $user->delete();
        return $this->success();
    }

    public function batchremove()
    {
        $ids = explode(',', $this->request->ids);
        Permission::destroy($ids);
        return $this->success();
    }
}
