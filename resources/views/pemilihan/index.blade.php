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

    <div class="card">
        <div class="card-body table-responsive">
            <table id="tblPemilih" class="table table-bordered">
                <thead>
                    <tr>
                        <th class="border-y-none" width="5">#</th>
                        <th class="border-y-none">Nama Peserta</th>
                        <th class="border-y-none text-center">Tipe</th>
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

    <script>
        function showDatatable() {
            $("#tblPemilih").DataTable();
        }

        showDatatable();
    </script>
@endsection
