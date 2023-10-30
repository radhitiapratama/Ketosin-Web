@extends('layouts.main')
@section('title', 'Vote')
@section('header-title', 'Vote')
@section('list-header')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Vote</a></li>
    </ol>
@endsection

@section('content')
    <div class="row mb-3">
        <div class="col-12 d-flex justify-content-end">
            <a href="/peserta" class="btn btn-primary">
                <i class="ri-arrow-left-line"></i>
                Kembali
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-12 d-flex flex-wrap gap-20">
            @foreach ($kandidats as $kandidat)
                <div class="card" style="width: 18rem; overflow: hidden;">
                    <div>
                        @if ($kandidat->foto)
                            <img src="{{ asset('/storage/img-uploads/' . $kandidat->foto) }}" class="card-img-top"
                                alt="..." style="width: 100%;height: 100%; object-fit: cover">
                        @else
                            <img src="{{ asset('main-assets/imgs/default.jpg') }}" class="card-img-top" alt="..."
                                style="width: 100%;height: 100%; object-fit: cover">
                        @endif
                    </div>
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
                            <a href="/kandidat/detail/{{ $kandidat->id_kandidat }}" class="btn btn-primary">Detail <i
                                    class="ri-information-line"></i> </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
