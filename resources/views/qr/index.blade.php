@extends('layouts.main')
@section('title', 'Qr Code')
@section('header-title', 'Qr Code')
@section('list-header')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Qr Code</a></li>
    </ol>
@endsection

@section('content')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2/sweetalert2.min.css') }}">

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12 d-flex gap-20">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addQrCode">
                        Tambah QR Code <i class="ri-add-line ml-2"></i>
                    </button>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#cetakQrCode">
                        Cetak QR Code <i class="ri-printer-line"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal Tambah QR Code -->
    <div class="modal fade" id="addQrCode" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah QR Code</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="mb-3">
                        <div class="form-group">
                            <label for="#">Tipe</label>
                            <select name="tipe" id="tipe" class="form-control">
                                <option value="">Pilih Tipe...</option>
                                @foreach ($tipeses as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="qr-form-wrapper">

                        </div>

                    </form>
                    <div class="row">
                        <div class="col-12 d-flex justify-content-center gap-20">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="button" class="btn btn-primary" id="btn-add-qr">Submit</button>
                        </div>
                    </div>
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
                    <form action="/qr-code/cetak-qr" method="POST" class="mb-3">
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
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>

    <script>
        const configSelect = {
            theme: "bootstrap4",
            width: "100%",
        }

        const csrf = $('meta[name="csrf-token"]').attr('content');

        const form_siswa = `
        <div class="row">
            <div class="col-md-6 col-12">
                <div class="form-group">
                    <label for="#">Tingkatan</label>
                    <select name="tingkatan" id="tingkatan" class="form-control">
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
                    <select name="kelas" id="kelas" class="form-control">
                        <option value="">Pilih Kelas...</option>
                        @foreach ($kelases as $kelas)
                            <option value="{{ $kelas->id_kelas }}">{{ $kelas->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        `;

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

        function show_success_add() {
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                iconColor: "#FFF",
                title: 'QR Code berhasil di tambahkan',
                showConfirmButton: false,
                customClass: {
                    popup: 'colored-toast'
                },
                timer: 3000,
                toast: true
            });
        }

        $("#tipe").select2(configSelect);
        $("#tipe_cetak").select2(configSelect);

        $("#tipe").change(function() {
            let id = $(this).val();

            if (id == 1) {
                $(".qr-form-wrapper").html(form_siswa);
                $("#tingkatan").select2(configSelect);
                $("#kelas").select2(configSelect);

                return;
            }

            if (id == 2) {
                $(".qr-form-wrapper").html("");
                return;
            }

            if (id == 3) {
                $(".qr-form-wrapper").html("");
                return;
            }
        });

        $("#tipe_cetak").change(function() {
            const tipe = $(this).val();

            if (tipe == 1) {
                $(".qr-cetak-form-wrapper").html(cetak_form_siswa);
                $("#cetak_tingkatan").select2(configSelect);
                $("#cetak_kelas").select2(configSelect);
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


        $("#btn-add-qr").click(function() {
            let tipe = $("#tipe").val();
            console.log(tipe);

            if (tipe == null || tipe == "") {
                show_error_validation_input();
                return;
            }

            if (tipe == 1) {
                const tingkatan = $("#tingkatan").val();
                const kelas = $("#kelas").val();

                if (tingkatan == "" || kelas == "") {
                    show_error_validation_input();
                    return;
                }

                show_loading_loader();

                $.ajax({
                    type: "POST",
                    url: "{{ url('qr-code/store') }}",
                    headers: {
                        'X-CSRF-TOKEN': csrf
                    },
                    data: {
                        tipe: tipe,
                        tingkatan: tingkatan,
                        kelas: kelas,
                    },
                    dataType: "json",
                    success: function(response) {
                        console.log(response);
                        hide_loading_loader();
                        show_success_add();
                        $("#addQrCode").modal("hide");
                    }
                });

                return;
            }

            if (tipe == 2) {
                show_loading_loader();

                $.ajax({
                    type: "POST",
                    url: "{{ url('qr-code/store') }}",
                    headers: {
                        'X-CSRF-TOKEN': csrf
                    },
                    data: {
                        tipe: tipe,
                    },
                    dataType: "json",
                    success: function(response) {
                        console.log(response);
                        hide_loading_loader();
                        show_success_add();
                        $("#addQrCode").modal("hide");
                    }
                });

                return;
            }

            if (tipe == 3) {
                show_loading_loader();

                $.ajax({
                    type: "POST",
                    url: "{{ url('qr-code/store') }}",
                    headers: {
                        'X-CSRF-TOKEN': csrf
                    },
                    data: {
                        tipe: tipe,
                    },
                    dataType: "json",
                    success: function(response) {
                        console.log(response);
                        hide_loading_loader();
                        show_success_add();
                        $("#addQrCode").modal("hide");
                    }
                });
                return;
            }

        });
    </script>
@endsection
