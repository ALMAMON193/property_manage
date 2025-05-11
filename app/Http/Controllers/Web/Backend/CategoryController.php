<?php

namespace App\Http\Controllers\Web\Backend;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Category::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()

                ->addColumn('action', function ($data) {
                    return '<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">

                   <a href="#" onclick="deleteAlert(' . $data->id . ')" class="btn btn-danger text-white" title="Delete">
                       <i class="bx bxs-trash-alt"></i>
                   </a>
               </div>';
                })
                ->rawColumns(['action'])
                ->make();
        }
        return view('backend.layouts.categories.index');
    }

    public function store(Request $request)
    {
        // ✅ Validate the incoming request
        $request->validate([
            'name'   => 'required|string|max:255'
        ]);

        // 🗂️ Prepare data for insertion
        $data = [
            'name'   => $request->name,
        ];

        try{


            // 💾 Save the data to the database
            Category::create($data);

            // ✅ Redirect back with a success message
            return redirect()->back()->with('t-success', 'Category added successfully!');
        }catch(\Exception $e){
            return redirect()->back()->with('t-error', $e->getMessage());
        }
    }


    public function destroy($id)
    {
        try {
            // 🔍 Find the existing record
            $data = Category::findOrFail($id);


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
