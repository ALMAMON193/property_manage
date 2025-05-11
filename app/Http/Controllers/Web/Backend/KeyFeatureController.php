<?php

namespace App\Http\Controllers\Web\Backend;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\KeyFeature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class KeyFeatureController extends Controller
{
    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $data = KeyFeature::latest()->get();
                return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('category', function ($data) {
                        return $data->category->name;
                    })

                    ->addColumn('image', function ($data) {
                        $url = $data->image ? asset($data->image) : asset('no-image.png');
                        return '<img src="' . $url . '" alt="image" class="img-fluid" style="height:50px; width:50px">';
                    })

                    ->addColumn('action', function ($data) {
                        return '
                        <a href="' . route('admin.key_feature.edit', $data->id) . '" class="btn btn-warning btn-sm"><i class="ri-edit-2-line"></i> Edit</a>
                        <a href="#" onclick="deleteAlert(' . $data->id . ')" class="btn btn-danger btn-sm"><i class="ri-delete-bin-line" id="custom-sa-warning"></i> Delete</a>';
                    })
                    ->rawColumns(['description','image', 'action'])
                    ->make(true);
            }
            return view('backend.layouts.keyfeatures.index');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }


    public function create()
    {
        $categories = Category::all();
        return view('backend.layouts.keyfeatures.create', compact('categories'));
    }

    /*public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'file' => 'required|file|mimetypes:application/json,text/plain|max:2048',
        ]);

        // Decode the JSON file content
        $data = json_decode($request->file('file')->get(), true);

        if (!$data || !is_array($data)) {
            return response()->json(['error' => 'Invalid JSON structure'], 400);
        }

        try {
            $finalData = []; // This array will hold all the processed data
            $storedCount = 0; // Counter for stored/updated key features

            // Start a database transaction
            DB::beginTransaction();

            // Iterate through each description in the received JSON data
            foreach ($data as $key => $items) {
                if (is_array($items)) {
                    foreach ($items as $item) {
                        // Extract the calibers from the name, handle multiple calibers
                        $calibers = explode(',', $item['name']);
                        foreach ($calibers as $caliber) {
                            // Trim spaces and remove parentheses for calibers
                            $caliber = trim(preg_replace('/\([^)]*\)/', '', $caliber));

                            // Prepare the data to be returned
                            $record = [
                                'category_id' => $request->category_id,
                                'caliber' => $caliber,
                                'bullet_type' => $item['bulletTypeAndConstruction'] ?? ($item['shotTypeShellConstruction'] ?? null),
                                'muzzle_velocity' => $item['muzzleVelocity'] ?? null,
                                'muzzle_energy' => $item['muzzleEnergy'] ?? null,
                                'compatibility' => $item['compatibility'] ?? null,
                                'use_case' => $item['idealUseCase'] ?? null,
                                'image' => strtolower($item['image']) ?? null,
                            ];

                            // Add the record to the final data array
                            $finalData[] = $record;

                            // Update or create the record in the database
                            KeyFeature::updateOrCreate(
                                [
                                    'category_id' => $request->category_id,
                                    'caliber' => $caliber,
                                ],
                                [
                                    'bullet_type' => $record['bullet_type'],
                                    'muzzle_velocity' => $record['muzzle_velocity'],
                                    'muzzle_energy' => $record['muzzle_energy'],
                                    'compatibility' => $record['compatibility'],
                                    'use_case' => $record['use_case'],
                                    'image' => $record['image'],
                                ]
                            );

                            $storedCount++; // Increment the counter
                        }
                    }
                }
            }

            // Commit the transaction
            DB::commit();

            // Return with a success message including the count
            return redirect()->back()->with('t-success', "{$storedCount} key features stored/updated successfully!");
        } catch (\Exception $e) {
            // Rollback the transaction
            DB::rollBack();

            // Log the error for debugging purposes
            \Log::error('Error storing JSON data: ' . $e->getMessage());

            // Return a response with an error message
            return redirect()->back()->with('t-error', 'An error occurred while processing the file. Please try again.');
        }
    }*/


    public function store(Request $request)
    {
        // ✅ Validate the incoming request
        $request->validate([
            'category_id'     => 'required|exists:categories,id',
            'caliber_names'   => 'required|string|max:255',
            'bullet_type'     => 'nullable|string',
            'muzzle_velocity' => 'nullable|string',
            'muzzle_energy'   => 'nullable|string',
            'compatibility'   => 'nullable|string',
            'use_case'        => 'nullable|string',
            'image'           => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // 🗂️ Prepare data for insertion
        $data = [
            'category_id'     => $request->category_id,
            'caliber_names'   => collect(explode(';', $request->caliber_names))
                ->map(fn($item) => preg_replace('/\s+/', ' ', trim($item)))
                ->filter()
                ->implode(';'),
            'bullet_type'     => $request->bullet_type,
            'muzzle_velocity' => $request->muzzle_velocity,
            'muzzle_energy'   => $request->muzzle_energy,
            'compatibility'   => $request->compatibility,
            'use_case'        => $request->use_case,
        ];
        // 📤 Handle image upload if present
        $file = 'image';
        if ($request->hasFile($file)) {
            // Upload the new file
            $randomString = Str::random(10);
            $data[$file]  = Helper::fileUpload($request->file($file), 'keyfeatures', $randomString);
        }
        //dd($data);

        try {
            // 💾 Save the data to the database
            KeyFeature::create($data);

            // ✅ Redirect back with a success message
            return redirect()->back()->with('t-success', 'Key feature added successfully!');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('t-error', $e->getMessage());
        }
    }


    public function edit($id)
    {
        $keyFeature = KeyFeature::findOrFail($id);
        $categories = Category::all();
        return view('backend.layouts.keyfeatures.edit', compact('categories', 'keyFeature'));
    }


    public function update(Request $request, $id)
    {
        // ✅ Validate the incoming request
        $request->validate([
            'category_id'     => 'required|exists:categories,id',
            'caliber_names'   => 'required|string|max:255',
            'bullet_type'     => 'nullable|string',
            'muzzle_velocity' => 'nullable|string',
            'muzzle_energy'   => 'nullable|string',
            'compatibility'   => 'nullable|string',
            'use_case'        => 'nullable|string',
            'image'           => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // 🔍 Find the existing key feature
        $keyFeature = KeyFeature::findOrFail($id);

        // 🗂️ Prepare updated data
        $data = [
            'category_id'     => $request->category_id,
            'caliber_names'   => collect(explode(';', $request->caliber_names))
                ->map(fn($item) => preg_replace('/\s+/', ' ', trim($item)))
                ->filter()
                ->implode(';'),
            'bullet_type'     => $request->bullet_type,
            'muzzle_velocity' => $request->muzzle_velocity,
            'muzzle_energy'   => $request->muzzle_energy,
            'compatibility'   => $request->compatibility,
            'use_case'        => $request->use_case,
        ];

        // 📤 Handle image removal if flagged
        if ($request->has('remove_image') && $request->remove_image == 1) {
            if ($keyFeature->image && file_exists(public_path($keyFeature->image))) {
                Helper::fileDelete(public_path($keyFeature->image)); // remove file
            }
            $data['image'] = null; // set DB field to null
        }

        // 📤 Handle new image upload if present
        if ($request->hasFile('image')) {
            // Optional: delete old one just in case
            if ($keyFeature->image && file_exists(public_path($keyFeature->image))) {
                Helper::fileDelete(public_path($keyFeature->image));
            }

            $randomString = Str::random(10);
            $data['image'] = Helper::fileUpload($request->file('image'), 'keyfeatures', $randomString);
        }

        try {
            // 🔄 Update the key feature
            $keyFeature->update($data);

            return redirect()->back()->with('t-success', 'Key feature updated successfully!');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('t-error', $e->getMessage());
        }
    }


    public function destroy($id)
    {
        try {
            // 🔍 Find the existing record
            $keyFeature = KeyFeature::findOrFail($id);

            // 🗑️ Delete the associated image if it exists
            if ($keyFeature->image && file_exists(public_path($keyFeature->image))) {
                Helper::fileDelete($keyFeature->image);
            }

            // ❌ Delete the record from the database
            $keyFeature->delete();

            // ✅ Redirect back with a success message
            return response()->json(['success' => true, 'message' => 'Data deleted successfully.']);
        } catch (\Exception $e) {
            // ⚠️ Handle errors gracefully
            return response()->json(['errors' => true, 'message' => 'Data failed to delete']);
        }
    }
}
