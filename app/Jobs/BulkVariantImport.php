<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\VariantImportFile;
use App\Models\Product;
use App\Models\VariantProduct;
use App\Models\ProductAttribute;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Log;

class BulkVariantImport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $import_id;
    public function __construct($import_id)
    {
        $this->import_id = $import_id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $file = VariantImportFile::findOrfail($this->import_id);
        $filePath = storage_path('app/public/files/variant_imported_files/' . $file->file_name);
        if (!file_exists($filePath)) {
            // Handle the case where the file does not exist
            return;
        }
        $fileContents = file_get_contents($filePath);
        $rows = array_map('str_getcsv', file($filePath));
        $rows = array_slice($rows, 1);
        $invalid_count = 0;
        $updated_count = 0;
        $completed_count = 0;
        $invalid_data = [];
        $updated_data = [];
        $completed_data = [];
        foreach ($rows as $r_key => $row) {
            foreach ($row as &$value) {
                $value = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
            }
            $parent_product_sku = isset($row[1]) && $row[1] != '' ? $row[1] : null;
            $child_product_sku = isset($row[2]) && $row[2] != '' ? $row[2] : null;
            $type = isset($row[3]) && $row[3] != '' ? $row[3] : null;
            $attributes = isset($row[4]) && $row[4] != '' ? $row[4] : null;
            $validData = true;
            $row[5] = '';
            if(empty($parent_product_sku))
            {
                $row[5] .= 'Parent Product SKU* |';
                $validData = false;
            }
            if(empty($child_product_sku))
            {
                $row[5] .= 'Child Poduct SKU* |';
                $validData = false;
            }
            if(empty($type))
            {
                $row[5] .= 'Product Type* |';
                $validData = false;
            }
            if(empty($attributes))
            {
                $row[5] .= 'Attributes* |';
                $validData = false;
            }
            $attr_array = ['Metal Purity','Metal Color','Metal Weight','Gender','Size'];
            $ex_attr = explode('|',$attributes);
            foreach($ex_attr as $a_value)
            {
                if (!in_array(trim($a_value), $attr_array))
                {
                    $row[5] .= 'InValid Attribute! |';
                    $validData = false;
                }
            }
            if(isset($parent_product_sku) && $parent_product_sku != null && $parent_product_sku != null)
            {
                $parent_product_check = Product::where('p_sku',$parent_product_sku)->first();
                if(isset($parent_product_check) && $parent_product_check != null)
                {
                    $parent_product_id = $parent_product_check->id;
                }else{
                    $row[5] .= 'Product Not Found for Parent SKU |';
                    $validData = false;
                }
            }
            if(isset($child_product_sku) && $child_product_sku != null && $child_product_sku != null)
            {
                $child_product_check = Product::where('p_sku',$child_product_sku)->first();
                if(isset($child_product_check) && $child_product_check != null)
                {
                    $child_product_id = $child_product_check->id;
                }else{
                    $row[5] .= 'Child Product Not Found for Child SKU |';
                    $validData = false;
                }
            }
            if(isset($validData) && $validData == true)
            {
                if(isset($attributes) && $attributes != null)
                {
                    $change_att = [];
                    foreach($ex_attr as $a_value)
                    {
                        if(trim($a_value) == 'Metal Purity')
                        {
                            array_push($change_att,"metal_purity");
                        }
                        if(trim($a_value) == 'Metal Color')
                        {
                            array_push($change_att,"metal_color");
                        }
                        if(trim($a_value) == 'Metal Weight')
                        {
                            array_push($change_att,"metal_wieght");
                        }
                        if(trim($a_value) == 'Size')
                        {
                            array_push($change_att,"size");
                        }
                        if(trim($a_value) == 'Gender')
                        {
                            array_push($change_att,"gender");
                        }
                    }
                    if(isset($change_att) && !empty($change_att))
                    {
                        $u_attr_sting = implode(',',$change_att);
                    }   
                }
                $duplicate = VariantProduct::where('parent_product_id',$parent_product_id)->where('p_sku',$child_product_sku)->first();
                if(isset($duplicate) && $duplicate != null)
                {
                    $attribute = ProductAttribute::where('id',$duplicate->attr_id)->first();
                    if(isset($u_attr_sting) && $u_attr_sting != null)
                    {
                        $attribute->update(['attributes' => $u_attr_sting]);
                    }
                    $updated_data[] = $row;
                    $updated_count++;
                }else{
                    $product_aatribute = new ProductAttribute();
                    $product_aatribute->parent_product_id = $parent_product_id;
                    $product_aatribute->attributes = isset($u_attr_sting) ? $u_attr_sting : null;
                    $product_aatribute->save();

                    $product = Product::find($child_product_id);
                    $variantProduct = new VariantProduct();
                    $variantProduct->fill($product->toArray());
                    $variantProduct->parent_product_id = $parent_product_id;
                    $variantProduct->attr_id = $product_aatribute->id;
                    $variantProduct->file_id = $file->id;
                    $variantProduct->save();
                    $product_images = ProductImage::where('product_id',$child_product_id)->update(['product_id' => $variantProduct->id,'type' => 'variant']);
                    $product->delete();
                    $completed_data[] = $row;
                    $completed_count++;
                }
            }else{
                $invalid_data[] = $row;
                $invalid_count++;
            }
            $progress = ($r_key + 1) / count($rows) * 100;
            $file->update(['progress' => $progress]);
        }
        $totalcount =$updated_count+$completed_count+$invalid_count;

        if(isset($completed_data) && count($completed_data) > 0)
        {
            $headers = ['sr', 'Parent Product SKU', 'Child SKU','Product Type','Attributes'];
            $filename = 'completed_'.uniqid() . '.csv';
            $filePath = public_path('importstatusfiles/'.$filename);
            $c_file = fopen($filePath, 'w+');
    
            // Add the headers from the first row of data
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            fputcsv($c_file, $headers);
            foreach ($completed_data as $row) {
                fputcsv($c_file, $row);
            }
    
            fclose($c_file);
            $file->update(['completed_file' =>$filename]);
        }
        if(isset($invalid_data) && count($invalid_data) > 0)
        {
            $headers = ['sr', 'Parent Product SKU', 'Child SKU','Product Type','Attributes','Comment'];
            $filename = 'invalid_'.uniqid() . '.csv';
            $filePath = public_path('importstatusfiles/'.$filename);
            $c_file = fopen($filePath, 'w+');
    
            // Add the headers from the first row of data
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            fputcsv($c_file, $headers);
            foreach ($invalid_data as $row) {
                fputcsv($c_file, $row);
            }
            fclose($c_file);
            $file->update(['invalid_file' =>$filename]);
        }
        if(isset($updated_data) && count($updated_data) > 0)
        {
            $headers = ['sr', 'Parent Product SKU', 'Child SKU','Product Type','Attributes'];
            $filename = 'updated_'.uniqid() . '.csv';
            $filePath = public_path('importstatusfiles/'.$filename);
            $c_file = fopen($filePath, 'w+');
    
            // Add the headers from the first row of data
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            fputcsv($c_file, $headers);
            foreach ($updated_data as $row) {
                fputcsv($c_file, $row);
            }
            fclose($c_file);
            $file->update(['updated_file' =>$filename]);
        }
        if($totalcount == count($rows)){
            $file->update(['status'=>'Completed']);
        }else{
            $file->update(['status'=>'Cancel']);
        }
    }
    public function failed(\Throwable $exception)
    {
        try {
            $file = VariantImportFile::findOrFail($this->import_id);
            $file->update(['status' => 'Failed']);
        } catch (\Exception $e) {
            Log::error('Error updating status in failed job: ' . $e->getMessage());
        }

        Log::error('BulkImport job failed for file ID: ' . $this->import_id, ['exception' => $exception]);
    }
}
