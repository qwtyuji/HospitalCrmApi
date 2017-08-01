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
class MediaController extends ApiController
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
        $keyword = $this->request->keyword;
        if ($keyword) {
            $data = $this->media
                ->where('name', 'like', '%' . $keyword . '%')
                ->orWhere('author', 'like', '%' . $keyword . '%')
                ->orWhereHas('hospital', function ($query) use ($keyword) {
                    $query->where('name', 'like', '%' . $keyword . '%');
                })
                ->with('hospital')
                ->paginate();
        } else {
            $data = $this->media->orderBy('id', 'desc')->with('hospital')->paginate();
        }
        return response()->json($data);
    }


    /**
     * @param MediaRequest $request
     * @return mixed
     */
    public function store(MediaRequest $request)
    {
        $data = $request->all();
        $data['author'] = $this->author();
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
        $data['author'] = $this->author();
        $media = $this->media->findOrFail($request->id);
        $media->update($data);
        return $this->success('修改成功');
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy()
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

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkMediaName()
    {
        return $this->checkName('Media');
    }

}