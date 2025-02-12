<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

use App\Http\Requests\PlatformRequest;
use App\Models\Platform;

class PlatformController extends Controller
{
    /**
     * index
     */
    public function index(Request $request): mixed
    {
        if ($request->ajax()) {
            $data = Platform::orderBy('id', 'desc')->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    return ' <div class="btn-group btn-sm">
                                        <a href="' . route('platform.view', ['id' => base64_encode($data->id)]) . '" class="mx-2">
                                            <button type="button" class="btn btn-sm btn-icon btn-outline-secondary rounded-pill waves-effect">
                                                <i class="ri-eye-line"></i>
                                            </button>
                                        </a>
                                        <a href="' . route('platform.edit', ['id' => base64_encode($data->id)]) . '" class="mx-2">
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
                    $url = route('platform.view', ['id' => base64_encode($data->id)]);
                    return "<a href='" . $url . "'>" . $data->name . "</a>";
                })

                ->editColumn('frontend_url', function ($data) {
                    return "<a href='" . $data->frontend_url . "' target='_blank'>" . $data->frontend_url . "</a>";
                })

                ->editColumn('logo', function ($data) {
                    return "<img src='" . __path('platform') . $data['logo'] . "' width='50px'>";
                })

                ->rawColumns(['action', 'status', 'logo', 'name', 'frontend_url'])
                ->make(true);
        }

        return view('platform.index');
    }

    /**
     * create
     */
    public function create()
    {
        return view('platform.manage');
    }

    /**
     * edit
     */
    public function edit(Request $request)
    {
        $id = base64_decode($request->id);
        $data = Platform::where(['id' => $id])->first();

        return view('platform.manage', compact('data'));
    }

    /**
     * view
     */
    public function view(Request $request)
    {
        $id = base64_decode($request->id);
        $data = Platform::where(['id' => $id])->first();

        return view('platform.view', compact('data'));
    }
    /**
     * insert or update
     */
    public function store(PlatformRequest $request) {
        $data = $request->all();
        $data['created_by'] = auth()->user()->id;

        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $logoName = time() . '_logo.' . $logo->getClientOriginalExtension();
            $logo->move(public_path('uploads/platform'), $logoName);
            $data['logo'] = $logoName;
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_image.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/platform'), $imageName);
            $data['image'] = $imageName;
        }

        if ($request->has('id')) {
            $platform = Platform::find($request->id);
            if ($platform) {
                if ($request->hasFile('logo') && $platform->logo) {
                    Storage::disk('public')->delete('uploads/platform/' . $platform->logo);
                }
                if ($request->hasFile('image') && $platform->image) {
                    Storage::disk('public')->delete('uploads/platform/' . $platform->image);
                }
                $platform->update($data);
                return redirect()->route('platform.index')->with('success', 'Data has been updated successfully!');
            } else {
                return redirect()->back()->with('error', 'Data could not be found!');
            }
        } else {
            $process = Platform::create($data);
            if ($process)
                return redirect()->route('platform.index')->with('success', 'Data has been saved successfully!');
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

            $data = Platform::where(['id' => $id])->first();

            if (!empty($data)) {
                if ($status == 'delete') {
                    $process = Platform::where(['id' => $id])->delete();
                } else {
                    $process = Platform::where(['id' => $id])->update(['status' => $status, 'updated_by' => auth()->user()->id]);
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
