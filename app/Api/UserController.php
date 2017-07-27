<?php

namespace App\Api;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


/**
 * Class UserController
 * @package App\Api
 */
class UserController extends ApiController
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * UserController constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $keyword = $this->request->keyword;
        if ($keyword) {
            $data = User::where('name', 'like', '%' . $keyword . '%')
                ->orWhere('email', 'like', '%' . $keyword . '%')
                ->paginate();
        } else {
            $data = User::orderBy('id', 'desc')->paginate();
        }
        return response()->json($data);
    }


    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkName()
    {
        $data = $this->request->all();
        if (isset($data['id'])) {
            $rs = User::where('id', '<>', $data['id'])->where('name', $data['name'])->first();
        } else {
            $rs = User::where('name', $data['name'])->first();
        }
        return $this->check($rs);
    }

    /**
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function userInfo()
    {
        return response($this->request->user());
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function userAuth()
    {
        $user = $this->request->user();
        $auth = $user->getAllPermissions();
        return $this->success('',$auth);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function upAvatar()
    {
        $file = $this->request->file('file');
        if (is_null($file)){
            return $this->error('请选择图片');
        }
        $path = config('app.domain').'/uploads/' . $file->store('', 'uploads');
        return $this->success('上传成功',$path);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkEmail()
    {
        $data = $this->request->all();
        if (isset($data['id'])) {
            $rs = User::where('id', '<>', $data['id'])->where('email', $data['email'])->first();
        } else {
            $rs = User::where('email', $this->request->email)->first();
        }
        return $this->check($rs);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function store()
    {
        $this->validate($this->request, [
            'password' => 'required|min:6',
            'email' => 'email|min:16',
        ]);
        $user = $this->request->all();
        User::create($user);
        return $this->success();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function update()
    {   $data = $this->request->all();
        $user = User::findOrFail($this->request->id);
        $rule = [
            'name' => 'required|min:3|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)]
        ];
        $message = [
            'name.required' => '用户名不能为空',
            'name.min' => '用户名太短',
            'name.max' => '用户名太长',
            'email.required' => 'email必须',
            'email.string' => '不是有效的字符',
            'email.email' => '不是有效的Email地址',
            'email.max' => 'Email地址超过最大长度',
            'email.unique' => '邮箱已注册',
        ];
        if (isset($data['password'])) {
            $rulePassword = [
                'password' => 'min:6|confirmed'
            ];
            $messagePassword = [
                'password.min' => '密码不能少于6位',
                'password.confirmed' => '两次输入密码不一样',
            ];
            $rule = array_merge($rule, $rulePassword);
            $message = array_merge($message, $messagePassword);
        }
        $this->validate($this->request, $rule, $message);

        $user->fill($this->request->only('name', 'email','avatar','status'));
        if ($this->request->get('password')) {
            $user->password = bcrypt($this->request->get('password'));
        }
        if (is_null($this->request->avatar)){
            unset($user->avatar);
        }
        $user->save();
        return $this->success();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy()
    {
        $user = User::findOrFail($this->request->id);
        $user->delete();
        return $this->success();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function batchremove()
    {
        $ids = explode(',', $this->request->ids);
        User::destroy($ids);
        return $this->success();
    }
}
