@extends('layout')
<style>
    .profile-pic {
        width: 150px; /* Sesuaikan dengan ukuran yang Anda inginkan */
        height: 150px; /* Sesuaikan dengan ukuran yang Anda inginkan */
        background-image: url('image/UserPro.png'); /* Ganti dengan URL gambar profil Anda */
        background-size: cover;
        background-position: center;
        border-radius: 50%; /* Membuat sudut gambar profil menjadi bulat */
        border: 2px solid #ffffff; /* Opsi: Tambahkan garis putih di sekitar gambar profil */
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); /* Opsi: Tambahkan bayangan halus */
    }
    .profil h1{
        font-weight: bold;
        padding: 20px;
    }
</style>
@section('section')

<header>
    <h1>
        Profil</span>
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
            
            <div class="profil">
                <div class="profile-pic"></div>
                <h1>{{auth()->user()->name}}</h1>

                <div class="box-information">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="">Nama Kandidat</label>
                            <input type="text" class="form-control" value="{{auth()->user()->name}}" disabled/>
                        </div>
                        <div class="col-md-6">
                            <label for="">Posisi Kandidat</label>
                            <input type="text" class="form-control" value="{{auth()->user()->posisi}}" disabled/>
                        </div>
                    </div>
                    
                </div>
            </div>
             
        </div>
    </div>  
</main>

<script>
    
</script>

@endsection