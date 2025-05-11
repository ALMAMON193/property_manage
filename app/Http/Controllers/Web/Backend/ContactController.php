<?php

namespace App\Http\Controllers\Web\Backend;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Contact::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('comment', function ($data) {
                    // Strip HTML tags and truncate the content
                    $comment = strip_tags($data->comment);
                    return $comment;
                })
                ->addColumn('date', function ($data) {
                    return $data->created_at->format('Y-m-d');  // Example: 2025-02-24
                })
                ->addColumn('time', function ($data) {
                    return $data->created_at->format('H:i:s');  // Example: 14:35:22
                })
                ->addColumn('action', function ($data) {
                    return '<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                   <a href="' . route('admin.contact.view', $data->id) . '" class="btn btn-primary text-white" title="View">
                       <i class="mdi mdi-eye"></i>
                   </a>
                   <a href="#" onclick="deleteAlert(' . $data->id . ')" class="btn btn-danger text-white" title="Delete">
                       <i class="bx bxs-trash-alt"></i>
                   </a>
               </div>';
                })
                ->rawColumns(['action','comment','date','time'])
                ->make();
        }
        return view('backend.layouts.contacts.index');
    }

    public function destroy($id)
    {
        try {
            // 🔍 Find the existing record
            $data = Contact::findOrFail($id);



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
