<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #4285f4;
            text-align: center;
        }

        p {
            margin-bottom: 20px;
            text-align: justify;
        }

        strong {
            color: #4285f4;
        }

    </style>
</head>

<body>
    <div class="container">
        <h1>Certificado de Conclusão</h1>
        <p>Olá, <strong>{{ $data['name'] }}</strong>,</p>
        <p>
            Seu desempenho exemplar e dedicação ao aprendizado são evidentes, refletindo-se em um aproveitamento
            excepcional durante todo o curso. Estamos confiantes de que as habilidades adquiridas serão valiosas em sua
            jornada profissional, e celebramos esta conquista notável.
        </p>
        <p>Parabéns, pelo seu comprometimento. Desejamos-lhe todo o sucesso em seus empreendimentos futuros.</p>
        <p>Segue em anexo seu certificado.</p>
    </div>
</body>

</html>
