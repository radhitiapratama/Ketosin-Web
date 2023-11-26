@extends('layouts.main')
@section('title', 'Vote')
@section('header-title', 'Vote')
@section('list-header')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Vote</a></li>
    </ol>
@endsection

@section('content')
    <style>
        input[type=radio] {
            transform: scale(1.5);
            accent-color: #8FBD56;
            box-shadow: none;
        }

        .detail-kandidat {
            border: none;
            background: transparent;
            text-decoration: none;
            position: relative;
            padding: 0;
        }

        .detail-kandidat::after {
            content: "";
            position: absolute;
            width: 100%;
            height: 2px;
            background: #8FBD56;
            right: 0;
            bottom: -4px;
        }

        .text-no-kandidat {
            padding: 0;
            margin: 0;
            font-size: 18px;
        }
    </style>

    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2/sweetalert2.min.css') }}">

    <div class="row mb-3">
        <div class="col-12 d-flex justify-content-end">
            <a href="/peserta" class="btn btn-primary">
                <i class="ri-arrow-left-line"></i>
                Kembali
            </a>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            @if (count($kandidats) > 0)
                <form action="/peserta/doVote" method="post">
                    @csrf
                    <input type="hidden" name="id_peserta" value="{{ $id_peserta }}">
                    <div class="row mb-3">
                        <div class="col-12 d-flex justify-content-center flex-wrap gap-20">
                            @foreach ($kandidats as $kandidat)
                                <div class="card" style="width: 18rem; overflow: hidden;">
                                    <div>
                                        @if ($kandidat->foto)
                                            <img src="{{ asset('uploads/' . $kandidat->foto) }}" class="card-img-top"
                                                alt="..." style="width: 100%;height: 100%; object-fit: cover">
                                        @else
                                            <img src="{{ asset('main-assets/imgs/default.jpg') }}" class="card-img-top"
                                                alt="..." style="width: 100%;height: 100%; object-fit: cover">
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <div class="col-12 d-flex justify-content-between gap-20">
                                                @if ($isKandidat == 1 || $status_vote == 1)
                                                    <input type="radio" name="id_kandidat"
                                                        value="{{ $kandidat->id_kandidat }}" id="id_kandidat" disabled
                                                        required>
                                                @else
                                                    <input type="radio" name="id_kandidat"
                                                        value="{{ $kandidat->id_kandidat }}" id="id_kandidat" required>
                                                @endif
                                                <div class="d-flex" style="gap: 20px">
                                                    <button type="button" class="btn-detail-kandidat detail-kandidat"
                                                        data-toggle="modal" data-id-kandidat="{{ $kandidat->id_kandidat }}"
                                                        data-target="#detailKandidat">
                                                        Detail Kandidat
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <p style="margin: 0;">Ketua</p>
                                        <p class="text-gray">{{ $kandidat->nama_ketua }}</p>
                                        <p style="margin: 0">Wakil</p>
                                        <p class="text-gray">{{ $kandidat->nama_wakil }}</p>
                                        <p class="text-gray">" {{ $kandidat->slogan }} "</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    @if ($isKandidat == 1 || $status_vote == 1)
                        <button type="button" class="btn btn-primary m-auto pointer-none" disabled>Vote</button>
                    @else
                        <button type="submit" class="btn btn-primary m-auto">Vote</button>
                    @endif
                </form>
            @else
                <p class="text-no-kandidat text-danger">Kandidat belum ada</p>
            @endif

        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="detailKandidat" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card card-primary card-tabs">
                        <div class="card-header p-0 pt-1">
                            <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill"
                                        href="#tab-slogan" role="tab" aria-controls="custom-tabs-one-home"
                                        aria-selected="true">Slogan</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#tab-visi"
                                        role="tab" aria-controls="custom-tabs-one-profile"
                                        aria-selected="false">Visi</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-one-messages-tab" data-toggle="pill"
                                        href="#tab-misi" role="tab" aria-controls="custom-tabs-one-messages"
                                        aria-selected="false">Misi</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-one-tabContent">
                                <div class="tab-pane fade active show" id="tab-slogan" role="tabpanel"
                                    aria-labelledby="custom-tabs-one-home-tab">
                                    <div class="tab-slogan-wrapper"></div>
                                </div>
                                <div class="tab-pane fade" id="tab-visi" role="tabpanel"
                                    aria-labelledby="custom-tabs-one-profile-tab">
                                    <div class="tab-visi-wrapper"></div>
                                </div>
                                <div class="tab-pane fade" id="tab-misi" role="tabpanel"
                                    aria-labelledby="custom-tabs-one-messages-tab">
                                    <div class="tab-misi-wrapper"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 d-flex justify-content-center">
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>

    <script>
        @if (session()->has('isKandidat'))
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                iconColor: "#FFF",
                title: 'Kandidat tidak boleh memvote !',
                showConfirmButton: false,
                customClass: {
                    popup: 'colored-toast'
                },
                timer: 3000,
                toast: true
            });
        @endif

        @if (session()->has('pesertaInvalid'))
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                iconColor: "#FFF",
                title: 'Data peserta invalid !',
                showConfirmButton: false,
                customClass: {
                    popup: 'colored-toast'
                },
                timer: 3000,
                toast: true
            });
        @endif

        @if (session()->has('batasWaktuNotFound'))
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                iconColor: "#FFF",
                title: 'Waktu Pemilihan Belum Ditentukan',
                showConfirmButton: false,
                customClass: {
                    popup: 'colored-toast'
                },
                timer: 3000,
                toast: true
            });
        @endif
        @if (session()->has('belumDiMulai'))
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                iconColor: "#FFF",
                title: 'Pemilihan Belum Dimulai',
                showConfirmButton: false,
                customClass: {
                    popup: 'colored-toast'
                },
                timer: 3000,
                toast: true
            });
        @endif
        @if (session()->has('sudahSelesai'))
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                iconColor: "#FFF",
                title: 'Pemilihan Telah Berakhir',
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
        const csrf = $('meta[name="csrf-token"]').attr('content');

        $(document).on("click", ".btn-detail-kandidat", function() {
            let id_kandidat = $(this).data("id-kandidat");
            console.log(id_kandidat);
            $.ajax({
                type: "POST",
                url: "{{ url('kandidat/detail') }}",
                headers: {
                    "X-CSRF-TOKEN": csrf,
                },
                data: {
                    id_kandidat: id_kandidat,
                },
                dataType: "json",
                success: function(response) {
                    console.log(response);
                    let misi = '';

                    $(".tab-misi-wrapper").html("");

                    for (let i = 0; i < response.misi.length; i++) {
                        $(".tab-misi-wrapper").append(`<p>${response.misi[i]}</p>`);
                    }

                    $(".tab-slogan-wrapper").html(response.slogan);
                    $(".tab-visi-wrapper").html(response.visi);
                }
            });
        });
    </script>

@endsection
