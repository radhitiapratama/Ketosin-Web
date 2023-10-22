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

    <div class="card">
        <div class="card-body d-flex justify-content-end">
            <a href="/batas-waktu" class="btn btn-primary">
                <i class="ri-arrow-left-line"></i>
                Kembali
            </a>
        </div>
    </div>
    <div class="row col-12 col-md-6">
        <div class="card">
            <div class="card-body">
                <form action="/batas-waktu/update" method="POST">
                    @csrf
                    <input type="hidden" name="id_waktu" value="{{ $waktu->id_waktu }}">
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="#">Waktu Mulai</label>
                                <input type="datetime-local" name="start" class="form-control"
                                    value="{{ $waktu->start }}">
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="#">Waktu Selesai</label>
                                <input type="datetime-local" name="finish" class="form-control"
                                    value="{{ $waktu->finish }}">
                            </div>
                        </div>
                        <div class="col-12 col-md-12">
                            <div class="form-group">
                                <label for="#">Status</label>
                                <select name="status" id="status" class="form-control">
                                    @if ($waktu->status == 1)
                                        <option value="1" selected>Aktif</option>
                                    @else
                                        <option value="">Pilih...</option>
                                        @foreach ($statuses as $key => $value)
                                            <option value="{{ $key }}" @selected($waktu->status == $key)>
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
    <script>
        const configSelect2 = {
            theme: "bootstrap4",
            width: "100%"
        };

        $("#status").select2(configSelect2);
    </script>

@endsection
