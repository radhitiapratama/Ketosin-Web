@extends('layouts.main')
@section('title', 'Kelas')
@section('header-title', 'Kelas')
@section('list-header')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Kelas</a></li>
    </ol>
@endsection

@section('content')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12 d-flex">
                    <a href="/kelas/add" class="btn btn-primary">
                        Tambah Kelas <i class="ri-add-line ml-2"></i></a>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table id="tblKelas" class="table table-bordered">
                <thead>
                    <tr>
                        <th class="text-center border-y-none" width="5">#</th>
                        <th class="border-y-none">Nama Kelas</th>
                        <th class="text-center border-y-none">Status</th>
                        <th class="text-center border-y-none" width="5">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kelases as $kelas)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $kelas->nama_kelas }}</td>
                            <td class="text-center">
                                @if ($kelas->status == 1)
                                    <span class="badge badge-success p-2">Aktif</span>
                                @else
                                    <span class="badge badge-danger p-2">Nonaktif</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="kelas/edit/{{ $kelas->id_kelas }}" class="badge badge-warning p-2"><i
                                        class="ri-pencil-line"></i></a>
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
            $("#tblKelas").DataTable({
                ordering: false,
            });
        }

        showDatatable();
    </script>
@endsection
