@extends('layouts.main')
@section('title', 'Edit Peserta')
@section('header-title', 'Edit Peserta')
@section('list-header')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">Peserta</li>
        <li class="breadcrumb-item"><a href="#">Edit Peserta</a></li>
    </ol>
@endsection

@section('content')
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">

    <div class="row mb-3">
        <div class="col-12 d-flex justify-content-end">
            <a href="/peserta" class="btn btn-primary">
                <i class="ri-arrow-left-line"></i>
                Kembali
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="/peserta/update" method="POST">
                @csrf
                <input type="hidden" name="id_peserta" value="{{ $peserta->id_peserta }}">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="#">Nama Peserta</label>
                            <input type="text" id="nama_peserta" name="nama_peserta" class="form-control"
                                placeholder="Nama Peserta..." value="{{ $peserta->nama_peserta }}">
                            @error('nama_peserta')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="#">Tipe</label>
                            <select name="tipe" id="tipe" class="form-control">
                                <option value="">Pilih Tipe...</option>

                                @foreach ($tipeses as $key => $value)
                                    <option value="{{ $key }}" @selected($peserta->tipe == $key)>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="#">Tingkatan</label>
                            <select name="tingkatan" id="tingkatan" class="form-control">
                                <option value="">Pilih Tingkatan...</option>
                                @foreach ($tingkatans as $key => $value)
                                    <option value="{{ $key }}" @selected($peserta->tingkatan == $key)>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="#">Kelas</label>
                            <select name="kelas" id="kelas" class="form-control">
                                <option value="">Pilih Kelas...</option>
                                @foreach ($kelases as $kelas)
                                    <option value="{{ $kelas->id_kelas }}" @selected($kelas->id_kelas == $peserta->id_kelas)>
                                        {{ $kelas->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="#">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="">Pilih Status...</option>
                                @foreach ($statuses as $key => $value)
                                    <option value="{{ $key }}" @selected($key == $peserta->status)>{{ $value }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>

    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>

    <script>
        const configSelect2 = {
            theme: "bootstrap4"
        };

        $("#tipe").select2(configSelect2);
        $("#tingkatan").select2(configSelect2);
        $("#kelas").select2(configSelect2);
        $("#status").select2(configSelect2);
    </script>

@endsection
