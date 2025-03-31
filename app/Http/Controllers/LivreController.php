<?php

namespace App\Http\Controllers;

use App\Models\LivreModel;
use Illuminate\Http\Request;

class LivreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $livre = LivreModel::paginate(10);
        return view('Livre.livre',['livre'=>$livre]);
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $livre = new LivreModel();
        return view('Livre.AjoutLivre', compact('livre'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required',
            'auteur' => 'required',
            'prix' => 'required|numeric|min:0',

            'description' => 'required',
            'Stockdisponible' => 'required|numeric|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $livre = new LivreModel();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('storage'), $imageName);

            $livre->image = $imageName;
        } else {
            $livre->image = null;
        }

        $livre->titre = $request['titre'];
        $livre->auteur = $request['auteur'];
        $livre->prix = $request['prix'];
        $livre->description = $request['description'];
        $livre->Stockdisponible = $request['Stockdisponible'];
        $livre->save();

        return redirect('/livre')->with("success", "Livre ajouté avec succès");

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $livre = LivreModel::find($id);
        return view('Livre.AjoutLivre', compact('livre'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
