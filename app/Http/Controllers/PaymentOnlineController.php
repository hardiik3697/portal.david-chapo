<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

use Illuminate\Support\Facades\DB;
use DataTables;

use App\Models\Stripe;
use App\Models\Payment;
use App\Models\Platform;
use App\Models\Customer;
use App\Models\CustomerPlatform;

class PaymentOnlineController extends Controller
{
    /**
     * index
     */
    public function index(Request $request, $id = null)
    {
        if ($id == null) {
            $stripe = __stripeLoadBounce(); 
            $id = $stripe['id'];
        } else {
            $id = base64_decode($id);
            $stripe = __stripeLoadBounce($id);
        }

        if ($stripe == null)
            return redirect()->back()->with(['error' => 'Please add one account']);

        $available = 0;
        $pending = 0;
        $balance = __stripeBalance($stripe['secret_key']);

        if ($balance != null) {
            $available = $balance['available'][0]['amount'] / 100;
            $pending = $balance['pending'][0]['amount'] / 100;
        }

        $stripes = Stripe::select('id', 'email')->where(['status' => 'active'])->get();

        if ($request->ajax()) {
            $data = DB::table('payments as p')
                            ->select('p.id', 'p.customer_id', 'p.customer_platform_id', 'p.amount', 'p.payment_status', 
                                'p.recharge_status', 'p.payment_type', 'cp.username', 'cp.platform_id', 'pt.name as platform')
                            ->leftJoin('customers_platform as cp', 'cp.id', '=', 'p.customer_platform_id')
                            ->leftJoin('platforms as pt', 'pt.id', '=', 'cp.platform_id')
                            ->where(['payment_type' => 'stripe'])
                            ->orderBy('id', 'desc')
                            ->get();


            if (!empty($data)) {
                foreach ($data as $row) {
                    $platform = Platform::select('name')->where(['id' => $row->platform_id])->first();

                    if (!empty($platform))
                        $row->platform = $platform->name;
                    else
                        $row->name = '';

                    $row->amount = '$' . $row->amount . '.00';
                }
            }

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $return = ' <div class="btn-group btn-sm">
                                        <a href="' . route('paymentOnline.view', ['id' => base64_encode($data->id)]) . '" class="mx-2">
                                            <button type="button" class="btn btn-sm btn-icon btn-outline-secondary rounded-pill waves-effect">
                                                <i class="ri-eye-line"></i>
                                            </button>
                                        </a>';

                    if($data->payment_status == 'succeeded') {
                                $return .= '<div class="btn-group mx-2" role="group">
                                            <button id="btnGroupDrop1" type="button" class="btn btn-xs btn-outline-secondary rounded-pill dropdown-toggle waves-effect" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="ri-more-2-line ri-20px"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" style="">
                                                <a class="dropdown-item changeStatus" href="javascript:;" data-status="pending" data-old_status="' . $data->recharge_status . '" data-id="' . base64_encode($data->id) . '">Pending</a>
                                                <a class="dropdown-item changeStatus" href="javascript:;" data-status="done" data-old_status="' . $data->recharge_status . '" data-id="' . base64_encode($data->id) . '">Done</a>
                                            </div>
                                        </div>
                                    </div>';                
                    }

                    return $return;
                })

                ->editColumn('username', function ($data) {
                    $url = route('paymentOnline.view', ['id' => base64_encode($data->id)]);
                    return "<a href='" . $url . "'>" . $data->username . "</a>";
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

        return view('paymentOnline.index', ['available' => $available, 'pending' => $pending, 'id' => $id, 'email' => $stripe['email'], 'stripes' => $stripes]);
    }

    /**
     * view
     */
    public function view(Request $request, $id)
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

        return view('paymentOnline.view')->with(['data' => $data]);
    }

    /**
     * status
     */
    public function status(Request $request)
    {
        if (!empty($request->all())) {
            $id = base64_decode($request->id);
            $status = $request->status;

            $data = Payment::where(['id' => $id])->first();

            if (!empty($data)) {
                if ($status == 'delete') {
                    $process = Payment::where(['id' => $id])->delete();
                } else {
                    $process = Payment::where(['id' => $id])->update(['recharge_status' => $status, 'updated_by' => auth()->user()->id]);
                }

                if ($process)
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
