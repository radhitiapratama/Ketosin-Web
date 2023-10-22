@extends('layouts.main')
@section('title', 'Tambah Batas Waktu')
@section('header-title', 'Tambah Batas Waktu')

@section('list-header')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">Batas Waktu</li>
        <li class="breadcrumb-item"><a href="#">Tambah Batas Waktu</a></li>
    </ol>
@endsection

@section('content')
    <div class="card">
        <div class="card-body d-flex justify-content-end">
            <a href="/batas-waktu" class="btn btn-primary">
                <i class="ri-arrow-left-line"></i>
                Kembali
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-6">
            <div class="card">
                <div class="card-body">
                    <form action="/batas-waktu/store" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="#">Waktu Mulai</label>
                                    <input type="datetime-local" name="start" class="form-control"
                                        value="{{ old('start') }}">
                                    @error('start')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="#">Waktu Selesai</label>
                                    <input type="datetime-local" name="finish" class="form-control"
                                        value="{{ old('finish') }}">
                                    @error('finish')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
