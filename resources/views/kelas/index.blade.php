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
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">


    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12 d-flex gap-20">
                    <a href="/kelas/add" class="btn btn-primary">
                        Tambah Kelas <i class="ri-add-line ml-2"></i></a>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#imporKelas">
                        Import Kelas <i class="ri-file-excel-2-line"></i>
                    </button>
                    <a href="{{ asset('excel/importKelas.xlsx') }}" class="btn btn-primary" download>
                        Download Template
                        <i class="ri-download-line"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
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

    <!-- Modal -->
    <div class="modal fade" id="imporKelas" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Import Kelas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/kelas/import" method="POST" enctype="multipart/form-data">
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
    <script src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>

    <script>
        @if (session()->has('success_import'))
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                iconColor: "#FFF",
                title: 'Data kelas berhasil di import',
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

        function showDatatable() {
            $("#tblKelas").DataTable({
                columnDefs: [{
                    targets: [0, 3],
                    orderable: false,
                }]
            });
        }

        showDatatable();

        $("#filterStatus").select2(configSelect2);

        $("#filterStatus").change(function() {
            let value = $(this).val();

            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': csrf,
                },
                url: "{{ url('kelas') }}",
                data: {
                    status: value,
                },
                dataType: "json",
                success: function(response) {
                    console.log(response);

                    let kelas = response.kelases;
                    let html = ``;
                    let no = 1;

                    for (let i = 0; i < kelas.length; i++) {
                        let status = ``;

                        if (kelas[i].status == 1) {
                            status = `<span class="badge badge-success p-2">Aktif</span>`;
                        }

                        if (kelas[i].status == 0) {
                            status = `<span class="badge badge-danger p-2">Nonaktif</span>`;
                        }

                        html += `
                        <tr>
                            <td>${no}</td>
                            <td>${kelas[i].nama_kelas}</td>
                            <td class="text-center">
                              ${status}
                            </td>
                            <td class="text-center">
                                <a href="kelas/edit/${kelas[i].id_kelas}" class="badge badge-warning p-2"><i
                                        class="ri-pencil-line"></i></a>
                            </td>
                        </tr>
                        `;
                        no++;
                    }

                    $("#tblKelas tbody").html(html);
                }
            });
        });
    </script>
@endsection
