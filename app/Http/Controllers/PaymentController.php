<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

use Illuminate\Support\Facades\DB;
use DataTables;

use App\Http\Requests\PaymentRequest;

use App\Models\Payment;
use App\Models\Platform;
use App\Models\Customer;
use App\Models\CustomerPlatform;

class PaymentController extends Controller
{
    /**
     * index
     */
    public function index(Request $request): mixed
    {
        if ($request->ajax()) {
            $data = DB::table('payments as p')
                            ->select('p.id', 'p.customer_id', 'p.customer_platform_id', 'p.amount', 'p.payment_status', 
                                'p.recharge_status', 'p.payment_type', 'cp.username', 'cp.platform_id', 'pt.name as platform')
                            ->leftJoin('customers_platform as cp', 'cp.id', '=', 'p.customer_platform_id')
                            ->leftJoin('platforms as pt', 'pt.id', '=', 'cp.platform_id')
                            ->orderBy('id', 'desc')
                            ->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    if($data->payment_type == 'cash'){
                        $payment_type =  route('payment.edit', ['id' => base64_encode($data->id)]);
                        $disabled = '';
                    }else{
                        $payment_type = '#';
                        $disabled = 'disabled="disabled"';
                    }

                    return ' <div class="btn-group btn-sm">
                                        <a href="' . route('payment.view', ['id' => base64_encode($data->id)]) . '" class="mx-2">
                                            <button type="button" class="btn btn-sm btn-icon btn-outline-secondary rounded-pill waves-effect">
                                                <i class="ri-eye-line"></i>
                                            </button>
                                        </a>
                                        <a href="' .$payment_type. '" class="mx-2"'.$disabled.'>
                                            <button type="button" class="btn btn-sm btn-icon btn-outline-secondary rounded-pill waves-effect">
                                                <i class="ri-file-edit-line"></i>
                                            </button>
                                        </a>
                                        <div class="btn-group mx-2" role="group">
                                            <button id="btnGroupDrop1" type="button" class="btn btn-xs btn-outline-secondary rounded-pill dropdown-toggle waves-effect" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="ri-more-2-line ri-20px"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" style="">
                                                <a class="dropdown-item changeStatus" href="javascript:;" data-status="pending" data-old_status="' . $data->recharge_status . '" data-id="' . base64_encode($data->id) . '">Pending</a>
                                                <a class="dropdown-item changeStatus" href="javascript:;" data-status="done" data-old_status="' . $data->recharge_status . '" data-id="' . base64_encode($data->id) . '">Done</a>
                                            </div>
                                        </div>
                                    </div>';
                })

                ->editColumn('payment_type', function ($data) {
                    if($data->payment_type == 'cash'){
                        return ucfirst($data->payment_type);
                    }else{
                        return 'Online';
                    }
                })

                ->editColumn('username', function($data){
                    $url = route('payment.view', ['id' => base64_encode($data->id)]);
                    return "<a href='".$url."'>".$data->username."</a>";
                })

                ->editColumn('payment_status', function ($data) {
                    return ucfirst($data->payment_status);
                })

                ->editColumn('recharge_status', function ($data) {
                    return ucfirst($data->recharge_status);
                })

