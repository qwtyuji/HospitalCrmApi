<?php

namespace App\Listeners;

use App\Events\EventLogLoginFail;
use App\Log;
use Illuminate\Http\Request;

class EventLogLoginFailListener
{
    protected $log;
    protected $request;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Log $log, Request $request)
    {
        $this->log = $log;
        $this->request = $request;
    }

    /**
     * Handle the event.
     *
     * @param  EventLogLoginFail  $event
     * @return void
     */
    public function handle(EventLogLoginFail $event)
    {

        $data = [
            'user_id' => null,
            'name' => $this->request->get('email'),
            'type' => "登录",
            'url' => $this->request->url(),
            'data' => "登陆路失败尝试密码:".$this->request->get('password'),
            'ip' => $this->request->ip(),
        ];
        $this->log->create($data);
    }
}
