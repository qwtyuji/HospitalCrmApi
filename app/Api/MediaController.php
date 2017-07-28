<?php
/**
 * Created by hupo.
 * @BLOG  : mycentos.com
 * @Date  : 2017/7/28-下午4:18
 * @Email : 317559272@qq.com
 */

namespace App\Api;


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
    public function __construct(Request $request,Media $media)
    {
        $this->request = $request;
        $this->media = $media;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $data = $this->media->get();
        return response()->json($data);
    }

}