<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Kekurangan;
use App\Models\Masterbarang;
use Illuminate\Http\Request;

class KekuranganController extends Controller
{
    public function index(Request $request)
{
    if ($request->has('search')) {
        $kekurangan = Kekurangan::whereHas('masterbarang', function($query) use ($request) {
            $query->where('nama', 'LIKE', '%' . $request->search . '%');
        })->paginate(10);
    } else {
        $kekurangan = Kekurangan::paginate(10);
    }

    return view('kekurangan.index', [
        'kekurangan' => $kekurangan
    ]);
}


    public function create()
{
    $masterbarang = Masterbarang::all();

    return view('kekurangan.create', [
        'masterbarang' => $masterbarang,
    ]);
}

public function store(Request $request)
{
    $data = $request->all();


    Kekurangan::create($data);
    return redirect()->route('kekurangan.index')->with('success', 'Data telah ditambahkan');
}



    public function show($id)
    {

    }


    public function edit(Kekurangan $kekurangan)
    {
        $masterbarang = Masterbarang::all();

        return view('kekurangan.edit', [
            'item' => $kekurangan,
            'masterbarang' => $masterbarang,
        ]);
    }


    public function update(Request $request, Kekurangan $kekurangan)
    {
        $data = $request->all();

        $kekurangan->update($data);

        //dd($data);

        return redirect()->route('kekurangan.index')->with('success', 'Data Telah diupdate');

    }


    public function destroy(Kekurangan $kekurangan)
    {
        $kekurangan->delete();
        return redirect()->route('kekurangan.index')->with('success', 'Data Telah dihapus');
    }

    //Approval Status
//     public function updateStatuskekurangan(Request $request, $id)
// {
//     $validated = $request->validate([
//         'status' => 'required|in:Terverifikasi,Ditolak',
//     ]);

//     $kekurangan = Kekurangan::findOrFail($id);

//     $kekurangan->status = $validated['status'];
//     $kekurangan->save();

//     return redirect()->route('kekurangan.index')->with('success', 'Status surat berhasil diperbarui.');
// }













    //Report
    //  Laporan Buku kekurangan Filter
     public function cetakkekuranganpertanggal()
     {
         $kekurangan = Kekurangan::Paginate(10);

         return view('laporannya.laporankekurangan', ['laporankekurangan' => $kekurangan]);
     }

     public function filterdatekekurangan(Request $request)
     {
         $startDate = $request->input('dari');
         $endDate = $request->input('sampai');

          if ($startDate == '' && $endDate == '') {
             $laporankekurangan = Kekurangan::paginate(10);
         } else {
             $laporankekurangan = Kekurangan::whereDate('tanggal','>=',$startDate)
                                         ->whereDate('tanggal','<=',$endDate)
                                         ->paginate(10);
         }
         session(['filter_start_date' => $startDate]);
         session(['filter_end_date' => $endDate]);

         return view('laporannya.laporankekurangan', compact('laporankekurangan'));
     }


     public function laporankekuranganpdf(Request $request )
     {
         $startDate = session('filter_start_date');
         $endDate = session('filter_end_date');

         if ($startDate == '' && $endDate == '') {
             $laporankekurangan = Kekurangan::all();
         } else {
             $laporankekurangan = Kekurangan::whereDate('tanggal', '>=', $startDate)
                                             ->whereDate('tanggal', '<=', $endDate)
                                             ->get();
         }

         // Render view dengan menyertakan data laporan dan informasi filter
         $pdf = PDF::loadview('laporannya.laporankekuranganpdf', compact('laporankekurangan'));
         return $pdf->download('laporan_laporankekurangan.pdf');
     }
}
