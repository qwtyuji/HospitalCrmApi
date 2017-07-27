<?php

namespace App\Api;

use App\Events\EventLogLoginFail;
use Illuminate\Http\Request;

/**
 * Class UserController
 * @package App\Api
 */
class LoginController extends ApiController
{
    protected $request;

    /**
     * UserController constructor.
     * @param $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function login(Request $request)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'email'    => 'required|exists:users',
            'password' => 'required|between:6,32',
        ]);

        if ($validator->fails()) {
            $request->request->add([
                'errors' => $validator->errors()->toArray(),
                'code' => 401,
            ]);
            return $this->sendFailedLoginResponse($request);
        }

        $credentials = $this->credentials($request);

        if ($this->guard('api')->attempt($credentials, $request->has('remember'))) {
            return $this->sendLoginResponse($request);
        }
        event(new EventLogLoginFail());
        return response()->json('login failed', 401);
    }


}
