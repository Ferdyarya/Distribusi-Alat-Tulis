<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Masterbarang;
use Illuminate\Http\Request;
use App\Models\Analisisbarang;
use App\Models\Masterdinaspenerima;

class AnalisisbarangController extends Controller
{
    public function index(Request $request)
{
    if ($request->has('search')) {
        $Analisisbarang = Analisisbarang::whereHas('masterbarang', function($query) use ($request) {
            $query->where('nama', 'LIKE', '%' . $request->search . '%');
        })->paginate(10);
    } else {
        $analisisbarang = Analisisbarang::paginate(10);
    }

    return view('analisisbarang.index', [
        'analisisbarang' => $analisisbarang
    ]);
}


    public function create()
{
    $masterbarang = Masterbarang::all();
    $masterdinaspenerima = Masterdinaspenerima::all();

    return view('analisisbarang.create', [
        'masterbarang' => $masterbarang,
        'masterdinaspenerima' => $masterdinaspenerima,
    ]);
}

public function store(Request $request)
{

    $data = $request->all();
    // dd($data);
    Analisisbarang::create($data);

    return redirect()->route('analisisbarang.index')->with('success', 'Data telah ditambahkan');
}



    public function show($id)
    {

    }


    public function edit(Analisisbarang $analisisbarang)
    {
        $masterbarang = Masterbarang::all();
        $masterdinaspenerima = Masterdinaspenerima::all();

        return view('analisisbarang.edit', [
            'item' => $analisisbarang,
            'masterbarang' => $masterbarang,
            'masterdinaspenerima' => $masterdinaspenerima,
        ]);
    }


    public function update(Request $request, Analisisbarang $analisisbarang)
    {
        $data = $request->all();

        $analisisbarang->update($data);

        //dd($data);

        return redirect()->route('analisisbarang.index')->with('success', 'Data Telah diupdate');

    }


    public function destroy(Analisisbarang $analisisbarang)
    {
        $analisisbarang->delete();
        return redirect()->route('analisisbarang.index')->with('success', 'Data Telah dihapus');
    }

    //Approval Status
    public function updateStatusAnalisis(Request $request, $id)
{
    $validated = $request->validate([
        'status' => 'required|in:Terverifikasi,Ditolak',
    ]);

    $analisisbarang = Analisisbarang::findOrFail($id);

    $analisisbarang->status = $validated['status'];
    $analisisbarang->save();

    return redirect()->route('analisisbarang.index')->with('success', 'Status surat berhasil diperbarui.');
}













    //Report
    //  Laporan Buku analisisbarang Filter
     public function cetakanalisisbarangpertanggal()
     {
         $analisisbarang = Analisisbarang::Paginate(10);

         return view('laporannya.laporananalisisbarang', ['laporananalisisbarang' => $analisisbarang]);
     }

     public function filterdateanalisisbarang(Request $request)
     {
         $startDate = $request->input('dari');
         $endDate = $request->input('sampai');

          if ($startDate == '' && $endDate == '') {
             $laporananalisisbarang = Analisisbarang::paginate(10);
         } else {
             $laporananalisisbarang = Analisisbarang::whereDate('tanggal','>=',$startDate)
                                         ->whereDate('tanggal','<=',$endDate)
                                         ->paginate(10);
         }
         session(['filter_start_date' => $startDate]);
         session(['filter_end_date' => $endDate]);

         return view('laporannya.laporananalisisbarang', compact('laporananalisisbarang'));
     }


     public function laporananalisisbarangpdf(Request $request )
     {
         $startDate = session('filter_start_date');
         $endDate = session('filter_end_date');

         if ($startDate == '' && $endDate == '') {
             $laporananalisisbarang = Analisisbarang::all();
         } else {
             $laporananalisisbarang = Analisisbarang::whereDate('tanggal', '>=', $startDate)
                                             ->whereDate('tanggal', '<=', $endDate)
                                             ->get();
         }

         // Render view dengan menyertakan data laporan dan informasi filter
         $pdf = PDF::loadview('laporannya.laporananalisisbarangpdf', compact('laporananalisisbarang'));
         return $pdf->download('laporan_laporananalisisbarang.pdf');
     }
}
