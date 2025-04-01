@extends("nav")
@section("navbar")

    <!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Gestion de Livres</title>
    <style>
        body {
            background-color: #f8f9fc;
            color: #5a5c69;
            font-family: 'Nunito', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            padding: 20px 0;
        }

        .card {
            border: none;
            border-radius: 0.35rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }

        .card-header {
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            color: white;
            font-weight: 700;
            padding: 1rem 1.25rem;
            border-radius: 0.35rem 0.35rem 0 0;
        }

        .btn-primary {
            background-color: #4e73df;
            border-color: #4e73df;
            box-shadow: 0 0.125rem 0.25rem 0 rgba(58, 59, 69, 0.2);
            transition: all 0.2s;
        }

        .btn-primary:hover {
            background-color: #2e59d9;
            border-color: #2e59d9;
            transform: translateY(-1px);
        }
    </style>
</head>
<body>

<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="m-0 font-weight-bold">
                    <i class="fas fa-book me-2"></i>
                    {{$livre->exists ? "MODIFICATION DU LIVRE" : "AJOUT DE LIVRE"}}
                </h3>
            </div>
        </div>
        <div class="card-body">
            <form action="{{route($livre->exists ? 'updateLivre' : 'saveLivre', $livre)}}" method="POST" enctype="multipart/form-data">
                @method($livre->exists ? "put" : "post")
                @csrf
                <div class="mb-3">
                    <label class="form-label" for="image">Image:</label>
                    <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror">
                    @error('image')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="titre" class="form-label">Titre</label>
                    <input type="text" class="form-control @error('titre') is-invalid @enderror" id="titre"
                           name="titre" value="{{$livre->titre ? $livre->titre : old('titre')}}">
                    @error('titre')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="auteur" class="form-label">Auteur</label>
                    <input type="text" class="form-control @error('auteur') is-invalid @enderror" id="auteur" name="auteur"
                           value="{{$livre->auteur ? $livre->auteur : old('auteur')}}">
                    @error('auteur')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="prix" class="form-label">Prix</label>
                    <input type="number" class="form-control @error('prix') is-invalid @enderror" id="prix" name="prix"
                           value="{{$livre->prix ? $livre->prix : old('prix')}}">
                    @error('prix')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                              name="description" rows="3">{{$livre->description ? $livre->description : old('description')}}</textarea>
                    @error('description')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <div>
                    <label for="categorie" class="form-label">Categorie</label>
                    <input type="text" class="form-control @error('categorie') is-invalid @enderror" id="categorie"
                           name="categorie" value="{{$livre->categorie ? $livre->categorie : old('categorie')}}">
                    @error('categorie')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror

                </div>

                <div class="mb-3">
                    <label for="Stockdisponible" class="form-label">Stock Disponible</label>
                    <input type="number" class="form-control @error('Stockdisponible') is-invalid @enderror" id="Stockdisponible"
                           name="Stockdisponible" value="{{$livre->Stockdisponible ? $livre->Stockdisponible : old('Stockdisponible')}}">
                    @error('Stockdisponible')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    {{$livre->exists ? "MODIFIER" : "AJOUTER"}}
                </button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
@endsection
