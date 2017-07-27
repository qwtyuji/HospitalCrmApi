<?php

namespace App\Api;

use App\Permission;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;


/**
 * Class RoleController
 * @package App\Api
 */
class RoleController extends ApiController
{
    /**
     * @var Request
     */
    protected $request;
    /**
     * @var Permission
     */
    protected $permission;
    protected $role;

    /**
     * RoleController constructor.
     * @param $request
     */
    public function __construct(Request $request, Permission $permission,Role $role)
    {
        $this->request = $request;
        $this->permission = $permission;
        $this->role = $role;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $keyword = $this->request->keyword;
        if ($keyword) {
            $data = Role::where('name', 'like', '%' . $keyword . '%')
                ->orWhere('guard_name', 'like', '%' . $keyword . '%')
                ->with('permissions', 'users')->paginate();
        } else {
            $data = Role::orderBy('id', 'desc')->with('permissions', 'users')->paginate();
        }
        return response()->json($data);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllPermissions()
    {
        $data = $this->permission->get();
        return response()->json($data);
    }


    /**
     * 验证名称唯一
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkName()
    {
        $data = $this->request->all();
        if (isset($data['id'])) {
            $rs = Role::where('id', '<>', $data['id'])->where('name', $data['name'])->first();
        } else {
            $rs = Role::where('name', $data['name'])->first();
        }
        return $this->check($rs);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidationException
     */
    public function store()
    {
        $this->validate($this->request, ['name' => 'required'],['name.required' => '名称不能为空']);
        $role = $this->request->all();
        Role::create($role);
        return $this->success();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidationException
     */
    public function update()
    {
        $role = Role::where('id',$this->request->get('id'))->first();
        $rule = [
            'name' => [
                'required',
                Rule::unique('roles')->ignore($role->id)
            ]
        ];
        $messages = [
            'name.required' => '名称不能为空',
            'name.unique' => '名称不能重复',
        ];
        $this->validate($this->request, $rule, $messages);
        $role->update($this->request->only('name'));
        $permissions = $this->request->get('permissions', []);
        $role->syncPermissions($permissions);
        return $this->success();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy()
    {
        $user = Role::findOrFail($this->request->id);
        $user->delete();
        return $this->success();
    }
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function batchremove()
    {
        $ids = explode(',', $this->request->ids);
        Role::destroy($ids);
        return $this->success();
    }
}
