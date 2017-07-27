<?php

namespace App\Listeners;

use App\Events\EventLogLogin;
use App\Log;
use Illuminate\Http\Request;

class EventLogLoginListener
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
     * @param  EventLogLogin  $event
     * @return void
     */
    public function handle(EventLogLogin $event)
    {

        $data = [
            'user_id' => $this->request->user()->id,
            'name' => $this->request->user()->name,
            'type' => '登录',
            'url' => $this->request->url(),
            'data' => '登录成功',
            'ip' => $this->request->ip(),
        ];
        $this->log->create($data);
    }
}
