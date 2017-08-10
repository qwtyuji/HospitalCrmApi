<?php
/**
 * Created by hupo.
 * @BLOG  : mycentos.com
 * @Date  : 2017/7/27-下午5:09
 * @Email : 317559272@qq.com
 */

namespace App\Api;


use App\Disease;
use App\Http\Requests\DiseaseRequest;
use Illuminate\Http\Request;

/**
 * Class DiseaseController
 * @package App\Api
 */
class DiseaseController extends ApiController
{
    /**
     * @var Request
     */
    protected $request;
    /**
     * @var Disease
     */
    protected $disease;


    /**
     * DiseaseController constructor.
     * @param $request
     * @param $disease
     */
    public function __construct(Request $request, Disease $disease)
    {
        $this->request = $request;
        $this->disease = $disease;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $keyword = $this->request->keyword;
        //判断用户是否设置hospital_id,设置了只显示指定医院的数据
//        $this->setHospitalId('9');
        $hospital =$this->hospitalId;
        if ($keyword) {
            $data = $this->disease
                ->WhereHas('department.hospital', function ($query) use($hospital) {
                    if (!empty($hospital)){
                        $query->where('id', $hospital);
                    }
                })
                ->where('name', 'like', '%' . $keyword . '%')
                ->orWhere('author', 'like', '%' . $keyword . '%')
                ->orWhere('pid', 'like', '%' . $keyword . '%')
                ->orWhereHas('department', function ($query) use ($keyword) {
                    $query->where('name', 'like', '%' . $keyword . '%');
                })
                ->orWhereHas('department.hospital', function ($query) use ($keyword) {
                    $query->where('name', 'like', '%' . $keyword . '%');
                })
                ->with('department.hospital')
                ->paginate();
        } else {
            $data = $this->disease
                ->WhereHas('department.hospital', function ($query) use ($hospital) {
                    if (!empty($hospital)){
                        $query->where('id', $hospital);
                    }
                })
                ->orderBy('id', 'desc')->with('department.hospital')->paginate();
        }
        $data->each(function ($item) {
            $item->pidname = $this->disease->getPidName($item->pid);
        });
        return response()->json($data);
    }


    /**
     * @param DiseaseRequest $request
     * @return mixed
     */
    public function store(DiseaseRequest $request)
    {
        $data = $request->all();
        $data['author'] = $this->author();
        $this->disease->create($data);
        return $this->success('添加成功');
    }


    /**
     * @param DiseaseRequest $request
     * @return mixed
     */
    public function update(DiseaseRequest $request)
    {
        $data = $request->all();
        $data['author'] = $this->author();
        $disease = $this->disease->findOrFail($request->id);
        $disease->update($data);
        return $this->success('修改成功');
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy()
    {
        $disease = $this->disease->findOrFail($this->request->id);
        $disease->delete();
        return $this->success();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function batchremove()
    {
        $ids = explode(',', $this->request->ids);
        $this->disease->destroy($ids);
        return $this->success();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function list()
    {
        $department_id = $this->request->get('department_id');
        $data = $this->disease
            ->where('status', 1)
            ->where('department_id', $department_id)
            ->get();
        return response()->json($data);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkDiseaseName()
    {
        return $this->checkName('Disease');
    }
}