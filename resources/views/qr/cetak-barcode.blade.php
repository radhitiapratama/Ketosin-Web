<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{ asset('main-assets/imgs/logo.png') }}" type="image/x-icon">
    <title>Ketosin | Cetak Barcode</title>
    <style>
        * {
            margin: 0;
        }

        body {
            padding: 15px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .box {
            border: 1px solid grey;
            padding: 10px;
            font-size: 10px;
            border-radius: 5px;
        }

        .text {
            margin-top: 5px;
        }

        h5 {
            padding: 0;
            margin: 0;
        }

        .info-wrapper {
            margin-bottom: 12px;
        }
    </style>
</head>

<body>
    <div class="info-wrapper">
        <p>Tipe :
            @if ($tipe == 1)
                Siswa
            @endif
            @if ($tipe == 2)
                Guru
            @endif
            @if ($tipe == 3)
                Karyawan
            @endif
        </p>
        @if ($tipe == 1)
            <p>Kelas : {{ $tingkatan }} {{ $kelas }}</p>
        @endif
    </div>

    @php
        $nomer = 1;
    @endphp
    <div class="container">
        <table width="100%">
            <tr>
                @foreach ($pesertas as $row)
                    <td class="box">
                        <div class="text">
                            <?php
                            echo DNS2D::getBarcodeHTML($row->qr_code, 'QRCODE', 3, 3);
                            ?>
                            <div class="text">
                                <h5>{{ $row->nama_peserta }}</h5>
                            </div>
                        </div>
                    </td>

                    @if ($nomer++ % 5 == 0)
            </tr>
            <tr>
                @endif
                @endforeach
            </tr>
        </table>
    </div>
</body>

</html>
