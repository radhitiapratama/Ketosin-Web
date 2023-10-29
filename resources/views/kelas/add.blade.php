@extends('layouts.main')
@section('title', 'Tambah Kelas')
@section('header-title', 'Tambah Kelas')

@section('list-header')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">Kelas</li>
        <li class="breadcrumb-item"><a href="#">Tambah Kelas</a></li>
    </ol>
@endsection

@section('content')
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
                    <h3 class="card-title">Kelas</h3>
                </div>

                <form action="/kelas/store" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="#">Nama Kelas</label>
                            <input type="text" class="form-control" name="nama_kelas" id="#"
                                placeholder="Masukkan nama kelas" value="{{ old('nama_kelas') }}">
                            @error('nama_kelas')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
@endsection