                ->rawColumns(['action', 'username'])
                ->make(true);
        }

        return view('payment.index');
    }

    /**
     * create
     */
    public function create(): View
    {
        $platforms = Platform::select('id', 'name')->where(['status' => 'active'])->get();

        return view('payment.manage')->with(['platforms' => $platforms]);
    }

    /**
     * edit
     */
    public function edit(Request $request): View
    {
        $id = base64_decode($request->id);

        $data = DB::table('payments as p')
                    ->select('p.id', 'p.customer_id', 'p.customer_platform_id', 'p.amount', 'p.payment_id', 'p.client_secret',
                    'p.payment_type', 'p.payment_type_id', 'p.payment_status', 'p.recharge_status', 'c.name as customer_name',
                    'c.phone as customer_phone', 'c.email as customer_email', 'c.stripe_customer_id as customer_stripe_customer_id',
                    'c.status as customer_status', 'cp.username', 'pt.name as platform_name', 'pt.id as platform_id')
                    ->leftjoin('customers as c', 'c.id', 'p.customer_id')
                    ->leftjoin('customers_platform as cp', 'cp.id', 'p.customer_platform_id')
                    ->leftjoin('platforms as pt', 'pt.id', 'cp.platform_id')
                    ->where(['p.id' => $id])
                    ->first();

        $platforms = Platform::select('id', 'name')->where(['status' => 'active'])->get();

        return view('payment.manage')->with(['data' => $data, 'platforms' => $platforms]);
    }

    /**
     * view
     */
    public function view(Request $request): View
    {
        $id = base64_decode($request->id);

        $data = DB::table('payments as p')
                    ->select('p.id', 'p.customer_id', 'p.customer_platform_id', 'p.amount', 'p.payment_id', 'p.client_secret',
                    'p.payment_type', 'p.payment_type_id', 'p.payment_status', 'p.recharge_status', 'c.name as customer_name',
                    'c.phone as customer_phone', 'c.email as customer_email', 'c.stripe_customer_id as customer_stripe_customer_id',
                    'c.status as customer_status', 'cp.username', 'pt.name as platform_name')
                    ->leftjoin('customers as c', 'c.id', 'p.customer_id')
                    ->leftjoin('customers_platform as cp', 'cp.id', 'p.customer_platform_id')
                    ->leftjoin('platforms as pt', 'pt.id', 'cp.platform_id')
                    ->where(['p.id' => $id])
                    ->first();

        return view('payment.view')->with(['data' => $data]);
    }

    /**
     * insert or update
     */
    public function store(PaymentRequest $request): JsonResponse
    {
        $request = $request->all();
        unset($request['_token']);
        unset($request['_method']);

        if (!empty($request['id'])) {
            DB::beginTransaction();
            try {
                $customerData = [
                    'name' => $request['name'],
                    'email' => $request['email'],
                    'phone' => $request['phone'],
                    'updated_at' => date('Y-m-d H:i:s'),
                    'updated_by' => auth()->user()->id
                ];

                $customer = Customer::where(['id' => $request['customer_id']])->update($customerData);

                if($customer){
                    $customerPlatform = CustomerPlatform::select('id')
                                                ->where(['customer_id' => $request['customer_id'],
                                                        'platform_id' => $request['platform_id'],
                                                        'username' => $request['username']])
                                                ->first();

                    if(is_null($customerPlatform)){
                        $customerPlatformData = [
                            'customer_id' => $request['customer_id'],
                            'platform_id' => $request['platform_id'],
                            'username' => $request['username'],
                            'status' => 'active',
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s')
                        ];

                        $customerPlatformId = CustomerPlatform::insertGetId($customerPlatformData);
                    }else{
                        $customerPlatformData = [
                            'customer_id' => (int)$request['customer_id'],
                            'platform_id' => (int)$request['platform_id'],
                            'username' => $request['username'],
                            'updated_at' => date('Y-m-d H:i:s'),
                            'updated_by' => auth()->user()->id,
                        ];

                        $customerPlatformId = CustomerPlatform::where(['id' => $customerPlatform->id])->update($customerPlatformData);
                    }

                    if($customerPlatformId){
                        $payment = [
                            'customer_id' => (int)$request['customer_id'],
                            'customer_platform_id' => $customerPlatformId,
                            'amount' => $request['amount'],
                            'payment_status' => $request['payment_status'],
                            'recharge_status' => $request['recharge_status'],
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s')
                        ];

                        $paymentId = Payment::where(['id' => $request['id']])->update($payment);

                        if($paymentId){
                            DB::commit();
                            return response()->json(['message' => 'Data inserted successfully.', 'status' => 'success'], 200);
                        }else{
                            DB::rollback();
                            return response()->json(['message' => 'Failed to insert data, Please try again later!', 'status' => 'error'], 403);
                        }
                    }
                }else{
                    DB::rollback();
                    return response()->json(['message' => 'Failed to insert data, Please try again later!', 'status' => 'error'], 403);
                }
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json(['message' => 'Failed to insert data, Please try again later!', 'status' => 'error'], 403);
            }
                // return response()->json(['message' => 'Data updated successfully', 'status' => 'success'], 200);
        }

        DB::beginTransaction();
        try {
            $customerId = Customer::select('id')->where(['email' => $request['email']])->first();

            if(is_null($customerId)){
                $customer = [
                    'name' => $request['name'],
                    'phone' => $request['phone'],
                    'email' => $request['email'],
                    'status' => 'active',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                $customerId = Customer::insertGetId($customer);
            }else{
                $customerId = $customerId->id;
            }

            if(!is_null($customerId)){
                $customerPlatformId = CustomerPlatform::select('id')
                                                ->where(['customer_id' => $customerId,
                                                        'platform_id' => $request['platform_id'],
                                                        'username' => $request['username']])
                                                ->first();

                if(is_null($customerPlatformId)){
                    $customerPlatform = [
                        'customer_id' => $customerId,
                        'platform_id' => $request['platform_id'],
                        'username' => $request['username'],
                        'status' => 'active',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ];

                    $customerPlatformId = CustomerPlatform::insertGetId($customerPlatform);
                }else{
                    $customerPlatformId = $customerPlatformId->id;
                }

                if(!is_null($customerPlatformId)){
                    $payment = [
                        'customer_id' => $customerId,
                        'customer_platform_id' => $customerPlatformId,
                        'amount' => $request['amount'],
                        'payment_type' => 'cash',
                        'payment_status' => 'succeeded',
                        'recharge_status' => 'pending',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ];

                    $paymentId = Payment::insertGetId($payment);

                    if(!is_null($paymentId)){
                        DB::commit();
                        return response()->json(['message' => 'Data inserted successfully.', 'status' => 'success'], 200);
                    }else{
                        DB::rollback();
                        return response()->json(['message' => 'Failed to insert data, Please try again later!', 'status' => 'error'], 403);
                    }
                }else{
                    DB::rollback();
                    return response()->json(['message' => 'Failed to insert data, Please try again later!', 'status' => 'error'], 403);
                }
            }else{
                DB::rollback();
                return response()->json(['message' => 'Failed to insert data, Please try again later!', 'status' => 'error'], 403);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Failed to insert data, Please try again later!', 'status' => 'error'], 403);
        }
    }

    /**
     * status
     */
    public function status(Request $request){
        if (!empty($request->all())) {
            $id = base64_decode($request->id);
            $status = $request->status;

            $data = Payment::where(['id' => $id])->first();

            if(!empty($data)){
                if($status == 'delete'){
                    $process = Payment::where(['id' => $id])->delete();
                }else{
                    $process = Payment::where(['id' => $id])->update(['recharge_status' => $status, 'updated_by' => auth()->user()->id]);
                }

                if($process)
                    return response()->json(['code' => 200]);
                else
                    return response()->json(['code' => 201]);
            } else {
                return response()->json(['code' => 201]);
            }
        } else {
            return response()->json(['code' => 201]);
        }
    }
}
