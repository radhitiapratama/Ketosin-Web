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
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2/sweetalert2.min.css') }}">

    <div class="row">
        <div class="col-12 d-flex justify-content-end">
            <a href="/batas-waktu" class="btn btn-primary">
                <i class="ri-arrow-left-line"></i>
                Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-md-6">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="card-title">
                        Tambah Batas Waktu
                    </div>
                </div>
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

    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>

    <script>
        @if (session()->has('minFinish'))
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                iconColor: "#FFF",
                title: 'Waktu Selesai tidak boleh kurang dari waktu mulai',
                showConfirmButton: false,
                customClass: {
                    popup: 'colored-toast'
                },
                timer: 3000,
                toast: true
            });
        @endif
    </script>
@endsection
