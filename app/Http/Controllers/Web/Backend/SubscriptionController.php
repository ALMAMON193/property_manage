<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SubscriptionController extends Controller
{
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data = Subscription::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('date', function ($data) {
                    return $data->created_at->format('Y-m-d');  // Example: 2025-02-24
                })
                ->addColumn('time', function ($data) {
                    return $data->created_at->format('H:i:s');  // Example: 14:35:22
                })
                ->addColumn('action', function ($data) {
                    return '<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                   <a href="' . route('admin.subscribe.view', $data->id) . '" class="btn btn-primary text-white" title="View">
                       <i class="mdi mdi-eye"></i>
                   </a>
                   <a href="#" onclick="deleteAlert(' . $data->id . ')" class="btn btn-danger text-white" title="Delete">
                       <i class="bx bxs-trash-alt"></i>
                   </a>
               </div>';
                })
                ->rawColumns(['action','date','time'])
                ->make(true);
        }
        return view('backend.layouts.subscriptions.index');
    }

    public function destroy($id)
    {
        try {
            // 🔍 Find the existing record
            $data = Subscription::findOrFail($id);



            // ❌ Delete the record from the database
            $data->delete();

            // ✅ Redirect back with a success message
            return response()->json(['success' => true, 'message' => 'Data deleted successfully.']);
        } catch (\Exception $e) {
            // ⚠️ Handle errors gracefully
            return response()->json(['errors' => true, 'message' => 'Data failed to delete']);
        }
    }
}
