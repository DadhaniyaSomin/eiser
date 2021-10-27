<?php

namespace App\Imports;

use App\Models\products;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductImport implements ToModel ,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    { 
      
        return new Products([
            'name' => $row['name'],
            'description' => $row['description'], 
            'price' => $row['price'],
            'user_id' => $row['user_id'],
        ]);
    }
}
