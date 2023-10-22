@extends('layouts.main')
@section('title', 'Edit Kelas')
@section('header-title', 'Edit Kelas')
@section('list-header')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">Kelas</li>
        <li class="breadcrumb-item"><a href="#">Edit Kelas</a></li>
    </ol>
@endsection

@section('content')
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">

    <div class="row">
        <div class="col-12 d-flex justify-content-end">
            <a href="/kelas" class="btn btn-primary">
                <i class="ri-arrow-left-line"></i>
                Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-md-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Edit Data Kelas</h3>
                </div>

                <form action="/kelas/update" method="POST">
                    @csrf
                    <input type="hidden" name="id_kelas" value="{{ $kelas->id_kelas }}">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="#">Nama Kelas</label>
                            <input type="text" class="form-control" name="nama_kelas" value="{{ $kelas->nama_kelas }}">
                            @error('nama_kelas')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="#">Status</label>
                            <select name="status" id="status" class="form-control select2">
                                @foreach ($statuses as $key => $value)
                                    <option value="{{ $key }}" @selected($key == $kelas->status)>{{ $value }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                </form>
            </div>
        </div>
    </div>

    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>

    <script>
        $("#status").select2({
            theme: "bootstrap4"
        });
    </script>

@endsection
