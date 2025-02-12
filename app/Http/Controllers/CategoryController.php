<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * index
     */
    public function index(Request $request): mixed
    {
        if ($request->ajax()) {
            $data = Category::orderBy('id', 'desc')->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    return ' <div class="btn-group btn-sm">
                                        <a href="' . route('category.view', ['id' => base64_encode($data->id)]) . '" class="mx-2">
                                            <button type="button" class="btn btn-sm btn-icon btn-outline-secondary rounded-pill waves-effect">
                                                <i class="ri-eye-line"></i>
                                            </button>
                                        </a>
                                        <a href="' . route('category.edit', ['id' => base64_encode($data->id)]) . '" class="mx-2">
                                            <button type="button" class="btn btn-sm btn-icon btn-outline-secondary rounded-pill waves-effect">
                                                <i class="ri-file-edit-line"></i>
                                            </button>
                                        </a>
                                        <div class="btn-group mx-2" role="group">
                                            <button id="btnGroupDrop1" type="button" class="btn btn-xs btn-outline-secondary rounded-pill dropdown-toggle waves-effect" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="ri-more-2-line ri-20px"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" style="">
                                                <a class="dropdown-item changeStatus" href="javascript:;" data-status="active" data-old_status="' . $data->status . '" data-id="' . base64_encode($data->id) . '">Active</a>
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
                    $url = route('category.view', ['id' => base64_encode($data->id)]);
                    return "<a href='" . $url . "'>" . $data->name . "</a>";
                })

                ->rawColumns(['action', 'name', 'status'])
                ->make(true);
        }

        return view('category.index');
    }
    
    /**
     * create  
     */
    public function create()
    {
        return view('category.manage');
    }

    /**
     * edit
     */
    public function edit(Request $request)
    {
        $id = base64_decode($request->id);
        $data = Category::where(['id' => $id])->first();

        return view('category.manage', compact('data'));
    }

    /**
     * view
     */
    public function view(Request $request)
    {
        $id = base64_decode($request->id);
        $data = Category::where(['id' => $id])->first();

        return view('category.view', compact('data'));
    }

    /**
     * insert or update
     */
    public function store(CategoryRequest $request) {
        $data = $request->all();
        $data['created_by'] = auth()->user()->id;

        if ($request->has('id')) {
            $category = Category::find($request->id);

            if ($category) {
                $category->update($data);

                return redirect()->route('category.index')->with('success', 'Data has been updated successfully!');
            } else {
                return redirect()->back()->with('error', 'Data could not be found!');
            }
        } else {
            $process = Category::create($data);
            if ($process)
                return redirect()->route('category.index')->with('success', 'Data has been saved successfully!');
            else
                return redirect()->back()->with('error', 'Data could not be saved!');
        }
    }

    /**
     * status
     */
    public function status(Request $request)
    {
        if (!empty($request->all())) {
            $id = base64_decode($request->id);
            $status = $request->status;

            $data = Category::where(['id' => $id])->first();

            if (!empty($data)) {
                if ($status == 'delete') {
                    $process = Category::where(['id' => $id])->delete();
                } else {
                    $process = Category::where(['id' => $id])->update(['status' => $status, 'updated_by' => auth()->user()->id]);
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
