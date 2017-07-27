<?php
/**
 * Created by hupo.
 * @BLOG  : mycentos.com
 * @Date  : 2017/7/18-上午11:26
 * @Email : 317559272@qq.com
 */

namespace App\Observers;

use App\Log;
use Illuminate\Http\Request;

/**
 * Class LogObserver
 * @package App\Observers
 */
class LogObserver
{
    /**
     * @var Log
     */
    protected $log;
    /**
     * @var Request
     */
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
     * @param $data
     */
    public function updated($data)
    {

        return $this->log($data, '修改');
    }

    /**
     * @param $data
     */
    public function created($data)
    {
        return $this->log($data, '创建');
    }

    /**
     * @param $data
     */
    public function deleted($data)
    {
        return $this->log($data, '删除');
    }

    /**
     * @param $data
     * @param $type
     */
    protected function log($data, $type)
    {
        $log = [
            'user_id' => $this->request->user()->id,
            'name'    => $this->request->user()->name,
            'type'    => $type,
            'url'     => $this->request->url(),
            'data'    => (string)$data,
            'ip'      => $this->request->ip(),
        ];
        $this->log->create($log);
    }
}