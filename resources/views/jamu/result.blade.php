<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Rekomendasi Jamu</title>

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
    <div class="juduls">
        <h1>Hasil Rekomendasi Jamu</h1>
    </div>
    
    @if (isset($rekomendasi))
    <div class="container">
        <h3>Rekomendasi Jamu Terbaik:</h3>

        <div class="product">
        @foreach ($rekomendasi as $item)
        @php $jamu = $item['jamu']; @endphp
            <div class="cards">
                <img src="{{ asset('img/jahe.png')}}" alt="produk">
                <p>Skor: {{ number_format($item['skor'], 4) }}</p>
                <h5><a href="{{ route('jamu.detail', ['id' => $jamu->NO]) }}">{{ $jamu->NAMA_JAMU }}</a></h5>
            </div>
        @endforeach
        </div>    
    </div>
    @else
        <p>Tidak ada rekomendasi yang ditemukan.</p>
    @endif
    
    <div class="rekom">
        <a href="{{ route('rekomendasi.form') }}">Cari Rekomendasi Lainnya</a>
    </div>   
</body>
</html>