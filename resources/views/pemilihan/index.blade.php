@extends('layouts.main')
@section('title', 'Pemilihan')
@section('header-title', 'Pemilihan')
@section('list-header')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Pemilihan</a></li>
    </ol>
@endsection

@section('content')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-3">
                    <div class="form-group">
                        <label for="#">Tipe</label>
                        <select name="filterTipe" id="filterTipe" class="form-control">
                            <option value="">Pilih Tipe...</option>
                            @foreach ($tipeses as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="form-group">
                        <label for="#">Tingkatan</label>
                        <select name="filterTingkatan" id="filterTingkatan" class="form-control">
                            <option value="">Pilih Tingkatan...</option>
                            @foreach ($tingkatans as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="form-group">
                        <label for="#">Kelas</label>
                        <select name="filterKelas" id="filterKelas" class="form-control">
                            <option value="">Pilih Kelas...</option>
                            @foreach ($kelases as $row)
                                <option value="{{ $row->id_kelas }}">{{ $row->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="form-group">
                        <label for="#">Status Pilih</label>
                        <select name="filterStatusPilih" id="filterStatusPilih" class="form-control">
                            <option value="">Pilih Status Pilih...</option>
                            @foreach ($statusPilih as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="form-group">
                        <label for="#">Hasil Pilih</label>
                        <select name="filterHasilPilih" id="filterHasilPilih" class="form-control">
                            <option value="">Pilih Hasil Pilih...</option>
                            @foreach ($hasilPilih as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body table-responsive">
            <table id="tblPemilih" class="table table-bordered">
                <thead>
                    <tr>
                        <th class="border-y-none" width="5">#</th>
                        <th class="border-y-none">Nama Peserta</th>
                        <th class="border-y-none text-center" width="5">Tipe</th>
                        <th class="border-y-none">Waktu</th>
                        <th class="border-y-none text-center" width="5">Status</th>
                        <th class="text-center border-y-none" width="5">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pemilihs as $pemilih)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $pemilih->nama_peserta }}</td>
                            <td class="text-center">
                                @if ($pemilih->tipe == 1)
                                    Siswa
                                @endif
                                @if ($pemilih->tipe == 2)
                                    Guru
                                @endif
                                @if ($pemilih->tipe == 3)
                                    Karyawan
                                @endif
                            </td>
                            <td>
                                @if ($pemilih->waktu)
                                    {{ date('d-m-Y H:i:s', strtotime($pemilih->waktu)) }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if ($pemilih->id_pemilihan)
                                    <span class="badge badge-success p-2">Sudah Memilih</span>
                                @else
                                    <span class="badge badge-danger p-2">Belum Memilih</span>
                                @endif
                            </td>
                            <td>
                                @if ($pemilih->id_pemilihan)
                                    @if ($pemilih->status == 1)
                                        <button class="badge badge-danger p-2"
                                            data-pemilihan-id="{{ $pemilih->id_pemilihan }}">
                                            Nonaktifkan
                                        </button>
                                    @else
                                        <button class="badge badge-primary p-2"
                                            data-pemilihan-id="{{ $pemilih->id_pemilihan }}">
                                            Aktifkan
                                        </button>
                                    @endif
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>

    <script>
        const configSelect2 = {
            theme: 'bootstrap4',
            width: "100%"
        }

        const csrf = $('meta[name="csrf-token"]').attr('content');

        function showDatatable() {
            $("#tblPemilih").DataTable({
                columnDefs: [{
                    targets: [2, 4, 5],
                    orderable: false,
                }]
            });
        }

        $("#filterTipe").select2(configSelect2);
        $("#filterTingkatan").select2(configSelect2);
        $("#filterKelas").select2(configSelect2);
        $("#filterStatusPilih").select2(configSelect2);
        $("#filterHasilPilih").select2(configSelect2);

        showDatatable();
    </script>
@endsection
