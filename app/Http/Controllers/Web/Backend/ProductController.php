<?php
namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Retailer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $data = Product::latest()->get();
                return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('retailer', function ($data) {
                        return $data->retailer->title;
                    })

                    ->addColumn('sponsored', function ($data) {
                        $isSponsored = $data->sponsored === 1;
                        return '
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input status-switcher"
                                    '.($isSponsored ? 'checked' : '').'
                                    onchange="showSponsoredChangeAlert(event, this, '.$data->id.')">
                            </div>
                        ';
                    })

                    ->addColumn('action', function ($data) {
                        return '
                        <a href="' . route('admin.product.edit', $data->id) . '" class="btn btn-info btn-sm"><i class="ri-eye-fill"></i> view</a>
                        ';
                    })
                    ->rawColumns(['retailer', 'sponsored', 'action'])
                    ->make(true);
            }
            return view('backend.layouts.products.index');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }


    public function create()
    {
        return view('backend.layouts.products.create');
    }



    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'retailer_website'  => 'required|url',
            'data_url'  => 'required|url|unique:retailers,data_url',
            'title'  => 'required|string',
            'update_interval'  => 'required|string',
            'type' => 'required|in:1,2', // 1 = XML, 2 = JSON, 3 = Structured Text
        ]);

        $retailerWebsite  = $request->input('retailer_website');
        $dataUrl  = $request->input('data_url');
        $title  = $request->input('title');
        $updateInterval  = $request->input('update_interval');
        $fileType = $request->input('type'); // Type provided by user (1=XML, 2=JSON)

        // Fetch Data from the URL
        $response = Http::get($dataUrl);

        // Check if request failed
        if ($response->failed()) {
            return redirect()->back()->with('t-error', 'Failed to fetch the URL');
        }

        $content = $response->body();

        // **Auto Detect Data Type if Not Provided**
        if ($fileType == 1 || $this->isXml($content)) {
            return $this->processXml($content, $retailerWebsite, $dataUrl, $title, $fileType, $updateInterval);
        } elseif ($fileType == 2 || $this->isJson($content)) {
            return $this->processJson($content, $retailerWebsite, $dataUrl, $title, $fileType, $updateInterval);
        } else {
            return redirect()->back()->with('t-error', 'Invalid data format. Expected XML, or JSON.');
        }

    }  /*end store method*/



    public function update($id)
    {
        // Fetch the retailer by ID
        $retailer = Retailer::find($id);

        if (!$retailer) {
            return response()->json(['error' => 'Retailer not found'], 404);
        }

        // Validate the `update_interval`
        if ($retailer->update_interval === 'never') {
            return response()->json(['message' => 'Updates are disabled for this retailer'], 200);
        }

        // Fetch data from the retailer's data URL
        $response = Http::get($retailer->data_url);

        if ($response->failed()) {
            return response()->json(['error' => 'Failed to fetch the retailer URL'], 500);
        }

        $content = $response->body();

        // Detect the data type and process it accordingly
        if ($retailer->type === 'xml' || $this->isXml($content)) {
            return $this->processXml($content, $retailer->retailer_website, $retailer->data_url, $retailer->title, $retailer->type, $retailer->update_interval);
        } elseif ($retailer->type === 'json' || $this->isJson($content)) {
            return $this->processJson($content, $retailer->retailer_website, $retailer->data_url, $retailer->title, $retailer->type, $retailer->update_interval);
        } else {
            return response()->json(['error' => 'Invalid data format. Expected XML or JSON.'], 400);
        }
    } /*========== end update method ============*/


    /*=============== SPONSORED =============*/
    public function status(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found.'
            ], 404);
        }

        // Update sponsored status if provided
        if ($request->has('sponsored')) {
            $product->sponsored = (bool) $request->input('sponsored');
            $product->save();

            return response()->json([
                'success' => true,
                'message' => 'Sponsored status updated successfully.'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No valid status field provided.'
        ], 400);
    }

    private function isXml($content)
    {
        libxml_use_internal_errors(true);
        $xml = simplexml_load_string($content);
        return $xml !== false;
    }

    private function isJson($content)
    {
        json_decode($content);
        return json_last_error() === JSON_ERROR_NONE;
    }

    private function isStructuredText($content)
    {
        // Check for common delimiters: comma, tab, pipe, semicolon
        return (substr_count($content, ",") > 1 || substr_count($content, "\t") > 1 || substr_count($content, "|") > 1 || substr_count($content, ";") > 1);
    }

    private function processXml($xmlContent, $retailerWebsite, $dataUrl, $title, $fileType, $updateInterval)
    {
        try {
            // Start a database transaction
            DB::beginTransaction();

            $xml = simplexml_load_string($xmlContent, "SimpleXMLElement", LIBXML_NOCDATA);

            if (!$xml) {
                return response()->json(['error' => 'Invalid XML format'], 500);
            }

            $products = [];

            foreach ($xml->product as $product) {
                // Determine the type of the product (handle all 3 XML formats)
                $type = null;

                // Case 1: Check for "type" tag inside the product
                if (isset($product->type)) {
                    $type = strtolower(trim((string) $product->type));
                }

                // Case 2: Check for "Type" attribute in the product tag
                if (!$type && isset($product["Type"])) {
                    $type = strtolower(trim((string) $product["Type"]));
                }

                // Case 3: Check for the presence of the "ammunition" tag as a fallback
                if (!$type && isset($product->ammunition)) {
                    $type = "ammunition";
                }

                // Skip products that are not "ammunition"
                if ($type !== "ammunition") {
                    continue;
                }

                $products[] = [
                    'type'            => $type,
                    'title'           => isset($product->title) ? trim((string) $product->title) : null,
                    'brand'           => isset($product->brand) ? trim((string) $product->brand) : null,
                    'caliber'         => isset($product->caliber) ? trim((string) $product->caliber) : null,
                    'url'             => isset($product->url) ? trim((string) $product->url) : null,
                    'grains'          => isset($product->grains)
                        ? (int) trim((string) $product->grains)
                        : (isset($product->grain)
                            ? (int) trim((string) $product->grain)
                            : null),
                    'price'           => isset($product->price) ? (float) trim((string) $product->price) : null,
                    'condition'       => isset($product->condition) ? trim((string) $product->condition) : "New",
                    'casing'          => isset($product->casing) ? trim((string) $product->casing) : null,
                    'numrounds'       => isset($product->numrounds) ? (int) trim((string) $product->numrounds) : null,
                    'cost_per_round'  => (isset($product->price) && isset($product->numrounds) && (int) $product->numrounds > 0)
                        ? round((float) trim((string) $product->price) / (int) trim((string) $product->numrounds), 3)
                        : null,
                    'purchaselimit'   => isset($product->purchaselimit) ? (int) trim((string) $product->purchaselimit) : null,
                ];

            }

            $existingRetailer = Retailer::where('data_url', $dataUrl)->first();
            $existingUrls = [];
            if ($existingRetailer) {
                $existingUrls = Product::where('retailer_id', $existingRetailer->id)->pluck('url');
            }

            if (count($existingUrls) > 0) {
                // Extract the URLs from the $products array
                $productUrls = array_column($products, 'url');

                // Find the URLs to delete (existing URLs that are not in the new products)
                $urlsToDelete = $existingUrls->filter(function ($url) use ($productUrls) {
                    return !in_array($url, $productUrls);
                });

                // Delete products with those URLs
                Product::where('retailer_id', $existingRetailer->id)
                    ->whereIn('url', $urlsToDelete)
                    ->delete();
            }

            // Store retailer data
            $retailer = Retailer::updateOrCreate(
                ['data_url' => $dataUrl],
                [
                    'retailer_website' => $retailerWebsite,
                    'title' => $title,
                    'update_interval' => $updateInterval,
                    'type' => $fileType,
                ]
            );

            foreach ($products as $product) {
                $updatedProduct = Product::updateOrCreate(
                    [
                        'retailer_id'   => $retailer->id,
                        'url'           => $product['url'],
                    ],
                    [
                        'title'         => $product['title'],
                        'brand'         => $product['brand'],
                        'caliber'       => $product['caliber'],
                        'limit'         => $product['purchaselimit'],
                        'price'         => $product['price'],
                        'url'           => $product['url'],
                        'grains'        => $product['grains'],
                        'num_of_rounds' => $product['numrounds'],
                        'cost_per_round' => $product['cost_per_round'],
                        'condition'     => $product['condition'],
                        'casing'        => $product['casing'],
                    ]
                );
                $updatedProduct->touch();
            }

            // Commit the transaction
            DB::commit();

            Log::info("XML Products processed successfully");

            return redirect()->back()->with('t-success', count($products).' XML data stored successfully!');

        } catch (\Exception $e) {
            // Rollback the transaction
            DB::rollBack();

            // Log the error for debugging
            Log::error("Error processing XML: " . $e->getMessage(), ['stack' => $e->getTraceAsString()]);

            return redirect()->back()->with('t-error', 'An error occurred while processing XML data.');
        }
    }


    /*private function processStructuredText($textContent)
    {
        $delimiter = $this->detectDelimiter($textContent);
        if (! $delimiter) {
            return response()->json(['error' => 'Unsupported structured text format'], 400);
        }

        $lines   = explode("\n", trim($textContent));           // Split into lines
        $headers = str_getcsv(array_shift($lines), $delimiter); // Get headers

        $products = [];

        foreach ($lines as $line) {
            $data = str_getcsv($line, $delimiter);
            if (count($data) !== count($headers)) {
                continue;
            }
            // Skip malformed rows

            $product = array_combine($headers, $data);

            $products[] = [
                'ammunition'    => $product['ammunition'] ?? null,
                'title'         => $product['title'] ?? null,
                'brand'         => $product['brand'] ?? null,
                'caliber'       => $product['caliber'] ?? null,
                'url'           => $product['url'] ?? null,
                'grains'        => isset($product['grains']) ? (int) $product['grains'] : null,
                'price'         => isset($product['price']) ? (float) $product['price'] : null,
                'condition'     => $product['condition'] ?? null,
                'casing'        => $product['casing'] ?? null,
                'numrounds'     => isset($product['numrounds']) ? (int) $product['numrounds'] : null,
                'purchaselimit' => isset($product['purchaselimit']) ? (int) $product['purchaselimit'] : null,
            ];
        }
        return response()->json(['message' => 'Structured text data stored successfully', 'products' => $products]);

        // **Store Structured Text Data in Database**
        foreach ($products as $product) {
            Product::updateOrCreate(
                ['title' => $product['title']],
                $product
            );
        }

        return response()->json(['message' => 'Structured text data stored successfully', 'products' => $products]);
    }*/


    /*============================== PROCESS JSON ========================*/
    private function processJson($jsonContent, $retailerWebsite, $dataUrl, $title, $fileType, $updateInterval)
    {
        try {
            $jsonData = json_decode($jsonContent, true);

            if (!$jsonData) {
                return response()->json(['error' => 'Invalid JSON format'], 400);
            }

            DB::beginTransaction(); // Start transaction

            $products = [];

            // Create or update retailer
            $retailer = Retailer::updateOrCreate(
                ['data_url' => $dataUrl],
                [
                    'retailer_website' => $retailerWebsite,
                    'title' => $title,
                    'update_interval' => $updateInterval,
                    'type' => $fileType,
                ]
            );

            foreach ($jsonData as $key => $product) {
                // Filter products by type "ammunition"
                if (
                    !isset($product['attributes']['pa_product-type']) ||
                    strtolower(trim($product['attributes']['pa_product-type'])) !== 'ammunition'
                ) {
                    continue;
                }

                // Calculate cost_per_round
                $price = isset($product['price']) ? (float) number_format($product['price'], 3, '.', '') : null;
                $num_of_rounds = isset($product['attributes']['pa_number-of-rounds']) ? (int) $product['attributes']['pa_number-of-rounds'] : null;
                $cost_per_round = ($price && $num_of_rounds && $num_of_rounds > 0) ? $price / $num_of_rounds : null;

                $productData = [
                    'title'         => $product['title'] ?? ($product['description'] ?? null),
                    'brand'         => $product['attributes']['pa_manufacturer'] ?? null,
                    'caliber'       => $product['caliber'] ?? null,
                    'url'           => $product['url'] ?? null,
                    'price'         => $price,
                    'condition'     => $product['attributes']['pa_condition'] ?? null,
                    'casing'        => $product['attributes']['pa_casing'] ?? null,
                    'num_of_rounds' => $num_of_rounds,
                    'cost_per_round' => $cost_per_round,
                    'limit'         => null, // JSON Data doesn't provide purchase limit
                ];

                $products[] = $productData;

                // Insert or update product
                Product::updateOrCreate(
                    [
                        'retailer_id' => $retailer->id,
                        'url'         => $productData['url'],
                    ],
                    [
                        'title'         => $productData['title'],
                        'brand'         => $productData['brand'],
                        'caliber'       => $productData['caliber'],
                        'limit'         => $productData['limit'],
                        'price'         => $productData['price'],
                        'url'           => $productData['url'],
                        'num_of_rounds' => $productData['num_of_rounds'],
                        'cost_per_round' => $productData['cost_per_round'],
                        'condition'     => $productData['condition'],
                        'casing'        => $productData['casing'],
                        'created_at'    => Carbon::now(),
                        'updated_at'    => Carbon::now(),
                    ]
                );
            }

            DB::commit(); // Commit transaction

            $dataCount = count($products);

            return redirect()->back()->with('t-success', $dataCount . ' products added successfully!');

        } catch (\Exception $e) {
            DB::rollBack(); // Rollback transaction on error
            Log::error('Error storing JSON data: ' . $e->getMessage()); // Log the error

            return response()->json(['error' => 'An error occurred while processing the data'], 500);
        }
    }



}
