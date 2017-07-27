<?php

namespace App\Api;

use App\Authorizable;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Events\EventLogLogin;


/**
 * Class ApiController
 * @package App\Api
 */
class ApiController extends Controller
{
    use AuthenticatesUsers;
    use Authorizable;

    //调用认证接口获取授权码

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    protected function authenticateClient(Request $request)
    {
        $credentials = $this->credentials($request);
        $data = $request->all();
        $request->request->add([
            'grant_type' => $data['grant_type'],
            'client_id' => $data['client_id'],
            'client_secret' => $data['client_secret'],
            'username' => $credentials['email'],
            'password' => $credentials['password'],
            'scope' => ''
        ]);
        $proxy = Request::create(
            'oauth/token',
            'POST'
        );

        $response = \Route::dispatch($proxy);
        event(new EventLogLogin());
        return $response;
    }

    //以下为重写部分

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    protected function authenticated(Request $request)
    {
        return $this->authenticateClient($request);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request)
    {
        $this->clearLoginAttempts($request);

        return $this->authenticated($request);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        $msg = $request['errors'];
        $code = $request['code'];
        return response($msg, $code);
    }


    /**
     * @param null $message
     * @param array $data
     * @param int $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function success($message = null, $data = [], $status = true)
    {
        return $this->responseJson($message, $data, $status);
    }

    /**
     * @param null $mesage
     * @param array $data
     * @param int $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function error($message = null, $data = [], $status = false)
    {
        return $this->responseJson($message, $data, $status);
    }

    /**
     * @param $message
     * @param $data
     * @param $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseJson($message, $data, $status)
    {
        return response()->json(['message'=>$message,'data'=> $data, 'status' => $status]);
    }

    /**
     * @param $rs
     * @return \Illuminate\Http\JsonResponse
     */
    public function check($rs)
    {
        return $rs ? $this->error() : $this->success();
    }
}