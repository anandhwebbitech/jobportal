<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        if ($request->ajax()) {

            $locations = Location::query();

            return DataTables::of($locations)
                ->addIndexColumn()

                ->filter(function ($query) {

                    if (request()->has('search') && $search = request('search')['value']) {

                        $query->where(function ($q) use ($search) {

                            $q->where('district', 'like', "%{$search}%")
                                ;
                        });
                    }
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

                            <a href="javascript:void(0);" 
                            data-title="Edit Location" 
                            data-size="modal-lg"
                            data-route="' . route('admin.locations.edit', $row->id) . '"
                            class="btn btn-sm btn-primary common_model" 
                            title="Edit">

                                <i class="fa fa-edit"></i>

                            </a>

                            <button data-id="' . $row->id . '"
                                data-table-id="location-table"
                                data-route="' . route('admin.locations.destroy', $row->id) . '" 
                                class="btn btn-sm btn-danger delete"
                                title="Delete">

                                <i class="fa fa-trash"></i>

                            </button>

                        </div>
                    ';
                })

                ->rawColumns(['status', 'action', 'created_at'])
                ->make(true);
        }

        return view('admin.location.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $html = view('admin.location.create')->render();

        return response()->json([
            'html' => $html
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [

            'state' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'status' => 'required|in:0,1',

        ], [

            'state.required' => 'State is required.',
            'district.required' => 'District is required.',
            'status.required' => 'Status is required.'

        ]);

        if ($validator->fails()) {

            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        Location::create([

            'state' => $request->state,
            'district' => $request->district,
            'status' => $request->status

        ]);

        return response()->json([

            'status' => true,
            'message' => 'Location created successfully'

        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Location $location)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Location $location)
    {
        //
        if (!$location) {

            return response()->json([
                'success' => false,
                'error'   => 'Location not found'
            ]);
        }

        $html = view('admin.location.edit', compact('location'))->render();

        return response()->json([
            'success' => true,
            'html' => $html
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        //
        $validator = Validator::make($request->all(), [

            'state' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'status' => 'required|in:0,1',
        ], [
            'state.required' => 'State is required.',
            'district.required' => 'District is required.'
        ]);

        if ($validator->fails()) {

            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $location = Location::findOrFail($id);

        $location->update([

            'state' => $request->state,
            'district' => $request->district,
            'status' => $request->status

        ]);

        return response()->json([

            'status' => true,
            'message' => 'Location updated successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Location $location)
    {
        //
        $location->delete();

        return response()->json([

            'status'  => true,
            'message' => 'Location deleted successfully.'

        ]);
    }
}
