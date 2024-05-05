<?php

namespace App\Http\Controllers;

use App\Exports\ProduksExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class ProdukController extends Controller
{
    public function index() 
    {
        $getdata =  DB::table('produks')
        ->join('kategoris','kategoris.id','=','produks.kategori_id')
        ->select('produks.*','kategoris.name')
        ->paginate(10);

        // dd($getdata);
        return view('produk', ['datas' => $getdata]);
    }

    public function show(Request $request)
    {
        $getdata =  DB::table('produks')
        ->join('kategoris','kategoris.id','=','produks.kategori_id')
        ->select('produks.*','kategoris.name')
        ->paginate(1);

        // $getdata = DB::select('SELECT produks.*, kategoris.name FROM produks INNER JOIN kategoris ON produks.kategori_id = kategoris.id ORDER BY produks.id ASC');
        //tambah nomer urut
        $number = 1;
        foreach ($getdata as $item) {
            $item->number = $number++;
        }
        
        return $getdata;
    }

    public function create(Request $request)
    {
        $type = ($request->type ? $request->type : 'create');

        if($type != 'create'){
            $getdata = DB::select('SELECT produks.*, kategoris.name, kategoris.id AS katId FROM produks INNER JOIN kategoris ON produks.kategori_id = kategoris.id  WHERE produks.id = ?',[$request->id]);
            
            return view('create',['data'=>$getdata]);
        }else{
            return view('create',['data'=>null]);
        }

        
    }

    public function added(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_barang' => 'required|unique:produks,nama_produk',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'stok' => 'required|numeric',
            'kategori_id' => 'required',
            'images' => 'required|image|mimes:jpeg,png,jpg|max:100',
        ], [
            'nama_barang.required' => 'Silahkan isikan nama barang.', 
            'nama_barang.unique' => 'Nama barang sudah ada.',  
            'harga_beli.required' => 'Silahkan isi harga beli.',  
            'harga_jual.required' => 'Silahkan isi harga jual.', 
            'stok.required' => 'Silahkan isi stok.',  
            'harga_beli.numeric' => 'Harga harus berupa angka',  
            'harga_jual.numeric' => 'Harga harus berupa angka', 
            'stok.numeric' => 'Stok harus berupa angka',  
            'kategori_id.required' => 'Kategori ID harus dipilih.', 
            'images.required' => 'Silahkan upload attachment image.',
            'images.mimes' => 'File hanya dapat berupa JPEG, PNG, JPG, atau GIF.',
            'images.max' => 'File Image max 100KB.'
        ]);
        

        if ($validator->fails()) {
            $request->session()->flash('error', implode('<br/>', $validator->errors()->all()));
            return redirect()->back()->withErrors([implode('<br/>', $validator->errors()->all())]);
        }

        $cekdata = DB::select('SELECT * FROM produks WHERE nama_produk = ?', [$request->nama_barang]);

        if(!$cekdata){
            DB::beginTransaction();

            if ($request->hasFile('images')) {
                // $nameImage = $request->file('image_bank')->getClientOriginalName();
                $nameImage = time(). '_' .$request->file('images')->getClientOriginalName();
                // $imageName = $nameImage.'_'.$request->image_bank->extension();
                $path = $request->file('images')->storeAs('images/produk',$nameImage,'public');
            }else{
                $path = "";
            }


            $sql = "INSERT INTO produks (nama_produk, kategori_id, harga_beli, harga_jual,stok,image,status) 
                    VALUES (?,?,?,?,?,?,?)";   

            $hargaBeli = $request->harga_beli;

            // Menghitung harga jual dengan menambahkan 30% dari harga beli
            $hargaJual = $hargaBeli + ($hargaBeli * 0.30);

            $parameters = [
                $request->nama_barang,
                $request->kategori_id,
                $request->harga_beli,
                $hargaJual,
                $request->stok,
                $path,
                1
            ];

            $eksekusi = DB::statement($sql, $parameters);

            if($eksekusi){
                DB::commit();
                
                $request->session()->flash('success', 'Data telah tersimpan');
                return redirect()->back();
            }else{
                DB::rollBack();
                $request->session()->flash('error', 'Gagal Menyimpan Data!');
                return redirect()->back()->withErrors(['Gagal Menyimpan Data!']);
            }
            
        }else{
            $request->session()->flash('error', 'Data Sudah Ada!');
            return redirect()->back()->withErrors(['Data Sudah Ada!']);
        }
    }

    public function edit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'=>'exists:produks,id',
            'nama_barang' => 'required|unique:produks,nama_produk,'.$request->id.',id',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'stok' => 'required|numeric',
            'kategori_id' => 'required',
        ], [
            'nama_barang.required' => 'Silahkan isikan nama barang.', 
            'nama_barang.unique' => 'Nama barang sudah ada.',  
            'harga_beli.required' => 'Silahkan isi harga beli.',  
            'harga_jual.required' => 'Silahkan isi harga jual.', 
            'stok.required' => 'Silahkan isi stok.',  
            'harga_beli.numeric' => 'Harga harus berupa angka',  
            'harga_jual.numeric' => 'Harga harus berupa angka', 
            'stok.numeric' => 'Stok harus berupa angka',  
            'kategori_id.required' => 'Kategori ID harus dipilih.', 
        ]);

        if ($validator->fails()) {
            $request->session()->flash('error', implode('<br/>', $validator->errors()->all()));
            return redirect()->back()->withErrors([implode('<br/>', $validator->errors()->all())]);
        }

        $cekdata = DB::select('SELECT * FROM produks WHERE id = ?', [$request->id]);
        if($cekdata){
            DB::beginTransaction();
            if(isset($request->images) || $request->hasFile('images')){
                $this->validate($request, [
                    'images' => 'image|mimes:jpeg,png,jpg,gif,svg|max:100',
                ],[
                    'images.image'=> 'Only Image!',
                    'images.mimes'=> 'Image only can jpeg,png,jpg',
                    'images.max'=> 'Size image max 100',
                ]);

                // first checking old photo to delete from storage
                $get_item = $cekdata[0]->image;

                $nameImage = time(). '_' .$request->file('images')->getClientOriginalName();

                // change file locations
                $cekdata[0]->image = $request->file('images')->storeAs(
                    'images/produk', $nameImage,'public'
                );

                // delete old photo from storage
                $data_old = 'storage/'.$get_item;
                if (File::exists(public_path($data_old))) {
                        File::delete(public_path($data_old));
                }else{
                        File::delete('storage/app/public/'.$get_item);
                }
            }

            $dat = Produk::find($request->id);

            $hargaBeli = $request->harga_beli;

            // Menghitung harga jual dengan menambahkan 30% dari harga beli
            $hargaJual = $hargaBeli + ($hargaBeli * 0.30);

            $update = $dat->update([
                'nama_produk'=>$request->nama_barang,
                'kategori_id'=>$request->kategori_id,
                'harga_beli'=>$request->harga_beli,
                'harga_jual'=>$hargaJual,
                'stok'=>$request->stok,
                'image'=>$cekdata[0]->image,
                'status'=>1
            ]);

            if($update){
                DB::commit();
                
                $request->session()->flash('success', 'Data telah tersimpan');
                return redirect()->back();
            }else{
                DB::rollBack();
                $request->session()->flash('error', 'Gagal Menyimpan Data!');
                return redirect()->back()->withErrors(['Gagal Menyimpan Data!']);
            }
            
        }else{
            $request->session()->flash('error', 'Data Sudah Ada!');
            return redirect()->back()->withErrors(['Data Sudah Ada!']);
        }
    }

    public function delete(Request $request)
    {
        $cek = Produk::find($request->id);
        $cek->delete();

        if($cek){
            $request->session()->flash('success', 'Data sudah dihapus');
            return redirect()->back();
        }else{
            $request->session()->flash('error', 'Data gagal terhapus!');
            return redirect()->back()->withErrors(['Data gagal terhapus!']);
        }
    }

    public function export(Request $request)
    {
        return Excel::download(new ProduksExport($request), 'produks.xlsx');
    }
}
