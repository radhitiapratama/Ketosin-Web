@extends('layouts.main')
@section('title', 'Token TPS')
@section('header-title', 'Token TPS')
@section('list-header')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Token TPS</a></li>
    </ol>
@endsection

@section('content')
    <style>
        .card-title {
            font-size: 24px;
        }
    </style>
    <div class="row">
        @foreach ($tokens as $key => $value)
            <div class="col-md-4 col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">{{ $key }}</h5>
                    </div>
                    <div class="card-body">
                        <?php echo DNS2D::getBarcodeHTML($value, 'QRCODE', 8, 8); ?>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
