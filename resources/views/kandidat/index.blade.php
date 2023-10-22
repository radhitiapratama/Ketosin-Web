@extends('layouts.main')
@section('title', 'Kandidat')
@section('header-title', 'Kandidat')
@section('list-header')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Kandidat</a></li>
    </ol>
@endsection

@section('content')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">

    <div class="card">
        <div class="card-body">
            <a href="/kandidat/add" class="btn btn-primary">Tambah Kandidat <i class="ri-add-line ml-2"></i></a>
        </div>
    </div>

    @foreach ($kandidats as $kandidat)
        <div class="card" style="width: 18rem;">
            <img src="{{ asset('/storage/img-uploads/' . $kandidat->foto) }}" class="card-img-top" alt="...">
            <div class="card-body">
                <h6>{{ $kandidat->nama_ketua }}</h6>
                <p class="text-gray">
                    @if ($kandidat->tingkatan_ketua == 1)
                        X
                    @endif
                    @if ($kandidat->tingkatan_ketua == 2)
                        XI
                    @endif
                    @if ($kandidat->tingkatan_ketua == 3)
                        XII
                    @endif
                    {{ $kandidat->kelas_ketua }}
                </p>
                <h6>{{ $kandidat->nama_wakil }}</h6>
                <p class="text-gray">
                    @if ($kandidat->tingkatan_wakil == 1)
                        X
                    @endif
                    @if ($kandidat->tingkatan_wakil == 2)
                        XI
                    @endif
                    @if ($kandidat->tingkatan_wakil == 3)
                        XII
                    @endif {{ $kandidat->kelas_wakil }}
                </p>
                <div class="d-flex" style="gap: 20px">
                    <a href="#" class="btn btn-primary">Detail <i class="ri-information-line"></i> </a>
                    <a href="/kandidat/edit/{{ $kandidat->id_kandidat }}" class="btn btn-warning">Edit <i
                            class="ri-pencil-line"></i></a>
                </div>
            </div>
        </div>
    @endforeach



    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>

    <script></script>
@endsection
