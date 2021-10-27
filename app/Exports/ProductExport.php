<?php

namespace App\Exports;

use App\Models\Products;
use Maatwebsite\Excel\Concerns\FromCollection;
 use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
    //     dd(Products::getAllproducts);
    //    return collect(Products::getAllproducts);
    return Products::select('id','name','description','price')->get();
    }

    public function headings():array{
        return [
            "id","name","description","price"
        ];
    }
}
