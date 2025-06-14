<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Rusak;
use App\Models\Masterbarang;
use Illuminate\Http\Request;
use App\Models\Masterdinaspenerima;

class RusakController extends Controller
{
    public function index(Request $request)
{
    if ($request->has('search')) {
        $rusak = Rusak::whereHas('masterbarang', function($query) use ($request) {
            $query->where('nama', 'LIKE', '%' . $request->search . '%');
        })->paginate(10);
    } else {
        $rusak = Rusak::paginate(10);
    }

    return view('rusak.index', [
        'rusak' => $rusak
    ]);
}


    public function create()
{
    $masterbarang = Masterbarang::all();
    $masterdinaspenerima = Masterdinaspenerima::all();

    return view('rusak.create', [
        'masterbarang' => $masterbarang,
        'masterdinaspenerima' => $masterdinaspenerima,
    ]);
}

public function store(Request $request)
{
    // Validasi
    $request->validate([
        'bukti' => 'file|mimes:pdf',
    ]);

    $data = Rusak::create($request->all());
    if($request->hasFile('bukti')) {
        $request->file('bukti')->move('bukti/', $request->file('bukti')->getClientOriginalName());
        $data->bukti = $request->file('bukti')->getClientOriginalName();
        $data->save();
    }

    // Simpan perubahan pada entri
    $data->save();
    return redirect()->route('rusak.index')->with('success', 'Data telah ditambahkan');
}



    public function show($id)
    {

    }


    public function edit(Rusak $rusak)
    {
        $masterbarang = Masterbarang::all();
        $masterdinaspenerima = Masterdinaspenerima::all();

        return view('rusak.edit', [
            'item' => $rusak,
            'masterbarang' => $masterbarang,
            'masterdinaspenerima' => $masterdinaspenerima,
        ]);
    }


    public function update(Request $request, Rusak $rusak)
    {
        $data = $request->all();

        $rusak->update($data);

        //dd($data);

        return redirect()->route('rusak.index')->with('success', 'Data Telah diupdate');

    }


    public function destroy(Rusak $rusak)
    {
        $rusak->delete();
        return redirect()->route('rusak.index')->with('success', 'Data Telah dihapus');
    }

    //Approval Status
    public function updateStatusrusak(Request $request, $id)
{
    $validated = $request->validate([
        'status' => 'required|in:Terverifikasi,Ditolak',
    ]);

    $rusak = Rusak::findOrFail($id);

    $rusak->status = $validated['status'];
    $rusak->save();

    return redirect()->route('rusak.index')->with('success', 'Status surat berhasil diperbarui.');
}













    //Report
    //  Laporan Buku rusak Filter
     public function cetakrusakpertanggal()
     {
         $rusak = Rusak::Paginate(10);

         return view('laporannya.laporanrusak', ['laporanrusak' => $rusak]);
     }

     public function filterdaterusak(Request $request)
     {
         $startDate = $request->input('dari');
         $endDate = $request->input('sampai');

          if ($startDate == '' && $endDate == '') {
             $laporanrusak = Rusak::paginate(10);
         } else {
             $laporanrusak = Rusak::whereDate('tanggal','>=',$startDate)
                                         ->whereDate('tanggal','<=',$endDate)
                                         ->paginate(10);
         }
         session(['filter_start_date' => $startDate]);
         session(['filter_end_date' => $endDate]);

         return view('laporannya.laporanrusak', compact('laporanrusak'));
     }


     public function laporanrusakpdf(Request $request )
     {
         $startDate = session('filter_start_date');
         $endDate = session('filter_end_date');

         if ($startDate == '' && $endDate == '') {
             $laporanrusak = Rusak::all();
         } else {
             $laporanrusak = Rusak::whereDate('tanggal', '>=', $startDate)
                                             ->whereDate('tanggal', '<=', $endDate)
                                             ->get();
         }

         // Render view dengan menyertakan data laporan dan informasi filter
         $pdf = PDF::loadview('laporannya.laporanrusakpdf', compact('laporanrusak'));
         return $pdf->download('laporan_laporanrusak.pdf');
     }
}
