<?php

namespace App\Http\Controllers\Backend;

use App\Exports\AttributeExport;
use App\Exports\CertificatesExport;
use App\Exports\ImagesExport;
use App\Exports\VideosExport;
use App\Http\Controllers\Controller;
use App\Jobs\BulkGemstoneImport;
use App\Jobs\BulkImport;
use App\Jobs\BulkVariantImport;
use App\Models\Category;
use App\Models\FailedProductImage;
use App\Models\ImportedFile;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductImportFile;
use App\Models\VariantImportFile;
use App\Models\VariantProduct;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Maatwebsite\Excel\Facades\Excel;

class BulkUploadController extends Controller
{
    public function dashboard()
    {
        return view('bulkupload.dashboard');
    }

    public function index()
    {
        $categories = Category::all();

        return view('bulkupload.product_index', compact('categories'));
    }

    public function attribute_download(Request $request)
    {
        $selected_cat = $request->selected_cat;
        $cat_slug = Category::select('slug')->where('id', $selected_cat)->first();
        $current_timestamp = Carbon::now()->timestamp;
        $file_name = 'sampleattributes-' . $cat_slug->slug . '-' . $current_timestamp . '';

        return Excel::download(new AttributeExport($selected_cat), '' . $file_name . '.csv');
    }

    public function sample_download(Request $request)
    {
        if ($request->selected_cat == '9') {
            $filePath = public_path('sample_files/sampleallproducts-gemstone.csv');
        } else {
            $filePath = public_path('sample_files/sampleallproducts.csv');
        }
        if (!file_exists($filePath)) {
            return response()->back()->with('error', 'File not found.');
        }
        $selected_cat = $request->selected_cat;
        $cat_slug = Category::select('slug')->where('id', $selected_cat)->first();
        $current_timestamp = Carbon::now()->timestamp;
        $file_name = 'sampleproducts-' . $cat_slug->slug . '-' . $current_timestamp . '.csv';

        return response()->download($filePath, $file_name);
    }

