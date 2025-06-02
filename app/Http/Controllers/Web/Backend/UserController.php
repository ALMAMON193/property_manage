<?php

namespace App\Http\Controllers\Web\Backend;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $data = User::where('user_type','user')->latest()->get();
                return DataTables::of($data)
                    ->addIndexColumn()

                    ->addColumn('action', function ($data) {
                        return '
                        <a href="#" onclick="deleteAlert(' . $data->id . ')" class="btn btn-danger btn-sm"><i class="ri-delete-bin-line" id="custom-sa-warning"></i> Delete</a>';
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
            return view('backend.layouts.users.index');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    public function destroy($id)
    {
        try {
            // 🔍 Find the existing record
            $user = User::findOrFail($id);

            // 🗑️ Delete the associated image if it exists
            if ($user->image && file_exists(public_path($user->image))) {
                Helper::fileDelete($user->image);
            }

            // ❌ Delete the record from the database
            $user->delete();

            // ✅ Redirect back with a success message
            return response()->json(['success' => true, 'message' => 'Data deleted successfully.']);
        } catch (\Exception $e) {
            // ⚠️ Handle errors gracefully
            return response()->json(['errors' => true, 'message' => 'Data failed to delete']);
        }
    }
}
