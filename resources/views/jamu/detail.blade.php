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
    <div class="row mt-4 mb-4">
        <div class="d-flex justify-content-center">
            <form action="{{ route('rekomendasi.process') }}" method="POST">
                @csrf
                <div class="inputan">
                    <input type="text" id="khasiat" class="inputkhasiat" name="KHASIAT" placeholder="Search Here..." required><br><br>
                    <input type="submit" class="tombol" value="Cari Rekomendasi">
                </div>  
            </form>
        </div>
        <div class="row mt-4">
            <div class="col-md-5">
                <img src="{{ asset('img/jahe.png')}}" alt="Foto {{ $jamu->NAMA_JAMU }}" class="img-fluid rounded shadow-sm">
            </div>

            <!-- Deskripsi Jamu -->
            <div class="col-md-7">
                <h4 class="mb-2">{{ $jamu->NAMA_JAMU }}({{ $jamu->JENIS ?? 'Jamu' }}) </h4>
                <p class="text-muted"><strong>Khasiat:</strong> {{ $jamu->KHASIAT ?? 'Tidak tersedia' }}</p>
                <ul class="list-group mb-3 jamu-info">
                    <li class="list-group-item border-0"><strong>Aturan Minum:</strong> {{ $jamu->ATURAN_MINUM ?? 'Tidak tersedia' }}</li>
                    <li class="list-group-item border-0"><strong>Kandungan:</strong> {{ $jamu->KANDUNGAN ?? 'Tidak tersedia' }}</li>
                    <li class="list-group-item border-0"><strong>Efek Samping:</strong> {{ $jamu->EFEK_SAMPING ?? 'Tidak tersedia' }}</li>
                    <li class="list-group-item border-0"><strong>Produsen:</strong> {{ $jamu->PRODUSEN ?? 'Tidak tersedia' }}</li>
                </ul>
            </div>
        </div>

    </div>
</body>
</html>