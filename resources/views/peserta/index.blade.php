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
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 col-12">
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
                <div class="col-md-3 col-12">
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
                <div class="col-md-3 col-12">
                    <div class="form-group">
                        <label for="#">Kelas</label>
                        <select name="filterKelas" id="filterKelas" class="form-control">
                            <option value="">Pilih Kelas...</option>
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
                            <option value="">Pilih Status...</option>
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
            <table id="tblPeserta" class="table table-bordered">
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
                            <td class="text-center">
                                @if ($peserta->status == 1)
                                    <span class="badge badge-success p-2">Aktif</span>
                                @else
                                    <span class="badge badge-danger p-2">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex justify-content-center gap-20">
                                    <button type="button" class="badge badge-primary p-2 btn-detail-qr"
                                        data-qr-value="{{ $peserta->qr_code }}" data-toggle="modal" data-target="#modalQr">
                                        <i class="ri-qr-code-line"></i>
                                    </button>
                                    <a href="/peserta/edit/{{ $peserta->id_peserta }}" class="badge badge-warning p-2">
                                        <i class="ri-pencil-line"></i>
                                    </a>
                                </div>
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
    </script>

    <script>
        const configSelect2 = {
            theme: 'bootstrap4',
            width: "100%"
        }

        const csrf = $('meta[name="csrf-token"]').attr('content');

        bsCustomFileInput.init();

        function showDataTable() {
            $("#tblPeserta").DataTable({
                columnDefs: [{
                    targets: [2, 4, 5],
                    orderable: false,
                }]
            });
        }

        function destoryDataTable() {
            $("#tblPeserta").DataTable().clear().destroy();
        }

        showDataTable();

        $("#filterTipe").select2(configSelect2);
        $("#filterTingkatan").select2(configSelect2);
        $("#filterKelas").select2(configSelect2);
        $("#filterStatus").select2(configSelect2);

        $("#filterTipe").change(function() {
            filterTable();
        });

        $("#filterTingkatan").change(function() {
            filterTable();
        })

        $("#filterKelas").change(function() {
            filterTable();
        });

        $("#filterStatus").change(function() {
            filterTable();
        })

        $(".btn-detail-qr").click(function() {
            let qrValue = $(this).data("qr-value");
            console.log(qrValue);
            $(".modal-qr-code").html(``);
            const qrEl = new QRCode(document.querySelector("#modalQr .modal-qr-code"), qrValue);
            $(".modal-qr-value").html(qrEl);
        });


        function filterTable() {
            let filterTipe = $("#filterTipe").val();
            let filterTingkatan = $("#filterTingkatan").val();
            let filterKelas = $("#filterKelas").val();
            let filterStatus = $("#filterStatus").val();

            destoryDataTable();

            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': csrf
                },
                url: "{{ url('peserta') }}",
                data: {
                    tipe: filterTipe,
                    tingkatan: filterTingkatan,
                    kelas: filterKelas,
                    status: filterStatus,
                },
                dataType: "json",
                success: function(response) {
                    console.log(response);

                    const peserta = response.pesertas;
                    let html = ``;
                    let num = 1;

                    for (let i = 0; i < peserta.length; i++) {
                        const tipe = checkTipe(peserta[i].tipe)
                        const tingkatan = checkTingkatan(peserta[i].tingkatan);
                        const status = checkStatus(peserta[i].status);

                        html += `
                        <tr>
                            <td>${num}</td>
                            <td>${peserta[i].nama_peserta}</td>
                            <td>
                               ${tipe} 
                            </td>
                            <td>
                               ${tingkatan} ${peserta[i].nama_kelas}
                            </td>
                            <td class="text-center">
                               ${status}
                            </td>
                            <td class="text-center">
                                <a href="/peserta/edit/${peserta[i].id_peserta}" class="badge badge-warning p-2">
                                    <i class="ri-pencil-line"></i>
                                </a>
                            </td>
                        </tr>
                        `;
                        num++;
                    }

                    $("#tblPeserta tbody").html(html);

                    showDataTable();
                }
            });
        }

        function checkTipe(tipe) {
            if (tipe == 1) {
                return "Siswa";
            }

            if (tipe == 2) {
                return "Guru";
            }

            if (tipe == 3) {
                return "Karyawan";
            }
        }

        function checkTingkatan(tingkatan) {
            if (tingkatan == 1) {
                return "X";
            }

            if (tingkatan == 2) {
                return "XI";
            }

            if (tingkatan == 3) {
                return "XII";
            }
        }

        function checkStatus(status) {
            if (status == 1) {
                return `<span class="badge badge-success p-2">Aktif</span>`;
            } else {
                return `<span class="badge badge-danger p-2">Nonaktif</span>`;
            }
        }
    </script>
@endsection
