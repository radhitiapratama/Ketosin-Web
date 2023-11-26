@extends('layouts.main')
@section('title', 'Waktu')
@section('header-title', 'Waktu')
@section('list-header')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Waktu</a></li>
    </ol>
@endsection

@section('content')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2/sweetalert2.min.css') }}">

    <div class="card">
        <div class="card-body">
            <a href="/batas-waktu/add" class="btn btn-primary">
                Tambah Batas Waktu <i class="ml-2 ri-add-line"></i>
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body table-responsive">
            <table id="tblWaktu" class="table table-bordered">
                <thead>
                    <tr>
                        <th class="border-y-none" width="5">#</th>
                        <th class="border-y-none">Waktu Mulai</th>
                        <th class="border-y-none"> Waktu Selesai</th>
                        <th class="text-center border-y-none">Status</th>
                        <th class="text-center border-y-none">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($waktus as $waktu)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ date('d-m-Y H:i:s', strtotime($waktu->start)) }}</td>
                            <td>{{ date('d-m-Y H:i:s', strtotime($waktu->finish)) }}</td>
                            <td class="text-center">
                                @if ($waktu->status == 1)
                                    <span class="badge badge-success p-2">Aktif</span>
                                @else
                                    <span class="badge badge-danger p-2">Nonaktif</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="/batas-waktu/edit/{{ $waktu->id_waktu }}" class="badge badge-warning p-2">
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
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>

    <script>
        @if (session()->has('successAdd'))
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                iconColor: "#FFF",
                title: 'Batas waktu berhasil di tambahkan',
                showConfirmButton: false,
                customClass: {
                    popup: 'colored-toast'
                },
                timer: 3000,
                toast: true
            });
        @endif

        @if (session()->has('successUpdate'))
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                iconColor: "#FFF",
                title: 'Batas waktu berhasil di update',
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
        function showDatatable() {
            $("#tblWaktu").DataTable();
        }

        showDatatable();
    </script>
@endsection
