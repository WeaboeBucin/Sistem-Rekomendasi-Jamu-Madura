<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use DB;

class JamuController extends Controller
{
    // Menampilkan form input jamu
    public function showForm()
    {
        return view('jamu.form');
    }
    public function detailJamu($id)
    {
        $jamu = $jamu = DB::table('jamu')->where('NO', $id)->first();;
        return view('jamu.detail', compact('jamu'));
    }

    public function rekomendasiJamu(Request $request)
    {

         // 1. Ambil input dari user
        //  dd($request);
        $data['inputText'] = $request->input('KHASIAT');

        // 2. Kirim ke API Python (Flask) untuk dapatkan rekomendasi
        $response = Http::post('http://localhost:5000/rekomendasi-jamu', [
            'text' => $data['inputText']
        ]);
 
        if ($response->failed()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal terhubung ke layanan rekomendasi.'
            ], 500);
        }
 
        $result = $response->json();
        $recommendedNames = $result['recommendations'];
 
        // 3. Ambil data jamu dari database berdasarkan nama yang direkomendasikan
        $data['rekomendasi'] = collect($recommendedNames)->map(function ($item) {
        $jamu = DB::table('jamu')->where('NAMA_JAMU', $item['NAMA_JAMU'])
                ->where('PRODUSEN', $item['PRODUSEN'])
                ->first();

            if ($jamu) {
                return [
                    'jamu' => $jamu,
                    'skor' => $item['skor']
                ];
            }

            return null;
        })->filter();
    
        return view('jamu.result', $data);
    }
}