    public function sample_variant_download(Request $request)
    {
        $filePath = public_path('sample_files/samplevariants.csv');
        if (!file_exists($filePath)) {
            return response()->back()->with('error', 'File not found.');
        }
        // $selected_cat = $request->selected_cat;
        // $cat_slug = Category::select('slug')->where('id',$selected_cat)->first();
        $current_timestamp = Carbon::now()->timestamp;
        $file_name = 'samplevariants-' . $current_timestamp . '.csv';

        return response()->download($filePath, $file_name);
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt,text/csv,application/csv|max:2048', // Ensure the file is CSV, max size 2MB
        ]);
        if ($request->file('file')->isValid()) {
            if ($request->u_category == 9) {
                $headers = ['sr', 'SKU', 'family', 'tags', 'Slug', 'product status', 'avaliable stock qty', 'indicate limited stock quantity', 'minimum order qty', 'product title', 'product description', 'gender', 'size', 'unit', 'occasion', 'trend', 'design', 'style', 'brand', 'theme', 'measurements', 'measurement unit', 'quantity', 'quantity unit', 'gross weight', 'gross weight unit', 'net weight', 'net weight unit', 'made in', 'Popular Gemstone', 'Shape', 'Caret', 'Colour', 'Clarity', 'Cut', 'Teatment', 'laboratory', 'certificate no', 'certificate link', 'visiblity', 'draft', 'price type', 'diamond nature', 'diamond Fancy Colour', 'diamond Colour', 'diamond Carat', 'diamond Shape', 'diamond Clarity', 'diamond Cut', 'diamond Setting', 'Total Diamond Count', 'Diamond Price Per Carat', 'Pearl Type', 'Pearl Colour', 'Pearl Carat', 'Pearl', 'Pearl Shape', 'Pearl Grade', 'Pearl Setting', 'Total Pearl Count', 'Pearl Price Per Carat', 'Gemstone', 'Gemstone Type', 'Gemstone Colour', 'Gemstone Carat', 'Gemstone Shape', 'Gemstone Clarity', 'Gemstone Cut', 'Gemstone Setting', 'Total Gemstone Count', 'Gemstone Price Per Carat', 'price breakup', 'fix price', 'fix price discount type', 'fix price discount', 'making charges calculation', 'fixed making charge', 'making charge percentage', 'making charge discount type', 'making charges discount', 'diamond discount type', 'diamond discount charge', 'pearl discount type', 'pearl discount charges', 'gemstone discount type', 'gemstone discount charges', 'other charges', 'other charges discount type', 'other discount charges', 'national tax', 'minimum amount', 'payment gateway', 'cod', 'ccod', 'meta title', 'meta description', 'is_public'];
            } else {
                $headers = ['sr', 'SKU', 'family', 'tags', 'Slug', 'product status', 'avaliable stock qty', 'indicate limited stock quantity', 'minimum order qty', 'product title', 'product description', 'gender', 'size', 'unit', 'occasion', 'trend', 'design', 'style', 'brand', 'theme', 'measurements', 'measurement unit', 'quantity', 'quantity unit', 'gross weight', 'gross weight unit', 'net weight', 'net weight unit', 'made in', 'metal purity', 'metal color', 'metal weight', 'weight unit', 'laboratory', 'certificate no', 'certificate link', 'visiblity', 'draft', 'price type', 'diamond nature', 'diamond Fancy Colour', 'diamond Colour', 'diamond Carat', 'diamond Shape', 'diamond Clarity', 'diamond Cut', 'diamond Setting', 'Total Diamond Count', 'Diamond Price Per Carat', 'Pearl Type', 'Pearl Colour', 'Pearl Carat', 'Pearl', 'Pearl Shape', 'Pearl Grade', 'Pearl Setting', 'Total Pearl Count', 'Pearl Price Per Carat', 'Gemstone', 'Gemstone Type', 'Gemstone Colour', 'Gemstone Carat', 'Gemstone Shape', 'Gemstone Clarity', 'Gemstone Cut', 'Gemstone Setting', 'Total Gemstone Count', 'Gemstone Price Per Carat', 'price breakup', 'fix price', 'fix price discount type', 'fix price discount', 'making charges calculation', 'fixed making charge', 'making charge percentage', 'making charge discount type', 'making charges discount', 'diamond discount type', 'diamond discount charge', 'pearl discount type', 'pearl discount charges', 'gemstone discount type', 'gemstone discount charges', 'other charges', 'other charges discount type', 'other discount charges', 'national tax', 'minimum amount', 'payment gateway', 'cod', 'ccod', 'meta title', 'meta description', 'is_public'];
            }
            $file = $request->file('file');
            $filePath = $file->getRealPath(); // Get the real path of the uploaded file
            $headerRow = null;
            $csvData = array_map('str_getcsv', file($filePath));
            if (count($csvData) > 0) {
                $headerRow = $csvData[0];

                $headerRow = array_map('trim', $headerRow);
                $headers = array_map('trim', $headers);
                if (count(array_diff_assoc($headerRow, $headers)) === 0) {
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $SfilePath = $file->storeAs('public/files/product_imported_files', $fileName);
                    $import_file = new ProductImportFile;
                    $import_file->category = isset($request->u_category) ? $request->u_category : null;
                    $import_file->file_name = isset($fileName) ? $fileName : null;
                    $import_file->status = 'Pending';
                    $import_file->publish_status = 'Pending';
                    $import_file->progress = 0;
                    $import_file->save();
                    if ($request->u_category == 9) {
                        BulkGemstoneImport::dispatch($import_file->id);
                    } else {
                        BulkImport::dispatch($import_file->id);
                    }

                    return redirect()->route('bulk.product.upload')->with('success', 'Product Imported Successfully');
                } else {
                    return redirect()->back()->with('error', 'Invalid CSV file.');
                }
            } else {
                return redirect()->back()->with('error', 'Invalid CSV file.');
            }
        } else {
            return redirect()->back()->with('error', 'File upload failed.');
        }
    }

    public function file_list(Request $request)
    {
        $perPage = $request->input('length', 10);
        $page = $request->input('start', 0) / $perPage;
        $ids = $request->input('ids', []); // Get IDs for refreshing specific rows
        $isRefresh = $request->input('refresh', false); // Check if this is a refresh request
        if ($isRefresh == 'true') {
            // Refresh request logic
            $product_list = ProductImportFile::whereIn('id', $ids)->with('getcategory')->get();
            $totalRecords = count($ids); // Total records in this refresh request
        } else {
            // Initial request logic
            $query = ProductImportFile::select('*');
            $totalRecords = $query->count();
            $product_list = $query->with('getcategory')
                ->latest()
                ->skip($page * $perPage)
                ->take($perPage)
                ->get();
        }

        $counter = $page * $perPage + 1;
        $product_list->transform(function ($item) use (&$counter) {
            $item['ser_id'] = $counter++;
            $item['cat'] = isset($item->getcategory->category) ? $item->getcategory->category : '-';

            if (isset($item->file_name)) {
                $fileUrl = asset('storage/files/product_imported_files/' . $item->file_name);
                $item['file'] = '<a href="' . $fileUrl . '" download="' . $item->file_name . '">' . $item->file_name . '</a>';
            } else {
                $item['file'] = '-';
            }

            if (isset($item->invalid_filename) && $item->invalid_filename != null) {
                $item['invalid_file'] = '<a href="' . asset('importstatusfiles/' . $item->invalid_filename) . '" download="' . $item->invalid_filename . '">' . $item->invalid_filename . '</a>';
            } else {
                $item['invalid_file'] = '-';
            }

            $item['status'] = match ($item->status) {
                'Pending' => '<span class="p_status" style="background: #ff6000;">Pending</span>',
                'Completed' => '<span class="p_status" style="background: green;">Completed</span>',
                default => '<span class="p_status" style="background: red;">Failed</span>',
            };
            if (isset($item->progress) && $item->progress != null) {
                $roundedProgress = round($item->progress);

                // Use the rounded value in your HTML
                $item['progress'] = '<div role="progressbar" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100" style="--value:' . $roundedProgress . '"></div>';
                // $item['progress'] = '<div><div class="progress-container"><div class="progress" style="width:'.$item->progress.'%;"></div><div class="percentage" style="left:'.$item->progress.'%">'.$item->progress.'%</div></div></div>';
            } else {
                $item['progress'] = '-';
            }

            $item['publish'] = $item->publish_status !== 'Completed' ? '<button class="btn table-filter-btn publish_btn" type="button" data-id="' . $item->id . '">Go Live</button>' : 'Completed';

            $item['f_updated_at'] = Carbon::parse($item->updated_at)->format('Y-m-d H:i:s');

            return $item;
        });

        return response()->json([
            'draw' => $request->input('draw'),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $product_list,
        ]);
    }
    // public function publish_product(Request $request)
    // {
    //     if(isset($request->file_id) && $request->file_id != null && $request->file_id != '') {
    //         $products = Product::where('file_id', $request->file_id)
    //             ->whereHas('checkproductimages', function($query) {
    //                 $query->where('type', 'simple');
    //             })
    //             ->update(['visiblity' => 1]);

    //         if ($products) {
    //             ProductImportFile::where('id', $request->file_id)->update(['publish_status' => 'Completed']);
    //             return response()->json(['status' => 1, 'message' => 'Products Published Successfully']);
    //         } else {
    //             return response()->json(['status' => 0, 'message' => 'Product Not Having Images, Please Upload images First!']);
    //         }
    //     } else {
    //         return response()->json(['status' => 0, 'message' => 'Invalid File ID']);
    //     }
    // }

    public function publish_product(Request $request)
    {
        if (isset($request->file_id) && $request->file_id != null && $request->file_id != '') {
            if (isset($request->checkproduct)) {
                $products_count = Product::where('file_id', $request->file_id)
                    ->whereHas('checkproductimages', function ($query) {
                        $query->where('type', 'simple');
                    })->count();
                if (isset($products_count) && $products_count > 0) {
                    return response()->json(['status' => 1, 'message' => '']);
                } else {
                    return response()->json(['status' => 0, 'message' => 'Product Not Having Images, Please Upload images First!']);
                }
            } else {
                $products = Product::where('file_id', $request->file_id)->update(['visiblity' => 1]);
                if (!$products) {
                    return response()->json(['status' => 0, 'message' => 'No Products Found!']);
                } else {
                    ProductImportFile::where('id', $request->file_id)->update(['publish_status' => 'Completed']);

                    return response()->json(['status' => 1, 'message' => 'Products Published Successfully']);
                }
            }
        } else {
            return response()->json(['status' => 0, 'message' => 'Invalid File ID']);
        }
    }

    // Bulk Product Images
    public function image_index()
    {
        return view('bulkupload.product_img_index');
    }

    public function image_store(Request $request)
    {
        if ($request->hasFile('all_imgs')) {
            $chunkSize = 50;
            $chunks = array_chunk($request->file('all_imgs'), $chunkSize);

            foreach ($chunks as $chunk) {
                foreach ($chunk as $file) {
                    $filename = $file->getClientOriginalName();
                    $fileNameWithoutExt = pathinfo($filename, PATHINFO_FILENAME);
                    if (preg_match('/^([A-Za-z0-9]+)-([A-Za-z0-9]+)(?:-([A-Za-z0-9]+))?$/i', $fileNameWithoutExt, $matches)) {
                        $parts = array_slice($matches, 1);
                        $img_sku = count($parts) === 3 ? implode('-', array_slice($parts, 0, 2)) : $parts[0];
                        $lastElement = is_numeric($matches[count($matches) - 1]) ? $matches[count($matches) - 1] : '01';
                    } else {
                        $img_sku = $fileNameWithoutExt;
                        $lastElement = '01';
                    }
                    $withoutExtension = explode('.', $lastElement);
                    $check_product = Product::where('p_sku', $img_sku)->first();
                    $type = 'simple';
                    if (!$check_product) {
                        $check_product = VariantProduct::where('p_sku', $img_sku)->first();
                        $type = 'variant';
                    }
                    if (!$check_product) {
                        $folderPath = public_path('product_media/failed_images/');
                        $file->move($folderPath, $filename);
                        $failed_img = new FailedProductImage;
                        $failed_img->sku = isset($img_sku) ? $img_sku : null;
                        $failed_img->name = isset($filename) ? $filename : null;
                        $failed_img->priority = isset($withoutExtension[0]) ? $withoutExtension[0] : null;
                        $failed_img->save();
                    } else {
                        $extension = $file->getClientOriginalExtension();
                        $folderPath = public_path('product_media/product_images/');
                        $baseFilename = $img_sku . '-';

                        $newFilename = $baseFilename . $withoutExtension[0] . '.' . $extension;
                        $check_name = $img_sku . '-' . $withoutExtension[0];
                        $check_existing_img = ProductImage::where('sku_name', $check_name)->where('priority', $withoutExtension[0])->first();
                        if (isset($check_existing_img) && $check_existing_img != null) {
                            $file_path_l = public_path('product_media/product_images/' . $check_existing_img->sku_name);
                            if (File::exists(public_path('product_media/product_images/' . $check_existing_img->sku_name))) {
                                File::delete($file_path_l);
                            }
                            $file_path_r = public_path('product_media/product_images/300/' . $check_existing_img->sku_name);
                            if (File::exists(public_path('product_media/product_images/300/' . $check_existing_img->sku_name))) {
                                File::delete($file_path_r);
                            }
                            $file->move($folderPath, $newFilename);

                            $manager = new ImageManager(new Driver);
                            $image = $manager->read(base_path('/public/product_media/product_images/') . $newFilename);

                            $image = $image->resize(300, 300);
                            $image->save(base_path('/public/product_media/product_images/300/' . $newFilename));

                            $check_existing_img->product_id = isset($check_product->id) ? $check_product->id : null;
                            $check_existing_img->name = isset($newFilename) ? $newFilename : null;
                            $check_existing_img->type = isset($type) ? $type : 'simple';
                            $check_existing_img->priority = isset($withoutExtension[0]) ? $withoutExtension[0] : null;
                            $check_existing_img->sku_name = isset($check_name) ? $check_name : null;
                            $check_existing_img->save();
                        } else {
                            $file->move($folderPath, $newFilename);

                            $manager = new ImageManager(new Driver);
                            $image = $manager->read(base_path('/public/product_media/product_images/') . $newFilename);

                            $image = $image->resize(300, 300);
                            $image->save(base_path('/public/product_media/product_images/300/' . $newFilename));
                            $product_img = new ProductImage;
                            $product_img->product_id = isset($check_product->id) ? $check_product->id : null;
                            $product_img->name = isset($newFilename) ? $newFilename : null;
                            $product_img->type = isset($type) ? $type : 'simple';
                            $product_img->add_type = 'imported';
                            $product_img->priority = isset($withoutExtension[0]) ? $withoutExtension[0] : null;
                            $product_img->sku_name = isset($check_name) ? $check_name : null;
                            $product_img->save();
                        }
                    }
                }
            }

            return response()->json(['message' => 'Image uploaded successfully'], 200);
        }

        return response()->json(['message' => 'Please Upload Images'], 400);
    }

    public function image_list(Request $request)
    {
        $perPage = $request->input('length', 10);
        $page = $request->input('start', 0) / $perPage;
        $searchText = $request->input('search_text', '');
        $status = $request->input('status', '');

        $successQuery = ProductImage::with('product')
            ->where('add_type', 'imported')
            ->orderBy('created_at', 'desc');

        $failedQuery = FailedProductImage::latest();

        if ($searchText) {
            $successQuery->whereHas('product', function ($query) use ($searchText) {
                $query->where('p_sku', 'like', "%$searchText%");
            })->orWhereHas('variantProduct', function ($q) use ($searchText) {
                $q->where('p_sku', 'like', "%$searchText%");
            });
            $failedQuery->where('sku', 'like', "%$searchText%");
        }

        if ($status === 'completed') {
            $success_product_list = $successQuery->get();
            $failed_product_list = collect();
        } elseif ($status === 'p_n_f') {
            $success_product_list = collect();
            $failed_product_list = $failedQuery->get();
        } else {
            $success_product_list = $successQuery->get();
            $failed_product_list = $failedQuery->get();
        }

        $product_list = $success_product_list->merge($failed_product_list)->values();
        $sorted_by_created_at = $product_list->sortByDesc('created_at')->values();

        $grouped_by_product = $sorted_by_created_at->groupBy(function ($item) {
            return $item instanceof ProductImage ? $item->product_id : 'failed_' . $item->id;
        });

        $sorted_by_priority = $grouped_by_product->map(function ($group) {
            return $group->sortBy('priority')->values();
        });

        $final_sorted_list = $sorted_by_priority->flatten(1)->values();

        $totalRecords = $final_sorted_list->count();
        $paginatedList = $final_sorted_list->slice($page * $perPage, $perPage);

        $counter = $page * $perPage + 1;
        $paginatedList->transform(function ($item) use (&$counter) {
            $item['ser_id'] = $counter++;
            $url = '';
            if (isset($item['name'])) {
                if ($item instanceof ProductImage) {
                    $url = asset('product_media/product_images/300/' . $item['name']);
                } else {
                    $url = asset('product_media/failed_images/' . $item['name']);
                }
            }

            $item['img'] = '<img src="' . $url . '" style="width:100px;height:100px;">';

            if (isset($item['product_id']) && $item['product_id'] != null) {
                if ($item['type'] == 'simple') {
                    $product = Product::where('id', $item['product_id'])->first();
                } else {
                    $product = VariantProduct::where('id', $item['product_id'])->first();
                }
            }

            if ($item instanceof ProductImage) {
                $item['sku'] = $product->p_sku ?? '-';
                $item['status'] = 'Completed';
                $i_type = 'success';
            } else {
                $item['sku'] = isset($item['sku']) ? $item['sku'] : '-';
                $item['status'] = 'Product not found';
                $i_type = 'failed';
            }
            $item['i_priority'] = $item->priority ?? '-';
            $item['f_updated_at'] = Carbon::parse($item->updated_at)->format('Y-m-d H:i:s');
            $item['action'] = '<a href="javascript:;" data-href="' . route('bulk.product.image.list.delete', ['id' => $item['id'], 'type' => $i_type]) . '" class="table-btn table-btn1 delete" title="Click here for Delete Image"  ><img src="' . asset('images/dashbord/delete.png') . '" class="image-fuild" alt="user-img"></a>';

            return $item;
        });

        return response()->json([
            'draw' => $request->input('draw'),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $paginatedList->values()->all(),
        ]);
    }

    public function image_list_download(Request $request)
    {
        $search_text = $request->input('search_text');
        $status = $request->input('status');
        $current_timestamp = Carbon::now()->timestamp;
        $successQuery = ProductImage::with('product')->select('*')
            ->where('add_type', 'imported')
            ->latest();
        $failedQuery = FailedProductImage::latest();
        if (isset($search_text) && $search_text != '' && $search_text != null) {
            $successQuery->where(function ($query) use ($search_text) {
                $query->whereHas('product', function ($query) use ($search_text) {
                    $query->where('p_sku', 'like', "%{$search_text}%");
                })->orWhereHas('variantProduct', function ($q) use ($search_text) {
                    $q->where('p_sku', 'like', "%{$search_text}%");
                });
            });

            $failedQuery->where('sku', 'like', "%{$search_text}%");
        }
        if ($status == 'completed') {
            $success_product_list = $successQuery->get();
            $failed_product_list = collect(); // Empty collection
        } elseif ($status == 'p_n_f') {
            $success_product_list = collect(); // Empty collection
            $failed_product_list = $failedQuery->get();
        } else {
            $success_product_list = $successQuery->get();
            $failed_product_list = $failedQuery->get();
        }
        $product_list = $success_product_list->merge($failed_product_list)
            ->sortByDesc('created_at');

        $product_list = $success_product_list->merge($failed_product_list)
            ->sortByDesc('created_at');
        if (isset($product_list) && count($product_list) > 0) {
            return Excel::download(new ImagesExport($product_list), 'uploaded_images_' . $current_timestamp . '.xlsx');
        } else {
            return redirect()->back()->with('error', 'No Data found!');
        }
    }

    public function image_list_delete($id, $type)
    {
        if (isset($type) && $type != null && $type == 'success') {
            $image = ProductImage::find($id);
            if ($image) {
                $file_path_l = public_path('product_media/product_images/300/' . $image->name);
                $file_path_k = public_path('product_media/product_images/' . $image->name);
                if (File::exists(public_path('product_media/product_images/300/' . $image->name))) {
                    File::delete($file_path_l);
                }
                if (File::exists(public_path('product_media/product_images/' . $image->name))) {
                    File::delete($file_path_k);
                }
                $image->delete();

                return redirect()->route('bulk.product.image.upload')->with('error', 'Image Deleted Successfully');
            } else {
                return redirect()->route('bulk.product.image.upload')->with('error', 'Image Not Found!');
            }
        } else {
            $image = FailedProductImage::find($id);
            if ($image) {
                $file_path_l = public_path('product_media/failed_images/' . $image->name);

                if (File::exists(public_path('product_media/failed_images/' . $image->name))) {
                    File::delete($file_path_l);
                }
                $image->delete();

                return redirect()->route('bulk.product.image.upload')->with('error', 'Image Deleted Successfully');
            } else {
                return redirect()->route('bulk.product.image.upload')->with('error', 'Image Not Found!');
            }
        }
    }

    // Bulk Variants

    public function variant_index()
    {
        $categories = Category::all();

        return view('bulkupload.variant_index', compact('categories'));
    }

    public function variant_store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'file' => 'required|mimes:csv,txt,text/csv,application/csv|max:2048', // Ensure the file is CSV, max size 2MB
        ]);
        if ($request->file('file')->isValid()) {
            $headers = ['sr', 'Parent Product SKU', 'Child SKU', 'Product Type', 'Attributes'];
            $file = $request->file('file');
            $filePath = $file->getRealPath(); // Get the real path of the uploaded file
            $headerRow = null;
            $csvData = array_map('str_getcsv', file($filePath));
            if (count($csvData) > 0) {
                $headerRow = $csvData[0]; // First row of the CSV file (headers)

                $headerRow = array_map('trim', $headerRow);
                $headers = array_map('trim', $headers);
                // dd($headerRow);
                if (count(array_diff_assoc($headerRow, $headers)) === 0) {
                    $fileName = time() . '_' . $file->getClientOriginalName(); // Unique file name
                    $SfilePath = $file->storeAs('public/files/variant_imported_files', $fileName);
                    $import_file = new VariantImportFile;
                    $import_file->file_name = isset($fileName) ? $fileName : null;
                    $import_file->status = 'Pending';
                    $import_file->publish_status = 'Pending';
                    $import_file->progress = 0;
                    $import_file->save();
                    BulkVariantImport::dispatch($import_file->id);

                    return redirect()->route('bulk.variant.upload')->with('success', 'Variant Imported Successfully');
                } else {
                    return redirect()->back()->with('error', 'Invalid CSV file.');
                }
            } else {
                return redirect()->back()->with('error', 'Invalid CSV file.');
            }
        } else {
            return redirect()->back()->with('error', 'File upload failed.');
        }
    }

    public function variant_file_list(Request $request)
    {
        $perPage = $request->input('length', 10);
        $page = $request->input('start', 0) / $perPage;
        $ids = $request->input('ids', []); // Get IDs for refreshing specific rows
        $isRefresh = $request->input('refresh', false); // Check if this is a refresh request
        if ($isRefresh == 'true') {
            // Refresh request logic
            $product_list = VariantImportFile::whereIn('id', $ids)->get();
            $totalRecords = count($ids); // Total records in this refresh request
        } else {
            // Initial request logic
            $query = VariantImportFile::select('*');
            $totalRecords = $query->count();
            $product_list = $query->latest()
                ->skip($page * $perPage)
                ->take($perPage)
                ->get();
        }
        // $query = VariantImportFile::select('*');
        // $totalRecords = $query->count();
        // $product_list = $query->latest()
        //                     ->skip($page * $perPage)
        //                     ->take($perPage)
        //                     ->get();
        $counter = $page * $perPage + 1;
        $product_list->transform(function ($item) use (&$counter, &$request) {
            // dd($item);
            $item['ser_id'] = $counter++;

            // $item['file'] = '<a href="'.storage_path('app/uploads/variant_imported_files/'.$item->file_name).'" download>'.(isset($item->file_name) ? $item->file_name : '-').'</a>';
            if (isset($item->file_name)) {
                // $filePath = storage_path('app/uploads/variant_imported_files/'.$item->file_name);
                $fileUrl = asset('storage/files/variant_imported_files/' . $item->file_name);
                $item['file'] = '<a href="' . $fileUrl . '" download="' . $item->file_name . '">' . $item->file_name . '</a>';
            } else {
                $item['file'] = '-';
            }
            if (isset($item->invalid_file) && $item->invalid_file != null) {
                $item['invalid_file'] = '<a href="' . asset('importstatusfiles/' . $item->invalid_file) . '" download="' . $item->invalid_file . '">' . $item->invalid_file . '</a>';
            } else {
                $item['invalid_file'] = '-';
            }

            if (isset($item->status) && $item->status == 'Pending') {
                $item['status'] = '<span class="p_status" style="background: #ff6000;">Pending</span>';

            } elseif (isset($item->status) && $item->status == 'Completed') {

                $item['status'] = '<span class="p_status" style="background: green;">Completed</span>';

            } else {

                $item['status'] = '<span class="p_status" style="background: red;">Failed</span>';

            }
            if (isset($item['publish_status']) && $item['publish_status'] != 'Completed') {
                $item['publish'] = '<button class="btn table-filter-btn publish_btn" type="button" data-id="' . $item->id . '">Go Live</button>';
            } else {
                $item['publish'] = 'Completed';
            }
            if (isset($item->progress) && $item->progress != null) {
                $roundedProgress = round($item->progress);
                $item['progress'] = '<div role="progressbar" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100" style="--value:' . $roundedProgress . '"></div>';
                // $item['progress'] = '<div class="progress-container"><div class="progress" style="width:'.$item->progress.'%;"></div><div class="percentage" style="left:'.$item->progress.'%">'.$item->progress.'%</div></div>';
            } else {
                $item['progress'] = '-';
            }

            $item['f_updated_at'] = Carbon::parse($item->updated_at)->format('Y-m-d H:i:s');

            return $item;
        });

        return response()->json([
            'draw' => $request->input('draw'),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords, // For simplicity, assuming no filtering is applied
            'data' => $product_list,
        ]);
    }

    public function publish_variant(Request $request)
    {
        if (isset($request->file_id) && $request->file_id != null && $request->file_id != '') {
            if (isset($request->checkproduct)) {
                $products_count = VariantProduct::where('file_id', $request->file_id)
                    ->whereHas('checkproductimages', function ($query) {
                        $query->where('type', 'simple');
                    })->count();
                if (isset($products_count) && $products_count > 0) {
                    return response()->json(['status' => 0, 'message' => '']);
                } else {
                    return response()->json(['status' => 1, 'message' => 'Product Not Having Images, Please Upload images First!']);
                }
            } else {
                $products = VariantProduct::where('file_id', $request->file_id)->update(['visiblity' => 1]);
                if (!$products) {
                    return response()->json(['status' => 0, 'message' => 'No Products Found!']);
                } else {
                    VariantImportFile::where('id', $request->file_id)->update(['publish_status' => 'Completed']);

                    return response()->json(['status' => 1, 'message' => 'Products Published Successfully']);
                }
            }
        } else {
            return response()->json(['status' => 0, 'message' => 'Invalid File ID']);
        }
    }

    public function video_index()
    {
        return view('bulkupload.video_index');
    }

    public function video_store(Request $request)
    {
        if ($request->hasFile('all_imgs')) {
            foreach ($request->file('all_imgs') as $file) {
                $filename = $file->getClientOriginalName();
                $filenameWithoutExtension = pathinfo($filename, PATHINFO_FILENAME); // Get filename without extension
                $img_sku = $filenameWithoutExtension;
                $check_product = Product::where('p_sku', $img_sku)->first();
                $type = 'simple';
                if (!$check_product) {
                    $check_product = VariantProduct::where('p_sku', $img_sku)->first();
                    $type = 'variant';
                }
                if (!$check_product) {
                    $extension = $file->getClientOriginalExtension();
                    $folderPath = public_path('product_media/failed_videos/');
                    $file->move($folderPath, $filename);

                    $failed_video = new ImportedFile;
                    $failed_video->type = 'Video';
                    $failed_video->sku = isset($img_sku) ? $img_sku : null;
                    $failed_video->name = isset($filename) ? $filename : null;
                    $failed_video->status = 'Failed';
                    $failed_video->save();

                    // return response()->json(['error' =>  $filename], 404);
                } else {
                    $extension = $file->getClientOriginalExtension();
                    $folderPath = public_path('product_media/product_videos/');
                    $baseFilename = $img_sku . '_';
                    $suffix = 1;

                    $existingFiles = glob($folderPath . $baseFilename . '*.' . $extension);
                    $highestSuffix = 0;
                    foreach ($existingFiles as $existingFile) {
                        $existingFilename = pathinfo($existingFile, PATHINFO_FILENAME);
                        $fileSuffix = (int)str_replace($baseFilename, '', $existingFilename);
                        if ($fileSuffix > $highestSuffix) {
                            $highestSuffix = $fileSuffix;
                        }
                    }
                    $suffix = $highestSuffix + 1;

                    $newFilename = $baseFilename . $suffix . '.' . $extension;
                    $file->move($folderPath, $newFilename);
                    $check_product->update(['p_video' => $newFilename]);
                    $success_video = new ImportedFile;
                    $success_video->type = 'Video';
                    $success_video->sku = isset($img_sku) ? $img_sku : null;
                    $success_video->name = isset($filename) ? $filename : null;
                    $success_video->status = 'Completed';
                    $success_video->save();
                }

                return response()->json(['message' => 'Video uploaded successfully'], 200);
            }
        }

        return response()->json(['message' => 'Please upload video']);
    }

    public function video_list(Request $request)
    {
        $perPage = $request->input('length', 10);
        $page = $request->input('start', 0) / $perPage;
        $searchText = $request->input('search_text', '');
        $status = $request->input('status', '');
        $query = ImportedFile::select('*');
        $totalRecords = $query->count();
        $query->where('type', 'Video');
        if ($searchText) {
            $query->where('sku', 'like', "%$searchText%");
        }
        if ($status == 'completed') {
            $query->where('status', 'Completed');
        } elseif ($status == 'p_n_f') {
            $query->where('status', 'Failed');
        }
        $video_list = $query->latest()->skip($page * $perPage)->take($perPage)->get();
        $counter = $page * $perPage + 1;
        $video_list->transform(function ($item) use (&$counter, &$request) {
            // dd($item);
            $item['ser_id'] = $counter++;

            $item['sku'] = isset($item['sku']) ? $item['sku'] : '-';
            if (isset($item->status) && $item->status == 'Completed') {
                $item['status'] = 'Completed';
            } else {
                $item['status'] = 'Product Not Found';
            }

            $item['f_updated_at'] = Carbon::parse($item->updated_at)->format('Y-m-d H:i:s');
            $item['action'] = '<a href="javascript:;" data-href="' . route('bulk.product.video.list.delete', $item['id']) . '" class="table-btn table-btn1 delete" title="Click here for Delete Video"  ><img src="' . asset('images/dashbord/delete.png') . '" class="image-fuild" alt="user-img"></a>';

            return $item;
        });

        return response()->json([
            'draw' => $request->input('draw'),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords, // For simplicity, assuming no filtering is applied
            'data' => $video_list,
        ]);
    }

    public function video_download(Request $request)
    {
        $search_text = $request->input('search_text');
        $status = $request->input('status');
        $current_timestamp = Carbon::now()->timestamp;
        $videocount = ImportedFile::where('type', 'Video')->count();
        $query = ImportedFile::select('*');
        $totalRecords = $query->count();
        $query->where('type', 'Video');
        if ($search_text) {
            $query->where('sku', 'like', "%{$search_text}%");
        }
        if ($status == 'completed') {
            $query->where('status', 'Completed');
        } elseif ($status == 'p_n_f') {
            $query->where('status', 'Failed');
        }
        $video_list = $query->latest()->get();
        if (isset($video_list) && count($video_list) > 0) {
            return Excel::download(new VideosExport($video_list), 'uploaded_videos_' . $current_timestamp . '.xlsx');
        } else {
            return redirect()->back()->with('error', 'No Data found!');
        }

    }

    public function video_delete($id)
    {
        if (isset($id) && $id != null) {
            $video = ImportedFile::where('type', 'Video')->where('id', $id)->first();
            if ($video) {
                if (isset($video->status) && $video->status != null && $video->status == 'Failed') {
                    $file_path_l = public_path('product_media/failed_videos/' . $video->name);
                    if (File::exists(public_path('product_media/failed_videos/' . $video->name))) {
                        File::delete($file_path_l);
                    }
                } else {
                    $file_path_k = public_path('product_media/product_videos/' . $video->name);
                    if (File::exists(public_path('product_media/product_videos/' . $video->name))) {
                        File::delete($file_path_k);
                    }
                    $product = Product::where('p_video', $video->name)->first();
                    if (!$product) {
                        $product = VariantProduct::where('p_video', $video->name)->first();
                    }
                    if (isset($product) && $product != null) {
                        $product->update(['p_video' => null]);
                    }
                }
                $video->delete();

                return redirect()->route('bulk.video.upload')->with('error', 'Video Deleted Successfully');
            } else {
                return redirect()->route('bulk.video.upload')->with('error', 'Video Not Found!');
            }
        } else {
            return redirect()->route('bulk.video.upload')->with('error', 'Something Went Wrong!');

        }
    }

    public function certificate_index()
    {
        return view('bulkupload.certificate_index');
    }

    public function certificate_store(Request $request)
    {
        if ($request->hasFile('all_imgs')) {
            foreach ($request->file('all_imgs') as $file) {
                $filename = $file->getClientOriginalName();
                $filenameWithoutExtension = pathinfo($filename, PATHINFO_FILENAME);
                $img_sku = $filenameWithoutExtension;
                $check_product = Product::where('p_sku', $img_sku)->first();
                $type = 'simple';
                if (!$check_product) {
                    $check_product = VariantProduct::where('p_sku', $img_sku)->first();
                    $type = 'variant';
                }
                if (!$check_product) {
                    $extension = $file->getClientOriginalExtension();
                    $folderPath = public_path('product_media/failed_certificates/');
                    $file->move($folderPath, $filename);

                    $certi_f_video = new ImportedFile;
                    $certi_f_video->type = 'Certificate';
                    $certi_f_video->sku = isset($img_sku) ? $img_sku : null;
                    $certi_f_video->name = isset($filename) ? $filename : null;
                    $certi_f_video->status = 'Failed';
                    $certi_f_video->save();
                } else {
                    $extension = $file->getClientOriginalExtension();
                    $folderPath = public_path('product_media/product_certificates/');
                    $baseFilename = $img_sku . '_';
                    $suffix = 1;

                    $existingFiles = glob($folderPath . $baseFilename . '*.' . $extension);
                    $highestSuffix = 0;
                    foreach ($existingFiles as $existingFile) {
                        $existingFilename = pathinfo($existingFile, PATHINFO_FILENAME);
                        $fileSuffix = (int)str_replace($baseFilename, '', $existingFilename);
                        if ($fileSuffix > $highestSuffix) {
                            $highestSuffix = $fileSuffix;
                        }
                    }
                    $suffix = $highestSuffix + 1;

                    $newFilename = $baseFilename . $suffix . '.' . $extension;
                    $file->move($folderPath, $newFilename);
                    $check_product->update(['p_certificate_file' => $newFilename]);
                    $certi_s_video = new ImportedFile;
                    $certi_s_video->type = 'Certificate';
                    $certi_s_video->sku = isset($img_sku) ? $img_sku : null;
                    $certi_s_video->name = isset($filename) ? $filename : null;
                    $certi_s_video->status = 'Completed';
                    $certi_s_video->save();
                }

                return response()->json(['message' => 'Certificate uploaded successfully'], 200);
            }
        }

        return response()->json(['message' => 'Please upload certificates']);
    }

    public function certificate_list(Request $request)
    {
        $perPage = $request->input('length', 10);
        $page = $request->input('start', 0) / $perPage;
        $searchText = $request->input('search_text', '');
        $status = $request->input('status', '');
        $query = ImportedFile::select('*');
        $totalRecords = $query->count();
        $query->where('type', 'Certificate');
        if ($searchText) {
            $query->where('sku', 'like', "%$searchText%");
        }
        if ($status == 'completed') {
            $query->where('status', 'Completed');
        } elseif ($status == 'p_n_f') {
            $query->where('status', 'Failed');
        }
        $certi_list = $query->latest()->skip($page * $perPage)->take($perPage)->get();
        $counter = $page * $perPage + 1;
        $certi_list->transform(function ($item) use (&$counter, &$request) {
            $item['ser_id'] = $counter++;

            $item['sku'] = $item['sku'] ?? '-';
            if (isset($item->status) && $item->status == 'Completed') {
                $item['status'] = 'Completed';
            } else {
                $item['status'] = 'Product Not Found';
            }

            $item['f_updated_at'] = Carbon::parse($item->updated_at)->format('Y-m-d H:i:s');
            $item['action'] = '<a href="javascript:;" data-href="' . route('bulk.product.certificate.list.delete', $item['id']) . '" class="table-btn table-btn1 delete" title="Click here for Delete Certificate"  ><img src="' . asset('images/dashbord/delete.png') . '" class="image-fuild" alt="user-img"></a>';

            return $item;
        });

        return response()->json([
            'draw' => $request->input('draw'),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $certi_list,
        ]);
    }

    public function certificate_download(Request $request)
    {
        $search_text = $request->input('search_text');
        $status = $request->input('status');
        $current_timestamp = Carbon::now()->timestamp;
        $query = ImportedFile::select('*');
        $query->where('type', 'Certificate');
        if ($search_text) {
            $query->where('sku', 'like', "%{$search_text}%");
        }
        if ($status == 'completed') {
            $query->where('status', 'Completed');
        } elseif ($status == 'p_n_f') {
            $query->where('status', 'Failed');
        }
        $certi_list = $query->latest()->get();
        if (isset($certi_list) && count($certi_list) > 0) {
            return Excel::download(new CertificatesExport($certi_list), 'uploaded_certificates_' . $current_timestamp . '.xlsx');
        } else {
            return redirect()->back()->with('error', 'No Data found!');
        }

    }

    public function certificate_delete($id)
    {
        if (isset($id) && $id != null) {
            $certi = ImportedFile::where('type', 'Certificate')->where('id', $id)->first();
            if ($certi) {
                if (isset($certi->status) && $certi->status != null && $certi->status == 'Failed') {
                    $file_path_l = public_path('product_media/failed_certificates/' . $certi->name);
                    if (File::exists(public_path('product_media/failed_certificates/' . $certi->name))) {
                        File::delete($file_path_l);
                    }
                } else {
                    $file_path_k = public_path('product_media/product_certificates/' . $certi->name);
                    if (File::exists(public_path('product_media/product_certificates/' . $certi->name))) {
                        File::delete($file_path_k);
                    }
                    $product = Product::where('p_certificate_file', $certi->name)->first();
                    if (!$product) {
                        $product = VariantProduct::where('p_certificate_file', $certi->name)->first();
                    }
                    if (isset($product) && $product != null) {
                        $product->update(['p_certificate_file' => null]);
                    }
                }
                $certi->delete();

                return redirect()->route('bulk.certificate.upload')->with('error', 'Certificate Deleted Successfully');
            } else {
                return redirect()->route('bulk.certificate.upload')->with('error', 'Certificate Not Found!');
            }
        } else {
            return redirect()->route('bulk.certificate.upload')->with('error', 'Something Went Wrong!');

        }
    }

    public function bulkDeleteProductImage(Request $request)
    {
        $ids = $request->ids;
        if (count($ids) > 0) {
            foreach ($ids as $id) {
                $id = intval($id);
                $productImage = ProductImage::where('id', $id)->first();
                if ($productImage) {
                    $productImage->delete();
                } else {
                    $failedImages = FailedProductImage::findOrFail($id);
                    if ($failedImages) {
                        $failedImages->delete();
                    }
                }
            }

            return response()->json(['status' => 'success', 'message' => 'Product images deleted successfully']);
        }

        return response()->json(['status' => 'error', 'message' => 'Something went wrong']);
    }
}
