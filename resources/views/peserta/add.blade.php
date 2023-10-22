@extends('layouts.main')
@section('title', 'Tambah Peserta')
@section('header-title', 'Tambah Peserta')

@section('list-header')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">Peserta</li>
        <li class="breadcrumb-item"><a href="#">Tambah Peserta</a></li>
    </ol>
@endsection

@section('content')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

    <div class="card">
        <div class="card-body d-flex justify-content-end">
            <a href="/peserta" class="btn btn-primary">
                <i class="ri-arrow-left-line"></i>
                Kembali
            </a>
        </div>
    </div>


    <div class="card">
        <div class="card-body">
            <form action="/peserta/store" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="#">Nama Peserta</label>
                            <input type="text" class="form-control" name="nama_peserta" placeholder="Nama Peserta...">
                            @error('nama_peserta')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <label for="#">Tipe</label>
                        <select name="tipe" id="tipe" class="form-control">
                            <option value="">Pilih Tipe...</option>
                            @foreach ($tipeses as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-4">
                        <label for="#">Tingkatan</label>
                        <select name="tingkatan" id="tingkatan" class="form-control">
                            <option value="">Pilih Tingkatan...</option>
                            @foreach ($tingkatans as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-4">
                        <label for="#">Kelas</label>
                        <select name="kelas" id="kelas" class="form-control">
                            <option value="">Pilih Kelas...</option>
                            @foreach ($kelases as $kelas)
                                <option value="{{ $kelas->id_kelas }}">{{ $kelas->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>

    <script>
        const configSelect2 = {
            theme: 'bootstrap4',
            width: "100%"
        }

        $("#tipe").select2(configSelect2);
        $("#tingkatan").select2(configSelect2);
        $("#kelas").select2(configSelect2);
    </script>
@endsection
