<?php
/**
 * Created by hupo.
 * @BLOG  : mycentos.com
 * @Date  : 2017/7/28-下午4:18
 * @Email : 317559272@qq.com
 */

namespace App\Api;


use App\Http\Requests\MediaRequest;
use App\Media;
use Illuminate\Http\Request;

/**
 * Class MediaController
 * @package App\Api
 */
class MediaController
{
    /**
     * @var Request
     */
    protected $request;
    /**
     * @var Media
     */
    protected $media;

    /**
     * MediaController constructor.
     * @param $request
     * @param $media
     */
    public function __construct(Request $request, Media $media)
    {
        $this->request = $request;
        $this->media = $media;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $data = $this->media->paginate();
        return response()->json($data);
    }


    /**
     * @param MediaRequest $request
     * @return mixed
     */
    public function store(MediaRequest $request)
    {
        $data = $request->all();
        $this->media->create($data);
        return $this->success('添加成功');
    }


    /**
     * @param MediaRequest $request
     * @return mixed
     */
    public function update(MediaRequest $request)
    {
        $data = $request->all();
        $media = $this->media->findOrFail($request->id);
        $media->update($data);
        return $this->success('修改成功');
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function destory()
    {
        $media = $this->media->findOrFail($this->request->id);
        $media->delete();
        return $this->success();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function batchremove()
    {
        $ids = explode(',', $this->request->ids);
        $this->media->destroy($ids);
        return $this->success();
    }

}