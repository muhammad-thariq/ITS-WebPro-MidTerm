<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;

class ProductsImport implements ToModel
{
    public function model(array $row)
    {
        return new Product([
            'Name' => $row[0],
            'Price' => $row[1],
            'Description' => $row[2],
            'Photo' => $row[3] // Ensure the file names in CSV match this format
        ]);
    }
}
