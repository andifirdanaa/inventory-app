<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <table>
        <thead>
            <tr>
                <td>No</td>
                <td>Nama Produk</td>
                <td>Kategori Produk</td>
                <td>Harga Barang</td>
                <td>Harga Jual</td>
                <td>Stok</td>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$item->nama_produk}}</td>
                <td>{{$item->name}}</td>
                <td>{{$item->harga_beli}}</td>
                <td>{{$item->harga_jual}}</td>
                <td>{{$item->stok}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>