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
            /* color: #333; */
            font-family: Arial, sans-serif;
            font-size: 13px;
            text-decoration: none;
            list-style-type: none;
            box-sizing: border-box;
        }
        body,h1,h2,h3, ul {
            margin: 0;
            padding: 0;
        }
        .sidebar {
            width: 345px;
            position: fixed;
            left: 0;
            top: 0;
            height: 100%;
            background-color: red;
            z-index: 100;
        }
        .sidebar-brand {
            height: 90px;
            padding: 1rem 0rem 1rem 2rem;
            color: #ffffff;
            display: flex;
            align-items: center;
        }
        .sidebar-brand img{
            height: 30px;
            padding-right: 10px; 
        }
        .sidebar-brand span{
            padding-left: 20px;
            font-size: 1.5rem;
        }
        .sidebar-menu {
            margin-top: 1rem;
        }
        .sidebar-menu li {
            width: 100%;
            margin-bottom: 1.3rem;
            padding-left: 1rem;
        }
        .sidebar-menu a {
            padding-left: 1rem;
            display: block;
            color: #ffffff;
            font-size: 1.2rem;
            text-decoration: none;
        }
        .sidebar-menu span {
            font-size: 16px;
        }
        .sidebar-menu a.active {
            background: #c6c0c085;
            padding-top: 1rem;
            padding-bottom: 1rem;
            color: beige;
        }
        .sidebar-menu a span:first-child {
            font-size: 1.5rem;
            padding-right: 1rem;
        }
        .main-content {
            margin-left: 345px;
            
        }
        #nav-toggle{
            display: none;
        }

        #nav-toggle:checked + .sidebar {
            width: 70px;
        }
        #nav-toggle:checked + .sidebar .sidebar-brand ,
        #nav-toggle:checked + .sidebar li {
            padding-left: 1rem;
        }
        #nav-toggle:checked + .sidebar li a {
            padding-left: 0rem;
        }
        #nav-toggle:checked + .sidebar .sidebar-brand h1,
        #nav-toggle:checked + .sidebar li a span:last-child{
            display: none;
        }
        #nav-toggle:checked ~ .main-content header{
            width: calc(100% - 70px);
            left: 70px;
        }
        #nav-toggle:checked ~ .main-content {
            margin-left: 70px;
        }
        .main-content {
            transition: margin-left 300ms;
            margin-left: 345px;
        }

        header {
            background: #ffffff;
            display: flex;
            justify-content: space-between;
            padding: 1rem 1.5rem;
            box-shadow: 2px 2px 5px rgba(0,0,0,0.2);
            position: fixed;
            left: 345px;
            width: calc(100% - 345px);
            top: 0;
            z-index: 100;
            transition: width 300ms;
        }
        header h1{
            font-size: 20px;
            font-weight: bold;
            color: #000;
        }

        main {
            margin-top: 69px;
            padding: 2rem 1.5rem;
            background: #f1f5f9;
            min-height: calc(100vh - 90px);
        }

        .wrapper-search{
            display: flex;
        }
        .wrapper-search .btn-search{
            margin-right: 2rem; 
        }
        .wrapper-search .search-barang{
            position: relative;
            padding-right: 30px;
            padding-left: 30px; 
        }
   
        .wrapper-search .img-kategori{
            position: absolute;
            top: 50%;
            left: 2rem;
            transform: translateY(-50%);
            cursor: pointer;
            z-index: 1;
        }
        .wrapper-search .kategori{
            position: relative;
            padding-right: 30px;
            padding-left: 30px; 
        }
        .wrapper-search .search{
            position: absolute;
            top: 50%;
            left: 2rem;
            transform: translateY(-50%);
            cursor: pointer;
            z-index: 1;
        }

        @media only screen and (max-width: 1200px){
            .sidebar {
            width: 70px;
            }
            .sidebar .sidebar-brand ,
            .sidebar li {
                padding-left: 1rem;
            }
            .sidebar li a {
                padding-left: 0rem;
            }
            .sidebar .sidebar-brand h1,
            .sidebar li a span:last-child{
                display: none;
            }
            .main-content header{
                width: calc(100% - 70px);
                left: 70px;
            }
            .main-content {
                margin-left: 70px;
            }
        }
       
    </style>

</head>
<body>
    <input type="checkbox" id="nav-toggle">
    @include('layouts.sidebar')

    <div class="main-content">
        @yield('section')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

    
</body>
</html>