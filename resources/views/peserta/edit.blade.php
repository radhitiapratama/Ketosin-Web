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
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2/sweetalert2.min.css') }}">

    <div class="row mb-3">
        <div class="col-12 d-flex justify-content-end">
            <a href="/peserta" class="btn btn-primary">
                <i class="ri-arrow-left-line"></i>
                Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-12">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="card-title">Update Peserta</div>
                </div>
                <div class="card-body">
                    <form action="/peserta/update" method="POST">
                        @csrf
                        <input type="hidden" name="isKandidat" value="{{ $isKandidat }}">
                        <input type="hidden" name="id_peserta" value="{{ $peserta->id_peserta }}">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="#">Nama Peserta</label>
                                    <input type="text" id="nama_peserta" name="nama_peserta" class="form-control"
                                        placeholder="Nama Peserta..."
                                        value="{{ old('nama_peserta', $peserta->nama_peserta) }}" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="#">Tipe</label>
                                    <select name="tipe" id="tipe" class="form-control"
                                        {{ $isKandidat ? 'disabled' : '' }} required>
                                        <option value="">Pilih Tipe...</option>
                                        @foreach ($tipeses as $key => $value)
                                            <option value="{{ $key }}" @selected(old('tipe', $peserta->tipe) == $key)>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 form-siswa-wrapper">
                                @if (old('tipe', $peserta->tipe) == 1)
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label for="#">Tingkatan</label>
                                                <select name="tingkatan" id="tingkatan" class="form-control" required>
                                                    <option value="">Pilih Tingkatan...</option>
                                                    @foreach ($tingkatans as $key => $value)
                                                        <option value="{{ $key }}" @selected(old('tingkatan', $peserta->tingkatan) == $key)>
                                                            {{ $value }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label for="#">Kelas</label>
                                                <select name="kelas" id="kelas" class="form-control" required>
                                                    <option value="">Pilih Kelas...</option>
                                                    @foreach ($kelases as $kelas)
                                                        <option value="{{ $kelas->id_kelas }}"
                                                            @selected(old('kelas', $peserta->id_kelas) == $kelas->id_kelas)>
                                                            {{ $kelas->nama_kelas }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="#">Status</label>
                                    <select name="status" id="status" class="form-control" required>
                                        <option value="">Pilih Status...</option>
                                        @foreach ($statuses as $key => $value)
                                            <option @selected(old('status', $peserta->status) == $key) value="{{ $key }}">
                                                {{ $value }}
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
        </div>
    </div>


    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>

    <script>
        @if (session()->has('duplicate'))
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                iconColor: "#FFF",
                title: 'Nama Peserta sudah di gunakan !',
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
            width: "100%",
        };

        const formTipeSiswa = `
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="form-group">
                    <label for="#">Tingkatan</label>
                    <select name="tingkatan" id="tingkatan" class="form-control" required>
                        <option value="">Pilih Tingkatan...</option>
                        @foreach ($tingkatans as $key => $value)
                            <option value="{{ $key }}" @selected(old('tingkatan', $peserta->tingkatan) == $key)>
                                {{ $value }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="form-group">
                    <label for="#">Kelas</label>
                    <select name="kelas" id="kelas" class="form-control" required>
                        <option value="">Pilih Kelas...</option>
                        @foreach ($kelases as $kelas)
                            <option value="{{ $kelas->id_kelas }}"
                                @selected(old('kelas', $peserta->id_kelas) == $kelas->id_kelas)>
                                {{ $kelas->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        `;

        $("#tipe").select2(configSelect2);
        $("#tingkatan").select2(configSelect2);
        $("#kelas").select2(configSelect2);
        $("#status").select2(configSelect2);

        $("#tipe").change(function() {
            let tipe = $(this).val();
            if (tipe == 1) {
                $(".form-siswa-wrapper").html(formTipeSiswa);
                $("#tingkatan").select2(configSelect2);
                $("#kelas").select2(configSelect2);
            } else {
                $(".form-siswa-wrapper").html("");
            }
        });
    </script>

@endsection
