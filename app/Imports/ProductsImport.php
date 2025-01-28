<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\Product;

class ProductsImport implements ToModel
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
      
    }
}
