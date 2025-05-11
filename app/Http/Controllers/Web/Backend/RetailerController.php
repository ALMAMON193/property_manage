<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use App\Models\Retailer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;

class RetailerController extends Controller
{
    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $data = Retailer::latest()->get();
                return DataTables::of($data)
                    ->addIndexColumn()

                    ->addColumn('status', function ($data) {
                        $status = $data->status === 'active';
                        return '
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input status-switcher"
                                    '.($status ? 'checked' : '').'
                                    onchange="showStatusChangeAlert(event, this, '.$data->id.')">
                            </div>
                        ';
                    })
                    ->addColumn('action', function ($data) {
                        return '
                        <a href="' . route('admin.retailer.edit', $data->id) . '" class="btn btn-warning btn-sm"><i class="ri-edit-2-line"></i> Edit</a>
                        ';
                    })
                    ->rawColumns(['action', 'status'])
                    ->make(true);
            }
            return view('backend.layouts.retailers.index');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }


    public function edit($id)
    {
        $retailer = Retailer::find($id);
        return view('backend.layouts.retailers.edit', compact('retailer'));
    }


    public function update(Request $request, $id)
    {
        $retailer = Retailer::findOrFail($id);

        // Validate the incoming request
        $request->validate([
            'title' => 'required|string|max:255',
            'retailer_website' => 'nullable|url|max:255',
            'update_interval' => 'required|string|max:255',
        ]);

        // Update retailer fields
        $retailer->title = $request->input('title');
        $retailer->retailer_website = $request->input('retailer_website');
        //$retailer->data_url = $request->input('data_url');
        //$retailer->type = $request->input('type');
        $retailer->update_interval = $request->input('update_interval');

        // Save changes
        $retailer->save();

        // Redirect back with success message
        return redirect()->route('admin.retailer.index')->with('t-success', 'Retailer updated successfully.');
    }




    /*=============== STATUS =============*/
    public function status(Request $request, $id)
    {
        $retailer = Retailer::find($id);

        if (!$retailer) {
            return response()->json([
                'success' => false,
                'message' => 'Retailer not found.'
            ], 404);
        }

        // Update sponsored status if provided
        if ($request->has('status')) {
            $retailer->status = $request->input('status');
            $retailer->save();

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully.'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No valid status field provided.'
        ], 400);
    }
}
