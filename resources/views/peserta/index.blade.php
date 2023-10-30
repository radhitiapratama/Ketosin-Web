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
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

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
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#cetakQrCode">
                Cetak QR Code <i class="ri-printer-line"></i>
            </button>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 col-12">
                    <div class="form-group">
                        <label for="#">Tipe</label>
                        <select name="filterTipe" id="filterTipe" class="form-control">
                            <option value="">Pilih...</option>
                            @foreach ($tipeses as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3 col-12">
                    <div class="form-group">
                        <label for="#">Tingkatan</label>
                        <select name="filterTingkatan" id="filterTingkatan" class="form-control">
                            <option value="">Pilih...</option>
                            @foreach ($tingkatans as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3 col-12">
                    <div class="form-group">
                        <label for="#">Kelas</label>
                        <select name="filterKelas" id="filterKelas" class="form-control">
                            <option value="">Pilih...</option>
                            @foreach ($kelases as $kelas)
                                <option value="{{ $kelas->id_kelas }}">{{ $kelas->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3 col-12">
                    <div class="form-group">
                        <label for="#">Status</label>
                        <select name="filterStatus" id="filterStatus" class="form-control">
                            <option value="">Pilih...</option>
                            @foreach ($statuses as $key => $value)
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
            <table id="tblPeserta" class="table table-bordered" style="width: 100%">
                <thead>
                    <tr>
                        <th class="border-y-none" width="5">#</th>
                        <th class="border-y-none">Nama Peserta</th>
                        <th class="border-y-none">Tipe</th>
                        <th class="border-y-none">Kelas</th>
                        <th class="text-center border-y-none">Status</th>
                        <th class="text-center border-y-none">Action</th>
                    </tr>
                </thead>
                <tbody>
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
                                    <input type="file" name="file_excel" class="custom-file-input"
                                        id="exampleInputFile" accept=".xlsx">
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


    <!-- Modal Detail Barcode -->
    <div class="modal fade" id="modalQr" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detail QR Code</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="modal-qr-code"></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Cetak QR Code -->
    <div class="modal fade" id="cetakQrCode" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cetak QR Code</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/qr-code/cetak-qr" method="POST" class="mb-3" target="_blank">
                        @csrf
                        <div class="form-group">
                            <label for="#">Tipe</label>
                            <select name="tipe_cetak" id="tipe_cetak" class="form-control" required>
                                <option value="">Pilih Tipe...</option>
                                @foreach ($tipeses as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="qr-cetak-form-wrapper">

                        </div>

                        <div class="row">
                            <div class="col-12 d-flex justify-content-center gap-20">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary" id="btn-cetak-qr">Cetak</button>
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
    <script src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('plugins/qr-code/qrcode.min.js') }}"></script>

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

        @if (session()->has('successAdd'))
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                iconColor: "#FFF",
                title: 'Data Peserta berhasil di tambahkan',
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
                title: 'Data Peserta berhasil di update',
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
            theme: 'bootstrap4',
            width: "100%"
        }

        const csrf = $('meta[name="csrf-token"]').attr('content');

        const cetak_form_siswa = `
        <div class="row">
            <div class="col-md-6 col-12">
                <div class="form-group">
                    <label for="#">Tingkatan</label>
                    <select name="cetak_tingkatan" id="cetak_tingkatan" class="form-control" required>
                        <option value="">Pilih Tingkatan...</option>
                        @foreach ($tingkatans as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="form-group">
                    <label for="#">Kelas</label>
                    <select name="cetak_kelas" id="cetak_kelas" class="form-control" required>
                        <option value="">Pilih Kelas...</option>
                        @foreach ($kelases as $kelas)
                            <option value="{{ $kelas->id_kelas }}">{{ $kelas->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        `;

        bsCustomFileInput.init();

        function showDataTable() {
            $("#tblPeserta").DataTable({
                serverSide: true,
                processing: true,
                searchDelay: 1500,
                ordering: false,
                ajax: {
                    url: "{{ url('peserta') }}",
                    data: function(data) {
                        data.tipe = $("#filterTipe").val();
                        data.tingkatan = $("#filterTingkatan").val();
                        data.kelas = $("#filterKelas").val();
                        data.status = $("#filterStatus").val();
                    }
                },
                drawCallback: function(res) {
                    console.log(res.json);
                },
                columns: [{
                        data: "no"
                    },
                    {
                        data: "nama_peserta"
                    },
                    {
                        data: "tipe"
                    },
                    {
                        data: "kelas"
                    },
                    {
                        data: "status"
                    },
                    {
                        data: "action"
                    },
                ],
            });
        }

        function destoryDataTable() {
            $("#tblPeserta").DataTable().clear().destroy();
        }

        function show_error_validation_input() {
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                iconColor: "#FFF",
                title: 'Gagal ! Semua input wajib di isi',
                showConfirmButton: false,
                customClass: {
                    popup: 'colored-toast'
                },
                timer: 3000,
                toast: true
            });
        }

        function close_error_validation_input() {
            Swal.close();
        }

        function show_loading_loader() {
            Swal.fire({
                icon: 'info',
                title: 'Loading...',
            })
        }

        function hide_loading_loader() {
            Swal.close();
        }


        showDataTable();

        $("#filterTipe").select2(configSelect2);
        $("#filterTingkatan").select2(configSelect2);
        $("#filterKelas").select2(configSelect2);
        $("#filterStatus").select2(configSelect2);
        $("#tipe_cetak").select2(configSelect2);


        $("#filterTipe").change(function() {
            destoryDataTable();
            showDataTable();
        });

        $("#filterTingkatan").change(function() {
            destoryDataTable();
            showDataTable();
        })

        $("#filterKelas").change(function() {
            destoryDataTable();
            showDataTable();
        });

        $("#filterStatus").change(function() {
            destoryDataTable();
            showDataTable();
        })

        $(document).on("click", ".btn-detail-qr", function() {
            let qrValue = $(this).data("qr-value");
            console.log(qrValue);
            $(".modal-qr-code").html(``);
            const qrEl = new QRCode(document.querySelector("#modalQr .modal-qr-code"), qrValue);
            $(".modal-qr-value").html(qrEl);
        });

        $("#tipe_cetak").change(function() {
            const tipe = $(this).val();

            if (tipe == 1) {
                $(".qr-cetak-form-wrapper").html(cetak_form_siswa);
                $("#cetak_tingkatan").select2(configSelect2);
                $("#cetak_kelas").select2(configSelect2);
                return;
            }

            if (tipe == 2) {
                $(".qr-cetak-form-wrapper").html("");
                return;
            }

            if (tipe == 3) {
                $(".qr-cetak-form-wrapper").html("");
                return;
            }

        });
    </script>
@endsection
