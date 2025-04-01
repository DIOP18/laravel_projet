@extends("nav")
@section("navbar")

    <!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Bibliothèque</title>
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

        .table {
            border-collapse: separate;
            border-spacing: 0;
        }

        .table thead th {
            background-color: #f8f9fc;
            border-top: none;
            color: #4e73df;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.03rem;
            padding: 1rem;
            border-bottom: 2px solid #e3e6f0;
        }

        .table tbody tr:hover {
            background-color: rgba(78, 115, 223, 0.05);
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

        .btn-danger {
            background-color: #e74a3b;
            border-color: #e74a3b;
            box-shadow: 0 0.125rem 0.25rem 0 rgba(58, 59, 69, 0.2);
            transition: all 0.2s;
        }

        .btn-danger:hover {
            background-color: #d52a1a;
            border-color: #d52a1a;
            transform: translateY(-1px);
        }

        .book-image {
            height: 80px;
            width: 60px;
            object-fit: cover;
            border-radius: 4px;
            box-shadow: 0 0.125rem 0.25rem 0 rgba(58, 59, 69, 0.2);
            transition: transform 0.3s;
        }

        .book-image:hover {
            transform: scale(1.5);
            z-index: 1000;
        }

        .pagination {
            margin-top: 1.5rem;
            justify-content: center;
        }

        .alert-success {
            background-color: #1cc88a;
            border-color: #169b6b;
            color: white;
        }

        .stock-badge {
            padding: 0.35em 0.65em;
            font-size: 0.75em;
            font-weight: 700;
            border-radius: 0.25rem;
        }

        .stock-high {
            background-color: #1cc88a;
            color: white;
        }

        .stock-medium {
            background-color: #f6c23e;
            color: white;
        }

        .stock-low {
            background-color: #e74a3b;
            color: white;
        }

        .description-cell {
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .category-cell {
            max-width: 150px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .action-buttons {
            display: flex;
            gap: 5px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="m-0 font-weight-bold">
                    <i class="fas fa-book me-2"></i>GESTION DES LIVRES
                </h3>
                <a class="btn btn-light" href="{{route('ajoutLivre')}}">
                    <i class="fas fa-plus me-1"></i> Ajouter un livre
                </a>
            </div>
        </div>
        <div class="card-body">
            @if(session("archive"))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{session("archive")}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(session("success"))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{session("success")}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(session("modification"))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{session("modification")}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(session("Suppression"))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{session("Suppression")}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                    <tr>
                        <th scope="col"><i class="fas fa-image me-1"></i> Image</th>
                        <th scope="col"><i class="fas fa-heading me-1"></i> Titre</th>
                        <th scope="col"><i class="fas fa-user-edit me-1"></i> Auteur</th>
                        <th scope="col"><i class="fas fa-tag me-1"></i> Prix</th>
                        <th scope="col"><i class="fas fa-align-left me-1"></i> Description</th>
                        <th scope="col"><i class="fas fa-folder me-1"></i> Catégorie</th>
                        <th scope="col"><i class="fas fa-cubes me-1"></i> Stock</th>
                        <th scope="col"><i class="fas fa-cogs me-1"></i> Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($livre as $l)
                        <tr>
                            <td>
                                @if(!empty($l->image) && file_exists(public_path('storage/'.$l->image)))
                                    <img class="book-image" src="{{asset('storage/'.$l->image)}}" alt="{{$l->titre}}">
                                @else
                                    <img class="book-image" src="{{asset('storage/image.jpg')}}" alt="Image par défaut">
                                @endif
                            </td>
                            <td class="fw-bold">{{$l->titre}}</td>
                            <td>{{$l->auteur}}</td>
                            <td>{{number_format($l->prix,0)}}</td>
                            <td class="description-cell" title="{{$l->description}}">{{$l->description}}</td>
                            <td class="category-cell" title="{{$l->categorie}}">{{$l->categorie}}</td>
                            <td>
                                @if($l->Stockdisponible > 10)
                                    <span class="stock-badge stock-high">{{$l->Stockdisponible}}</span>
                                @elseif($l->Stockdisponible > 3)
                                    <span class="stock-badge stock-medium">{{$l->Stockdisponible}}</span>
                                @else
                                    <span class="stock-badge stock-low">{{$l->Stockdisponible}}</span>
                                @endif
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a class="btn btn-primary btn-sm" href="{{ route('editLivre', $l->id) }}" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('deleteLivre', $l->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    @if($l->archived)
                                        <form action="{{ route('unarchiveLivre', $l->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-success btn-sm" title="Désarchiver">
                                                <i class="fas fa-box-open"></i>
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('archiveLivre', $l->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-warning btn-sm" title="Archiver">
                                                <i class="fas fa-archive"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="pagination-container">
                {{$livre->links()}}
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
@endsection
