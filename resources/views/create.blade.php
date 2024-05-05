@extends('layout')

@section('section')

<header>
    <h1>
        Produk > <span>{{ $data ? 'Edit' : 'Tambah' }} Produk</span>
    </h1>
</header>

<main>
    <div class="card">
        <div class="card-body">
            <div id="message">
                @if(session('success'))
                    <div class="alert alert-success" id="success-message">
                        {{ session('success') }}
                    </div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger" id="error-message">
                        {{ $errors->first() }}
                    </div>
                @endif
            </div>
            
            <form action="{{$data ? route('edit.produk') : route('added.produk') }}" enctype="multipart/form-data" method="POST">
                @csrf
                <input type="hidden"  name="id" value="{{$data ?  $data[0]->id : '' }}">
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="kategori_id">Kategori</label>
                    <select name="kategori_id" id="kategori_id" class="form-control">
                        <?php
                            $get = DB::select('SELECT * FROM kategoris ORDER BY id ASC');
                        ?>
                        <option disabled selected>-- Pilih --</option>
                        @foreach ($get as $item)
                            <option value="{{ $item->id}}" {{$data &&  $data[0]->katid == $item->id ? 'selected' : ''}}>{{$item->name}}</option>
                        @endforeach
                    </select>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="namaBarang">Nama Barang</label>
                    <input type="text" class="form-control" id="namaBarang" name="nama_barang" value="{{$data ? $data[0]->nama_produk : ''}}">
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label for="harga_beli_id">Harga Beli</label>
                    <input type="text" class="form-control" id="harga_beli_id" name="harga_beli" onchange="hitung()" value="{{$data ? $data[0]->harga_beli : ''}}">
                  </div>
                  <div class="form-group col-md-4">
                    <label for="harga_jual_id">Harga Jual</label>
                    <input type="text" class="form-control" id="harga_jual_id" name="harga_jual" value="{{$data ? $data[0]->harga_jual : ''}}">
                  </div>
                  <div class="form-group col-md-4">
                    <label for="inputStok">Stok Barang</label>
                    <input type="text" class="form-control" id="inputStok" name="stok" value="{{$data ? $data[0]->stok : ''}}">
                  </div>
                </div>
                <div id="image-preview"></div>
                <div class="form-group">
                    <input type="file" class="form-control" id="image_id" name="images">
                </div>
                @if($data)
                    <img src="{{ asset("storage/".$data[0]->image) }}" alt="no image" style="width: 100px;height:100px;"/>
                @endif

                <div style="float: right;">
                    <button type="button" class="btn btn-primary">Batalkan</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>

              </form>
        </div>
    </div>  
</main>

<script>
    document.getElementById("image_id").addEventListener("change", function(event) {
        var file = event.target.files[0];
        var reader = new FileReader();

        reader.onload = function(event) {
            var imagePreview = document.getElementById("image-preview");
            imagePreview.innerHTML = "";
            var img = document.createElement("img");
            img.src = event.target.result;
            img.className = "preview-image";
            imagePreview.appendChild(img);
        };

        reader.readAsDataURL(file);
    });

    document.getElementById('message').style.display = 'block';

    // Set timer untuk menyembunyikan pesan kesalahan setelah 5 detik
    setTimeout(function() {
        document.getElementById('message').style.display = 'none';
    }, 5000); // 5detik

    function hitung() {
        var hargaBeli = document.getElementById('harga_beli_id').value;

        var hargaJual = parseInt(hargaBeli) + (parseInt(hargaBeli) * 0.30);

        document.getElementById('harga_jual_id').value = hargaJual;
    }
</script>

@endsection