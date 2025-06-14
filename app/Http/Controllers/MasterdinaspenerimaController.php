<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Masterdinaspenerima;

class MasterdinaspenerimaController extends Controller
{
    public function index(Request $request)
    {
        if($request->has('search')){
            $masterdinaspenerima = Masterdinaspenerima::where('nama', 'LIKE', '%' .$request->search.'%')->paginate(10);
        }else{
            $masterdinaspenerima = masterdinaspenerima::paginate(10);
        }
        return view('masterdinaspenerima.index',[
            'masterdinaspenerima' => $masterdinaspenerima
        ]);
    }


    public function create()
    {
        return view('masterdinaspenerima.create');
    }


    public function store(Request $request)
    {
        $data = $request->all();

        masterdinaspenerima::create($data);

        return redirect()->route('masterdinaspenerima.index')->with('success', 'Data Telah ditambahkan');
    }


    public function show($id)
    {

    }


    public function edit(masterdinaspenerima $masterdinaspenerima)
    {
        return view('masterdinaspenerima.edit', [
            'item' => $masterdinaspenerima
        ]);
    }


    public function update(Request $request, masterdinaspenerima $masterdinaspenerima)
    {
        $data = $request->all();

        $masterdinaspenerima->update($data);

        //dd($data);

        return redirect()->route('masterdinaspenerima.index')->with('success', 'Data Telah diupdate');

    }


    public function destroy(masterdinaspenerima $masterdinaspenerima)
    {
        $masterdinaspenerima->delete();
        return redirect()->route('masterdinaspenerima.index')->with('success', 'Data Telah dihapus');
    }
}
