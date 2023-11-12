<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    {{-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> --}}
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    {{-- <meta http-equiv="X-UA-Compatible" content="ie=edge"> --}}
    {{-- <link rel="stylesheet" href="{{ asset('/css/style-certificate.css') }}"> --}}
    {{-- <link rel="stylesheet" href="{{ public_path('/css/style-certificate.css') }}"> --}}
    {{-- .content {
        width: 1400px;
        height: 761px;
        background: #000;
        padding: 1rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    } --}}
    <title>Document</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            -webkit-print-color-adjust: exact;
        }

        body {
            font-family: "Roboto", sans-serif;
        }

        .content {
            width: 100%;
            height: 761px;
            background: #000;
            padding: 1rem;
        }

        .label {
            margin-top: 60px;
            color: #04d361;
            /* margin-left: 100px; */
            text-align: center;
            font-size: 60px;
            font-weight: bold;
        }

        /* .name {
            font-size: 28px;
            color: #fff;
            margin-left: 100px;
            margin-top: 30px;
        } */

        .medal {
            /* padding: 50px; */
            margin-top: 150px;
            text-align: center;
        }

        .medal img {
            width: 260px;
        }

        .title {
            color: #fff;
            height: 100px;
            margin-left: 100px;
            font-size: 50px;
        }

        .complete_text {
            color: #fff;
            font-size: 20px;
            margin-left: 150px;
            text-align: center;
            margin-top: 20px;
            max-width: 800px;
            /* text-align: left; */
            line-height: 25px;
        }

        .date {
            color: #04d361;
            /* margin-left: 44px; */
            font-size: 23px;
            text-align: center;
        }

        .uuid {
            padding-left: 0px;
            color: #fff;
            font-size: 19px;
            text-align: center;
            margin-top: 20px;
        }

        /* .right {
            margin-right: 20px;
        } */
    </style>
</head>

<body>
    <div class="certificate">

        <div class="content">
            <div class="left">
                <div class="title">
                    <br />
                    <span> {{ $data['name'] }} </span>
                </div>
                <div class="label">
                    <label class="">Certificado</label>
                </div>

                <div class="name">
                    <label for=""> {{ $data['user_name'] }} </label>
                </div>

                <div class="complete_text">
                    <span>Certificamos que <strong>{{ $data['user_name'] }}</strong> completou com sucesso a trilha de Node.JS no Ignite, tendo
                        conhecimento em API, Banco de Dados, AWS, Serverless, com
                        aproveitamento CURSO
                    </span>
                </div>
            </div>
            <div class="right">
                <div class="medal">
                    <img src="{{ public_path('/img/assinatura.png') }}" alt="" />
                </div>
                <div class="date">
                    <strong>Data de emissão:</strong> {{ now() }}
                    <br />
                </div>
                <div class="uuid">
                    <span> ID </span>
                    <strong>8f1fa56c-80dd-11ee-b962-0242ac120002</strong>
                </div>
            </div>
        </div>
    </div>
</body>


</html>
