@extends('layouts.main')
@section('title', 'Edit Batas Waktu')
@section('header-title', 'Edit Batas Waktu')
@section('list-header')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">Batas Waktu</li>
        <li class="breadcrumb-item"><a href="#">Edit Batas Waktu</a></li>
    </ol>
@endsection

@section('content')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2/sweetalert2.min.css') }}">

    <div class="row">
        <div class="col-12 d-flex justify-content-end">
            <a href="/batas-waktu" class="btn btn-primary">
                <i class="ri-arrow-left-line"></i>
                Kembali
            </a>
        </div>
    </div>
    <div class="row col-12 col-md-6">
        <div class="card card-primary">
            <div class="card-header">
                <div class="card-title">
                    Edit Batas Waktu
                </div>
            </div>
            <div class="card-body">
                <form action="/batas-waktu/update" method="POST">
                    @csrf
                    <input type="hidden" name="id_waktu" value="{{ $waktu->id_waktu }}">
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="#">Waktu Mulai</label>
                                <input type="datetime-local" name="start" class="form-control"
                                    value="{{ old('start', $waktu->start) }}">
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="#">Waktu Selesai</label>
                                <input type="datetime-local" name="finish" class="form-control"
                                    value="{{ old('finish', $waktu->finish) }}">
                            </div>
                        </div>
                        <div class="col-12 col-md-12">
                            <div class="form-group">
                                <label for="#">Status</label>
                                <select name="status" id="status" class="form-control">
                                    @if (old('status', $waktu->status) == 1)
                                        <option value="1" selected>Aktif</option>
                                    @else
                                        <option value="">Pilih...</option>
                                        @foreach ($statuses as $key => $value)
                                            <option value="{{ $key }}" @selected(old('status', $waktu->status) == $key)>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>

    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
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

    <script>
        const configSelect2 = {
            theme: "bootstrap4",
            width: "100%"
        };

        $("#status").select2(configSelect2);
    </script>

@endsection
