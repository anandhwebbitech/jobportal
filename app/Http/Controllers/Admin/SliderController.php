<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\DataTables;

class SliderController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $sliders = Slider::orderBy('position', 'asc')->latest();

            return DataTables::of($sliders)
                ->addIndexColumn()

                ->filter(function ($query) {
                    if (request()->has('search') && $search = request('search')['value']) {
                        $query->where(function ($q) use ($search) {
                            $q->where('title', 'like', "%{$search}%")
                            ->orWhere('subtitle', 'like', "%{$search}%")
                            ->orWhere('description', 'like', "%{$search}%")
                            ->orWhere('button_text', 'like', "%{$search}%")
                            ->orWhere('button_link', 'like', "%{$search}%")
                            ->orWhere('position', 'like', "%{$search}%")
                            ->orWhere('created_at', 'like', "%{$search}%");
                        });
                    }
                })

                ->editColumn('image', function ($row) {
                    if (!$row->image) {
                        return '-';
                    }

                    $url = asset($row->image);

                    return '<img src="'.$url.'"
                            style="width:70px;height:50px;object-fit:cover;border-radius:6px;border:1px solid #ddd;">';
                })

                ->editColumn('title', function ($row) {
                    return $row->title ?? '-';
                })

                ->editColumn('position', function ($row) {
                    return '<span class="badge bg-info">'.$row->position.'</span>';
                })

                ->editColumn('status', function ($row) {
                    return $row->status
                        ? '<span class="badge bg-success">Active</span>'
                        : '<span class="badge bg-danger">Inactive</span>';
                })

                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('Y-m-d H:i:s');
                })

                ->addColumn('action', function ($row) {
                    return '
                        <div class="d-flex gap-3">
                            <a href="'.route('admin.sliders.edit', $row->id).'"
                                data-route="'.route('admin.sliders.edit', $row->id).'"
                                class="btn btn-sm btn-primary"
                                title="Edit">
                                <i class="fa fa-edit"></i>
                            </a>

                            <button data-id="'.$row->id.'"
                                data-table-id="slider-table"
                                data-route="'.route('admin.sliders.destroy', $row->id).'"
                                class="btn btn-sm btn-danger delete"
                                title="Delete">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    ';
                })

                ->rawColumns(['image','status','action','position'])
                ->make(true);
        }

        return view('admin.sliders.index');
    }

    public function create()
    {
        return view('admin.sliders.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'         => 'nullable|string|max:255',
            'subtitle'      => 'nullable|string|max:255',
            'description'   => 'nullable|string',
            'image'         => 'required|image|mimes:jpg,jpeg,png,webp|max:1024',
            'button_text'   => 'nullable|string|max:100',
            'button_link'   => 'nullable|url',
            'position'      => 'nullable|integer|min:0',
        ]);

        DB::beginTransaction();
        try {

            $data = $request->except('image');

            $data['status'] = $request->has('status') ? 1 : 0;

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = time() . '_slider.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/sliders'), $filename);
                $data['image'] = 'uploads/sliders/' . $filename;
            }

            Slider::create($data);

            DB::commit();

            return redirect()
                ->route('admin.sliders.index')
                ->with('success', 'Slider created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $slider = Slider::findOrFail($id);
        return view('admin.sliders.edit', compact('slider'));
    }

    public function update(Request $request, $id)
    {
        $slider = Slider::findOrFail($id);

        $request->validate([
            'title'        => 'nullable|string|max:255',
            'subtitle'     => 'nullable|string|max:255',
            'description'  => 'nullable|string',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:1024',
            'button_text'  => 'nullable|string|max:100',
            'button_link'  => 'nullable|url|max:255',
            'position'     => 'nullable|integer|min:0',
        ]);

        DB::beginTransaction();
        try {

            $data = $request->except('image');

            $data['status'] = $request->has('status') ? 1 : 0;

            if ($request->hasFile('image')) {

                if ($slider->image && File::exists(public_path($slider->image))) {
                    File::delete(public_path($slider->image));
                }

                $file = $request->file('image');
                $filename = time() . '_slider.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/sliders'), $filename);
                $data['image'] = 'uploads/sliders/' . $filename;
            }

            $slider->update($data);

            DB::commit();

            return redirect()
                ->route('admin.sliders.index')
                ->with('success', 'Slider updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        $slider = Slider::findOrFail($id);

        try {
            if ($slider->image && File::exists(public_path($slider->image))) {
                File::delete(public_path($slider->image));
            }

            $slider->delete();

            return response()->json([
                'status' => true,
                'message' => 'Slider deleted successfully',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Slider deleted successfully',
            ]);
        }
    }
}
