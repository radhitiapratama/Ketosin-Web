@extends('layouts.main')
@section('title', 'Peserta')
@section('header-title', 'Peserta')
@section('list-header')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Peserta</a></li>
    </ol>
@endsection

@section('content')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">

    <div class="card">
        <div class="card-body">
            <a href="/peserta/add" class="btn btn-primary">Tambah Peserta <i class="ri-add-line ml-2"></i></a>
        </div>
    </div>

    <div class="card">
        <div class="card-body table-responsive">
            <table id="tblPeserta" class="table table-bordered">
                <thead>
                    <tr>
                        <th class="border-y-none" width="5">#</th>
                        <th class="border-y-none">Nama Peserta</th>
                        <th class="border-y-none">Tipe</th>
                        <th class="border-y-none">Kelas</th>
                        <th class="border-y-none">QR Code</th>
                        <th class="text-center border-y-none">Status</th>
                        <th class="text-center border-y-none">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pesertas as $peserta)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $peserta->nama_peserta }}</td>
                            <td>
                                @if ($peserta->tipe == 1)
                                    Siswa
                                @endif
                                @if ($peserta->tipe == 2)
                                    Guru
                                @endif
                                @if ($peserta->tipe == 3)
                                    Karyawan
                                @endif
                            </td>
                            <td>
                                @if ($peserta->tingkatan == 1)
                                    X
                                @endif
                                @if ($peserta->tingkatan == 2)
                                    XI
                                @endif
                                @if ($peserta->tingkatan == 3)
                                    XII
                                @endif
                                {{ $peserta->nama_kelas }}
                            </td>
                            <td>{{ $peserta->qr_code }}</td>
                            <td class="text-center">
                                @if ($peserta->status == 1)
                                    <span class="badge badge-success p-2">Aktif</span>
                                @else
                                    <span class="badge badge-danger p-2">Nonaktif</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="/peserta/edit/{{ $peserta->id_peserta }}" class="badge badge-warning p-2">
                                    <i class="ri-pencil-line"></i>
                                </a>
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
        function showDataTable() {
            $("#tblPeserta").DataTable();
        }

        function destoryDataTable() {
            $("#tblPeserta").DataTable().clear().destroy();
            $("#tblPeserta").DataTable();
        }

        showDataTable();
    </script>
@endsection
