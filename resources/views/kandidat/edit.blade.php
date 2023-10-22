@extends('layouts.main')
@section('title', 'Edit Kandidat')
@section('header-title', 'Edit Kandidat')

@section('list-header')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">Kandidat</li>
        <li class="breadcrumb-item"><a href="#">Edit Kandidat</a></li>
    </ol>
@endsection

@section('content')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

    <div class="card">
        <div class="card-body d-flex justify-content-end">
            <a href="/kandidat" class="btn btn-primary">
                <i class="ri-arrow-left-line"></i>
                Kembali
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="/kandidat/update" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id_kandidat" value="{{ $kandidat->id_kandidat }}">
                <input type="hidden" name="old_foto" value="{{ $kandidat->foto }}">
                <div class="row">
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="#">Ketua</label>
                            <select name="ketua" id="ketua" class="form-control">
                                <option value="{{ $kandidat->id_ketua }}" selected>{{ $kandidat->nama_ketua }}</option>
                                <option value="{{ $kandidat->id_wakil }}">{{ $kandidat->nama_wakil }}</option>
                                @foreach ($pesertas as $peserta)
                                    <option value="{{ $peserta->id_peserta }}">{{ $peserta->nama_peserta }}</option>
                                @endforeach
                            </select>
                            @error('ketua')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="#">Wakil</label>
                            <select name="wakil" id="wakil" class="form-control">
                                <option value="{{ $kandidat->id_ketua }}">{{ $kandidat->nama_ketua }}</option>
                                <option value="{{ $kandidat->id_wakil }}" selected>{{ $kandidat->nama_wakil }}</option>
                                @foreach ($pesertas as $peserta)
                                    <option value="{{ $peserta->id_peserta }}">{{ $peserta->nama_peserta }}</option>
                                @endforeach
                            </select>
                            @error('wakil')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="exampleInputFile">File input</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="exampleInputFile"
                                        accept=".png,.jpg,.jpeg" name="foto">
                                    <label class="custom-file-label" for="exampleInputFile">Pilih Foto</label>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text">Upload</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <small class="text-info">Ukuran Foto Max 2MB</small>
                                </div>
                                <div class="col-12">
                                    @error('foto')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="#">Slogan</label>
                            <input type="text" class="form-control" name="slogan"
                                value="{{ old('slogan', $kandidat->slogan) }}">
                            @error('slogan')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label>Visi</label>
                            <textarea class="form-control" name="visi" rows="5" placeholder="Tuliskan Visi...">{{ old('visi', $kandidat->visi) }}</textarea>
                            @error('visi')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label>Misi</label>
                            <textarea class="form-control" name="misi" rows="5" placeholder="Tuliskan Misi...">{{ old('misi', $kandidat->misi) }}</textarea>
                            @error('misi')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>


    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>

    <script>
        bsCustomFileInput.init();

        const configSelect2 = {
            theme: 'bootstrap4',
            width: "100%"
        }

        $("#ketua").select2(configSelect2);
        $("#wakil").select2(configSelect2);
    </script>
@endsection
