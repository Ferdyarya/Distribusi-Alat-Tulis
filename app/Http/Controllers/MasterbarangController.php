<?php

namespace App\Http\Controllers;

use App\Models\Masterbarang;
use Illuminate\Http\Request;

class MasterbarangController extends Controller
{
    public function index(Request $request)
    {
        if($request->has('search')){
            $masterbarang = Masterbarang::where('nama', 'LIKE', '%' .$request->search.'%')->paginate(10);
        }else{
            $masterbarang = Masterbarang::paginate(10);
        }
        return view('masterbarang.index',[
            'masterbarang' => $masterbarang
        ]);
    }


    public function create()
    {
        return view('masterbarang.create');
    }


    public function store(Request $request)
    {
        $data = $request->all();

        Masterbarang::create($data);

        return redirect()->route('masterbarang.index')->with('success', 'Data Telah ditambahkan');
    }


    public function show($id)
    {

    }


    public function edit(Masterbarang $masterbarang)
    {
        return view('masterbarang.edit', [
            'item' => $masterbarang
        ]);
    }


    public function update(Request $request, Masterbarang $masterbarang)
    {
        $data = $request->all();

        $masterbarang->update($data);

        //dd($data);

        return redirect()->route('masterbarang.index')->with('success', 'Data Telah diupdate');

    }


    public function destroy(Masterbarang $masterbarang)
    {
        $masterbarang->delete();
        return redirect()->route('masterbarang.index')->with('success', 'Data Telah dihapus');
    }
}
