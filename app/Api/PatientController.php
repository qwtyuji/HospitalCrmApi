<?php
/**
 * Created by hupo.
 * @BLOG  : mycentos.com
 * @Date  : 2017/7/28-下午4:23
 * @Email : 317559272@qq.com
 */

namespace App\Api;


use App\Http\Requests\StorePatientRequest;
use App\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class PatientController
 * @package App\Api
 */
class PatientController
{
    /**
     * @var Request
     */
    protected $request;
    /**
     * @var Patient
     */
    protected $patient;

    /**
     * PatientController constructor.
     * @param $request
     * @param $patient
     */
    public function __construct(Request $request, Patient $patient)
    {
        $this->request = $request;
        $this->patient = $patient;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $data = $this->patient->with('hospital', 'department', 'disease', 'doctor', 'user','media', 'patientRemark.user', 'patientLog.user', 'patientContent.user', 'patientCallback.user')->get();

        return response()->json($data);
    }

    public function store(StorePatientRequest $request)
    {
        
    }

    public function update()
    {
        
    }

    public function destroy()
    {
        
    }

    public function batchremove()
    {

    }
}