<?php

namespace App\Exports;

use App\Models\Produk;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class ProduksExport implements FromView
{
    use Exportable;

    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function view(): View
    {
        if($this->data->kategori == 'semua'){
            $getdata = DB::table('produks')
            ->join('kategoris','produks.kategori_id','=','kategoris.id')
            ->select('produks.*','kategoris.name')
            ->get();
        }else{
            $getdata = DB::table('produks')
            ->join('kategoris','produks.kategori_id','=','kategoris.id')
            ->whereRaw('LOWER(kategoris.name) like ?', ['%'.$this->data->kategori.'%'])
            ->select('produks.*','kategoris.name')
            ->get();
        }
       

        return view('export.produk',['data'=>$getdata]);
    }
}
