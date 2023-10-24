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
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2/sweetalert2.min.css') }}">

    <div class="card">
        <div class="card-body d-flex flex-wrap gap-20">
            <a href="/peserta/add" class="btn btn-primary">Tambah Peserta <i class="ri-add-line ml-2"></i></a>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#importPeserta">
                Import Peserta <i class="ri-file-excel-2-line"></i>
            </button>
            <a href="/excel/importPeserta.xlsx" class="btn btn-primary" download>
                Download Template
                <i class="ri-download-line"></i>
            </a>
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
                            <td>
                                @if ($peserta->qr_code)
                                    {{ $peserta->qr_code }}
                                @else
                                    -
                                @endif
                            </td>
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

    <!-- Modal -->
    <div class="modal fade" id="importPeserta" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Import Peserta</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/peserta/import" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputFile">File Excel</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" name="file_excel" class="custom-file-input" id="exampleInputFile"
                                        accept=".xlsx">
                                    <label class="custom-file-label" for="exampleInputFile">Pilih File</label>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text">Upload</span>
                                </div>
                            </div>
                            <small class="text-danger">
                                Extensi file wajib .xlsx
                            </small>
                        </div>
                        <div class="row">
                            <div class="col-12 d-flex justify-content-center gap-20">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Import</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>

    <script>
        @if (session()->has('success_import'))
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                iconColor: "#FFF",
                title: 'Data Peserta berhasil di import',
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
        bsCustomFileInput.init();

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
