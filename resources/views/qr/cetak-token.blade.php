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
            font-size: 32px;
        }

        .info-wrapper {
            margin-bottom: 12px;
        }
    </style>
</head>

<body>
    <div class="container">
        <table width="100%">
            <tr>
                @php
                    $nomer = 1;
                @endphp
                @foreach ($tokens as $key => $value)
                    <td class="box">
                        <div class="text">
                            <?php
                            echo DNS2D::getBarcodeHTML($value, 'QRCODE', 10, 10);
                            ?>
                            <div class="text">
                                <h5>{{ $key }}</h5>
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

    <script>
        let html = ``
    </script>
</body>

</html>
