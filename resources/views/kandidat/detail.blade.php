@extends('layouts.main')
@section('title', 'Detail Kandidat')
@section('header-title', 'Detail Kandidat')
@section('list-header')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Detail Kandidat</a></li>
    </ol>
@endsection

@section('content')
    <style>
        .title-tab {
            font-size: 18px;
        }
    </style>
    <div class="row mb-3">
        <div class="col-12 d-flex justify-content-end">
            <a href="/kandidat" class="btn btn-primary">
                <i class="ri-arrow-left-line"></i>
                Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-md-5">
            <div class="card card-primary">
                <div class="card-header d-flex justify-content-center align-items-center p-4">
                    {{ $kandidat->suara }} Suara

                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ $kandidat->nama_ketua }}</h5>
                    <p class="card-text text-secondary">{{ $kandidat->tingkatan_ketua }} {{ $kandidat->kelas_ketua }}</p>
                    <h5 class="card-title">{{ $kandidat->nama_wakil }}</h5>
                    <p class="card-text text-secondary">{{ $kandidat->tingkatan_wakil }} {{ $kandidat->kelas_wakil }}</p>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-7">
            <div class="card card-primary card-tabs">
                <div class="card-header p-0 pt-1">
                    <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#tab-detail"
                                role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Detail</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill"
                                href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile"
                                aria-selected="false">Visi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-one-messages-tab" data-toggle="pill"
                                href="#custom-tabs-one-messages" role="tab" aria-controls="custom-tabs-one-messages"
                                aria-selected="false">Misi</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="custom-tabs-one-tabContent">
                        <div class="tab-pane fade active show" id="tab-detail" role="tabpanel"
                            aria-labelledby="custom-tabs-one-home-tab">
                            <div class="form-group">
                                <label class="title-tab" for="#">Calon Ketua Osis</label>
                                <p class="text-secondary">{{ $kandidat->nama_ketua }} - {{ $kandidat->tingkatan_ketua }}
                                    {{ $kandidat->kelas_ketua }}
                                </p>
                            </div>
                            <div class="form-group">
                                <label class="title-tab" for="#">Calon Wakil Ketua Osis</label>
                                <p class="text-secondary">{{ $kandidat->nama_wakil }} - {{ $kandidat->tingkatan_wakil }}
                                    {{ $kandidat->kelas_wakil }}
                                </p>
                            </div>
                            <div class="form-group">
                                <label class="title-tab" for="#">Slogan</label>
                                <p class="text-secondary">{{ $kandidat->slogan }}</p>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel"
                            aria-labelledby="custom-tabs-one-profile-tab">
                            <div class="form-group">
                                <label class="title-tab" for="#">Visi Paslon</label>
                                <p class="text-secondary">{{ $kandidat->visi }}</p>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-one-messages" role="tabpanel"
                            aria-labelledby="custom-tabs-one-messages-tab">
                            @php
                                $misiArr = explode('|', $kandidat->misi);
                            @endphp
                            <div class="form-group">
                                <label class="title-tab" for="#">Misi Paslon</label>
                                @foreach ($misiArr as $row)
                                    <p class="text-secondary">{{ $row }}</p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
