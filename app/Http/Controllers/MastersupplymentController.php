<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mastersupplyment;

class MastersupplymentController extends Controller
{
    public function index(Request $request)
    {
        if($request->has('search')){
            $mastersupplyment = Mastersupplyment::where('nama', 'LIKE', '%' .$request->search.'%')->paginate(10);
        }else{
            $mastersupplyment = Mastersupplyment::paginate(10);
        }
        return view('mastersupplyment.index',[
            'mastersupplyment' => $mastersupplyment
        ]);
    }


    public function create()
    {
        return view('mastersupplyment.create');
    }


    public function store(Request $request)
    {
        $data = $request->all();

        Mastersupplyment::create($data);

        return redirect()->route('mastersupplyment.index')->with('success', 'Data Telah ditambahkan');
    }


    public function show($id)
    {

    }


    public function edit(Mastersupplyment $mastersupplyment)
    {
        return view('mastersupplyment.edit', [
            'item' => $mastersupplyment
        ]);
    }


    public function update(Request $request, Mastersupplyment $mastersupplyment)
    {
        $data = $request->all();

        $mastersupplyment->update($data);

        //dd($data);

        return redirect()->route('mastersupplyment.index')->with('success', 'Data Telah diupdate');

    }


    public function destroy(Mastersupplyment $mastersupplyment)
    {
        $mastersupplyment->delete();
        return redirect()->route('mastersupplyment.index')->with('success', 'Data Telah dihapus');
    }
}
