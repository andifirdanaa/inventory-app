<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SIMS Web App</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <style>
        * {
            color: #333;
            font-family: poppins-regular;
            font-size: 13px;
        }
        body {
            height: 100%;
            width: 100%;
            margin: 0;
        }
        .page-content {
            min-height: 100vh;
            background-size: cover;
            background: #ffffff;
            align-items: center;
            display: flex;
        }
        .page-flex {
            width: 50%;
        }
        .image-holder {
            width: 50%;
        }
        .page-box-form{
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
        .password-input {
            position: relative;
        }
        .password-input input {
            padding-right: 30px; /* Biarkan ruang untuk ikon mata */
            padding-left: 30px; /* Biarkan ruang untuk ikon mata */
        }
        .password-input .fa-eye {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
        }

        .password-input .fa-lock {
            position: absolute;
            top: 50%;
            left: 10px;
            transform: translateY(-50%);
            cursor: pointer;
        }

        .password-input .fa-eye-slash {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
        }
        .email-input {
            position: relative;
        }
        .email-input input {
            padding-left: 30px; /* Biarkan ruang untuk ikon mata */
        }
        .email-input .fa-at {
            position: absolute;
            top: 50%;
            left: 10px;
            transform: translateY(-50%);
            cursor: pointer;
        }

    </style>

</head>
<body>
    <div class="page-content">
        <div class="page-flex page-box-form">
            <form action="{{ route('login') }}" enctype="multipart/form-data" method="POST">
                @csrf
                <h2>SIMS Web App</h2>
                <h1>Masuk atau buat akun untuk memulai</h1>
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                
                @if($errors->any())
                    <div class="alert alert-danger">
                        {{ $errors->first() }}
                    </div>
                @endif
                <div class="form-group email-input">
                    <i class="fa fa-at" aria-hidden="true"></i>
                    <input type="email" class="form-control" name="email" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="masukkan email anda">
                </div>
                <div class="form-group password-input">
                  <input type="password" id="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="masukkan password anda">
                  <i class="fa fa-lock" id="toggleLock"></i>
                  <i class="fas fa-eye" id="togglePassword"></i>
                </div>
               
                <button type="submit" class="btn btn-danger btn-lg" style="width: 100%;">Masuk</button>
            </form>
        </div>
        <div class="page-flex image-holder">
            <img src="{{ asset('image/Frame.png') }}" alt="" class="img-fluid">
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

    <script>
        document.getElementById('togglePassword').addEventListener('click', function() {
            var passwordInput = document.getElementById('password');
            var eyeIcon = this;
    
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        });
    </script>
</body>
</html>