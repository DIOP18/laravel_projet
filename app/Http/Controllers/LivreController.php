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
            'categorie' => 'required',
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
        $livre->categorie = $request['categorie'];
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
        $livre = LivreModel::findOrFail($id);
        return view('Livre.AjoutLivre', compact('livre'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'titre' => 'required',
            'auteur' => 'required',
            'prix' => 'required|numeric|min:0',
            'description' => 'required',
            'categorie' => 'required',
            'Stockdisponible' => 'required|numeric|min:0',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $livre = LivreModel::findOrFail($id);
        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image si elle existe
            if ($livre->image && file_exists(public_path('storage/' . $livre->image))) {
                unlink(public_path('storage/' . $livre->image));
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('storage'), $imageName);
            $livre->image = $imageName;
        }
        $livre->titre = $request->titre;
        $livre->auteur = $request->auteur;
        $livre->prix = $request->prix;
        $livre->description = $request->description;
        $livre->categorie = $request->categorie;
        $livre->Stockdisponible = $request->Stockdisponible;

        $livre->save();
        return redirect('/livre')->with("modification", "Vous avez modifier ce livre");

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $livre = LivreModel::findOrFail($id);

        if ($livre->image && file_exists(public_path('storage/' . $livre->image))) {
            unlink(public_path('storage/' . $livre->image));
        }

        $livre->delete();
        return redirect('/livre')->with("Suppression", "Vous avez supprimer ce livre");

        //
    }
    public function unarchive($id)
    {
        $livre = LivreModel::findOrFail($id);
        $livre->archived = false;
        $livre->save();

        return redirect('/livre')->with("archive", "Livre désarchivé avec succès");
    }
    public function archive($id)
    {
        $livre = LivreModel::findOrFail($id);
        $livre->archived = true;
        $livre->save();

        return redirect('/livre')->with("archive", "Livre archivé avec succès");
    }

    public function catalogue(Request $request)
    {
        $query = LivreModel::where('archived', false);

        // Filtres
        if ($request->filled('auteur')) {
            $query->where('auteur', 'like', '%'.$request->auteur.'%');
        }

        if ($request->filled('categorie')) {
            $query->where('categorie', $request->categorie);
        }

        if ($request->filled('prix_min')) {
            $query->where('prix', '>=', $request->prix_min);
        }

        if ($request->filled('prix_max')) {
            $query->where('prix', '<=', $request->prix_max);
        }

        $livres = $query->paginate(12);
        $categories = LivreModel::distinct()->pluck('categorie');

        return view('Catalogues.catalogue', compact('livres', 'categories'));
    }

    public function showDetails($id)
    {
        $livre = LivreModel::findOrFail($id);
        return view('Catalogues.livre-details', compact('livre'));
    }


}
