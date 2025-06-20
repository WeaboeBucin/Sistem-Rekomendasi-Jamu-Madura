<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Rekomendasi Jamu</title>

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css')}}">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <style>
        body{
            background-color: #F7EED3;
            font-family: sans-serif;
            text-align: center;
            display: flex;
            justify-content: center;
            flex-direction: column;
            align-items: center;
            color: #674636;
        }
    </style>
</head>
<body>
    <div class="judul">
        <h1>Sistem Rekomendasi Jamu Madura</h1>
    </div>
    
    <div class="formulir">
        <form action="{{ route('rekomendasi.process') }}" method="POST">
            @csrf
            <label for="khasiat" class="labelkhas">Khasiat:</label><br>

            <div class="inputan">
                <input type="text" id="khasiat" class="inputkhasiat" name="KHASIAT" placeholder="Search Here..." required><br><br>
                <input type="submit" class="tombol" value="Cari Rekomendasi">
            </div>  
        </form>
    </div>
    
    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bawah">
        <img src="{{ asset('img/jahe.png')}}" alt="jahe">
        <img src="{{ asset('img/herbal.png')}}" alt="herlbal">
    </div>

</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


</html>