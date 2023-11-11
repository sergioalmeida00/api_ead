<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- <link rel="stylesheet" href="{{ asset('/css/style-certificate.css') }}"> --}}
    <link rel="stylesheet" href="{{ public_path('/css/style-certificate.css') }}">

    <title>Document</title>
    <style>

    </style>
</head>

<body>

</body>
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
                <span>Completou com sucesso a trilha de Node.JS no Ignite, tendo
                    conhecimento em API, Banco de Dados, AWS, Serverless, com
                    aproveitamento CURSO
                </span>
            </div>
        </div>
        <div class="right">
            <div class="medal">
                {{-- <img src="{{ asset('img/selo.png') }}" alt="" /> --}}
                {{-- <img src="{{ public_path('public/img/selo.png') }}" alt="Selo de Certificação" /> --}}

                <img src="{{storage_path('public/img/selo.png')}}">

                {{-- <img src="{{ public_path('/css/style-certificate.css') }}" alt="" /> --}}

            </div>
            <div class="date">
                <strong>Data de emissão:</strong> {{ now() }}
                <br />
            </div>
            <div class="uuid">
                <span> ID </span>
            </div>
        </div>
    </div>
</div>

</html>
