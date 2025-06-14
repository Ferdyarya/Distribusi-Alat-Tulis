<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Barangjarang;
use App\Models\Masterbarang;
use Illuminate\Http\Request;

class BarangjarangController extends Controller
{
    public function index(Request $request)
{
    if ($request->has('search')) {
        $barangjarang = Barangjarang::whereHas('masterbarang', function($query) use ($request) {
            $query->where('nama', 'LIKE', '%' . $request->search . '%');
        })->paginate(10);
    } else {
        $barangjarang = Barangjarang::paginate(10);
    }

    return view('barangjarang.index', [
        'barangjarang' => $barangjarang
    ]);
}


    public function create()
{
    $masterbarang = Masterbarang::all();

    return view('barangjarang.create', [
        'masterbarang' => $masterbarang,
    ]);
}

public function store(Request $request)
{

    $data = $request->all();
    // dd($data);
    Barangjarang::create($data);

    return redirect()->route('barangjarang.index')->with('success', 'Data telah ditambahkan');
}



    public function show($id)
    {

    }


    public function edit(Barangjarang $barangjarang)
    {
        $masterbarang = Masterbarang::all();

        return view('barangjarang.edit', [
            'item' => $barangjarang,
            'masterbarang' => $masterbarang,
        ]);
    }


    public function update(Request $request, Barangjarang $barangjarang)
    {
        $data = $request->all();

        $barangjarang->update($data);

        //dd($data);

        return redirect()->route('barangjarang.index')->with('success', 'Data Telah diupdate');

    }


    public function destroy(Barangjarang $barangjarang)
    {
        $barangjarang->delete();
        return redirect()->route('barangjarang.index')->with('success', 'Data Telah dihapus');
    }

    //Approval Status
    public function updateStatusBarangJarang(Request $request, $id)
{
    $validated = $request->validate([
        'status' => 'required|in:Terverifikasi,Ditolak',
    ]);

    $barangjarang = Barangjarang::findOrFail($id);

    $barangjarang->status = $validated['status'];
    $barangjarang->save();

    return redirect()->route('barangjarang.index')->with('success', 'Status surat berhasil diperbarui.');
}













    //Report
    //  Laporan Buku barangjarang Filter
     public function cetakbarangjarangpertanggal()
     {
         $barangjarang = Barangjarang::Paginate(10);

         return view('laporannya.laporanbarangjarang', ['laporanbarangjarang' => $barangjarang]);
     }

     public function filterdatebarangjarang(Request $request)
     {
         $startDate = $request->input('dari');
         $endDate = $request->input('sampai');

          if ($startDate == '' && $endDate == '') {
             $laporanbarangjarang = Barangjarang::paginate(10);
         } else {
             $laporanbarangjarang = Barangjarang::whereDate('tanggal','>=',$startDate)
                                         ->whereDate('tanggal','<=',$endDate)
                                         ->paginate(10);
         }
         session(['filter_start_date' => $startDate]);
         session(['filter_end_date' => $endDate]);

         return view('laporannya.laporanbarangjarang', compact('laporanbarangjarang'));
     }


     public function laporanbarangjarangpdf(Request $request )
     {
         $startDate = session('filter_start_date');
         $endDate = session('filter_end_date');

         if ($startDate == '' && $endDate == '') {
             $laporanbarangjarang = Barangjarang::all();
         } else {
             $laporanbarangjarang = Barangjarang::whereDate('tanggal', '>=', $startDate)
                                             ->whereDate('tanggal', '<=', $endDate)
                                             ->get();
         }

         // Render view dengan menyertakan data laporan dan informasi filter
         $pdf = PDF::loadview('laporannya.laporanbarangjarangpdf', compact('laporanbarangjarang'));
         return $pdf->download('laporan_laporanbarangjarang.pdf');
     }
}
