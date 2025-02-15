<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

use Illuminate\Support\Facades\DB;
use DataTables;

use App\Http\Requests\CustomerRequest;

use App\Models\Customer;

class CustomerController extends Controller
{
    /**
     * index
     */
    public function index(Request $request): mixed
    {
        if ($request->ajax()) {
            $data = Customer::orderBy('id', 'desc')->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    return ' <div class="btn-group btn-sm">
                                        <a href="' . route('customers.view', ['id' => base64_encode($data->id)]) . '" class="mx-2">
                                            <button type="button" class="btn btn-sm btn-icon btn-outline-secondary rounded-pill waves-effect">
                                                <i class="ri-eye-line"></i>
                                            </button>
                                        </a>
                                        <a href="' . route('customers.edit', ['id' => base64_encode($data->id)]) . '" class="mx-2">
                                            <button type="button" class="btn btn-sm btn-icon btn-outline-secondary rounded-pill waves-effect">
                                                <i class="ri-file-edit-line"></i>
                                            </button>
                                        </a>
                                        <div class="btn-group mx-2" role="group">
                                            <button id="btnGroupDrop1" type="button" class="btn btn-xs btn-outline-secondary rounded-pill dropdown-toggle waves-effect" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="ri-more-2-line ri-20px"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" style="">
                                                <a class="dropdown-item changeStatus" href="javascript:;"  data-status="active" data-old_status="' . $data->status . '" data-id="' . base64_encode($data->id) . '">Active</a>
                                                <a class="dropdown-item changeStatus" href="javascript:;" data-status="inactive" data-old_status="' . $data->status . '" data-id="' . base64_encode($data->id) . '">Inactive</a>
                                                <a class="dropdown-item changeStatus" href="javascript:;" data-status="deleted" data-old_status="' . $data->status . '" data-id="' . base64_encode($data->id) . '">Delete</a>
                                            </div>
                                        </div>
                                    </div>';
                })

                ->editColumn('status', function ($data) {
                    if ($data->status == 'active')
                        return '<span class="badge rounded-pill bg-label-primary">Active</span>';
                    else if ($data->status == 'inactive')
                        return '<span class="badge rounded-pill bg-label-warning">Inactive</span>';
                    else if ($data->status == 'deleted')
                        return '<span class="badge rounded-pill bg-label-danger">Delete</span>';
                    else
                        return '-';
                })

                ->editColumn('name', function ($data) {
                    $url = route('customers.view', ['id' => base64_encode($data->id)]);
                    return "<a href='".$url."'>".$data->name."</a>";
                })

                ->rawColumns(['action', 'status', 'name'])
                ->make(true);
        }
        return view('customers.index');
    }

    /**
     * create
     */
    public function create(): View
    {
        return view('customers.manage');
    }

    /**
     * edit
     */
    public function edit(Request $request): View
    {
        $id = base64_decode($request->id);

        $data = Customer::where(['id' => $id])->first();

        if(!empty($data))
            return view('customers.manage')->with(['data' => $data]);
        else
            return redirect()->back()->with(['error' => 'Something went wrong. please try later!']);
    }

    /**
     * view
     */
    public function view(Request $request): View
    {
        $id = base64_decode($request->id);

        $data = Customer::select('id', 'name', 'phone', 'email', 'status', 'created_at')
                            ->where(['id' => $id])
                            ->first();

        if(!empty($data)){
            $platform = DB::table('customers_platform as cp')
                            ->select('cp.platform_id', 'cp.username', 'p.name as platform_name')
                            ->leftJoin('platforms as p', 'p.id', '=', 'cp.platform_id')
                            ->where(['cp.customer_id' => $data->id])
                            ->get();
        
            if (!empty($platform)) {
                $data->platform = $platform;
            } else {
                $data->platform = [];
            }

            return view('customers.view')->with(['data' => $data]);
        }else{
            return redirect()->back()->with(['error' => 'Something went wrong. please try later!']);
        }
    }

    /**
     * insert or update
     */
    public function store(CustomerRequest $request): JsonResponse
    {
        $request = $request->all();

        $data = [
            'name' => $request['name'],
            'phone' => $request['phone'],
            'email' => $request['email'],
        ];

        if (!empty($request['id'])) {
            $data['status'] = $request['status'];
            $data['updated_at'] = date('Y-m-d H:i:s');
            $data['updated_by'] = auth()->user()->id;

            $id = Customer::where('id', $request['id'])->update($data);

            if ($id)
                return response()->json(['message' => 'Data updated successfully.', 'status' => 'success'], 200);

            return response()->json(['message' => 'Failed to update data, Please try again later!', 'status' => 'error'], 403);
        }

        $data['status'] = 'active';
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['created_by'] = auth()->user()->id;

        $id = Customer::insertGetId($data);

        if ($id)
            return response()->json(['message' => 'Data inserted successfully.', 'status' => 'success'], 200);

        return response()->json(['message' => 'Failed to insert data, Please try again later!', 'status' => 'error'], 403);
    }

    /**
     * status
     */
    public function status(Request $request){
        if (!empty($request->all())) {
            $id = base64_decode($request->id);
            $status = $request->status;

            $data = Customer::where(['id' => $id])->first();

            if(!empty($data)){
                if($status == 'delete'){
                    $process = Customer::where(['id' => $id])->delete();
                }else{
                    $process = Customer::where(['id' => $id])->update(['status' => $status, 'updated_by' => auth()->user()->id]);
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
