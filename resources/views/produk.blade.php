@extends('layout')

@section('section')
@include('layouts.header')
<main>
    <div class="card">
        <div class="card-body" style="display: flex;justify-content: space-between;">
            <div class="wrapper-search">
                <form action="">
                    <div class="row">
                        <div class="col">
                            <span class="fa fa-search search"></span>
                            <input type="text" id="searchInput" class="form-control search-barang" placeholder="Cari Barang"  onkeyup="searchFunction()"/>
                        </div>
                        <?php
                            $get = DB::select('SELECT * FROM kategoris ORDER BY id ASC');
                        ?>
                        <div class="col">
                            <img src="{{asset('image/Package.png')}}" alt="" class="img-kategori">
                            <select id="selectkategori" class="form-control kategori" onchange="changeKategori()">
                                <option value="">Semua</option>
                                @foreach ($get as $item)
                                    <option value="{{ $item->name}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="btn-search" style="width: 200px;">
                        
                    </div>
                
                </form>
            </div>

            <div class="wrapper-export">
                <a href="{{ route('export.produk',['kategori'=>'semua']) }}" class="btn btn-success" id="export_id">
                    <img src="{{asset('image/MicrosoftExcelLogo.png')}}" alt="">
                    Export Excel
                </a>
                <a href="{{ route('store.produk') }}" class="btn btn-danger">
                    <img src="{{asset('image/PlusCircle.png')}}" alt="">
                    Tambah Produk</a>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table" id="data-table">
                    <thead>
                        <tr>
                            <td>No</td>
                            <td>Image</td>
                            <td>Nama Produk</td>
                            <td>Kategori Produk</td>
                            <td>Harga Beli (Rp)</td>
                            <td>Harga Jual (Rp)</td>
                            <td>Stok Produk</td>
                            <td>Aksi</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;?>
                        @foreach ($datas as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><img src="{{asset('storage/'.$item->image)}}" alt="" style="width:30px;height:30px;"></td>
                            <td>{{ $item->nama_produk }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ number_format($item->harga_beli,0,',','.') }}</td>
                            <td>{{ number_format($item->harga_jual,0,',','.') }}</td>
                            <td>{{ $item->stok }}</td>
                            <td>
                                <a href="{{route('store.produk',['id'=>$item->id,'type'=>'edit'])}}"><img src="{{asset("/image/edit.png")}}" alt="no image" /></a>
                                <a href="{{ route('produk.destroy', ['id'=>$item->id]) }}" onclick="event.preventDefault(); if (confirm('Yakin ingin menghapus produk?')) { document.getElementById('delete-produk-{{ $item->id }}').submit(); }">
                                    <img src="{{asset("/image/delete.png")}}" alt="no image" />
                                </a>
                                <form id="delete-produk-{{ $item->id }}" action="{{ route('produk.destroy', ['id'=>$item->id]) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        
                    </tbody>
                </table>
            </div>
          
            <nav aria-label="Page navigation example" style="display: flex;justify-content:space-between;align-items:center;">
                <div>
                    <span>Show {{$datas->perPage()}} From {{ $datas->total() }}</span>
                </div>
                <ul class="pagination">
                  <li class="page-item {{ $datas->currentPage() == 1 ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $datas->previousPageUrl() }}" aria-label="Previous">
                      <span aria-hidden="true">&laquo;</span>
                    </a>
                  </li>
                  @for ($i = 1; $i <= $datas->lastPage(); $i++)
                        <li class="page-item {{ $i == $datas->currentPage() ? 'active' : '' }}">
                            <a class="page-link" href="{{ $datas->url($i) }}">{{ $i }}</a>
                        </li>
                @endfor
                  <li class="page-item {{ $datas->currentPage() == $datas->lastPage() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $datas->nextPageUrl() }}" aria-label="Next">
                      <span aria-hidden="true">&raquo;</span>
                    </a>
                  </li>
                </ul>
            </nav>
        </div>
    </div>  
</main>
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
<script type="text/javascript">
    // loadData(1);
    

    function searchFunction() {
        const input = document.getElementById('searchInput').value.toLowerCase();
        const table = document.getElementById('data-table');
        const rows = table.getElementsByTagName('tr');

        for (let i = 1; i < rows.length; i++) {
            const cells = rows[i].getElementsByTagName('td');
            let found = false;

            for (let j = 0; j < cells.length; j++) {
                const cellText = cells[j].textContent.toLowerCase();
                if (cellText.includes(input)) {
                    found = true;
                    break;
                }
            }

            if (found) {
                rows[i].style.display = '';
            } else {
                rows[i].style.display = 'none';
            }
        }
    }

    function changeKategori(){
        const select = document.getElementById('selectkategori');
        const selectedValue = select.value.toLowerCase();
        const table = document.getElementById('data-table');
        const rows = table.getElementsByTagName('tr');
        // console.log(selectedValue);

        for (let i = 1; i < rows.length; i++) {
            const cells = rows[i].getElementsByTagName('td');
            const kategori = cells[3].textContent.toLowerCase();
            
            // console.log(kategori);
            if (selectedValue == '' || kategori == selectedValue) {
                rows[i].style.display = '';
            } else {
                rows[i].style.display = 'none';
            }

        }

        const exports = document.getElementById('export_id');

        if(selectedValue == ''){
        exports.setAttribute('href','/produk/export?kategori=semua');
        }else{
        exports.setAttribute('href','/produk/export?kategori='+selectedValue);

        }
        
    }
</script>
    
@endsection