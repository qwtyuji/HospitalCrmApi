<?php

namespace App\Api;

use App\Log;
use Illuminate\Http\Request;

/**
 * Class LogController
 * @package App\Api
 */
class LogController extends ApiController
{
    /**
     * @var Request
     */
    protected $request;
    /**
     * @var Log
     */
    protected $log;

    /**
     * CategorController constructor.
     * @param $requst
     */
    public function __construct(Request $request, Log $log)
    {
        $this->request = $request;
        $this->log = $log;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $keyword = $this->request->keyword;
        if ($keyword) {
            $data = $this->log->where('name', 'like', '%' . $keyword . '%')
                ->orWhere('type', 'like', '%' . $keyword . '%')
                ->orWhere('url', 'like', '%' . $keyword . '%')
                ->orWhere('ip', 'like', '%' . $keyword . '%')
                ->orWhere('data', 'like', '%' . $keyword . '%')
                ->paginate()->toArray();
        } else {
            $data = $this->log->orderBy('id', 'desc')->paginate()->toArray();
        }

        return response()->json($data);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy()
    {
        $user = $this->log->findOrFail($this->request->id);
        $user->delete();
        return $this->success();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function batchremove()
    {
        $ids = explode(',', $this->request->ids);
        $this->log->destroy($ids);
        return $this->success();
    }
}