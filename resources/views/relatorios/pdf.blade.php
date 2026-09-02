<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">

    <title>Relatório de Atendimentos</title>

    <style>

        @page {
            margin: 30px 35px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #334155;
        }

        h1 {
            margin: 0;
            font-size: 22px;
            color: #1e293b;
        }

        h2 {
            margin-top: 25px;
            margin-bottom: 10px;
            font-size: 15px;
            color: #1e293b;
        }

        p {
            margin: 4px 0;
        }

        .cabecalho {
            border-bottom: 2px solid #4f46e5;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .periodo {
            color: #64748b;
            margin-top: 5px;
        }

        .resumo {
            width: 100%;
            margin-bottom: 20px;
        }

        .card {
            width: 23%;
            display: inline-block;
            vertical-align: top;
            margin-right: 1%;
            padding: 12px;
            box-sizing: border-box;
            border: 1px solid #e2e8f0;
            background: #f8fafc;
        }

        .card:last-child {
            margin-right: 0;
        }

        .card-titulo {
            font-size: 9px;
            color: #64748b;
            text-transform: uppercase;
        }

        .card-valor {
            font-size: 20px;
            font-weight: bold;
            color: #1e293b;
            margin-top: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }

        th {
            background: #f1f5f9;
            color: #334155;
            font-weight: bold;
            text-align: left;
        }

        th,
        td {
            padding: 8px;
            border-bottom: 1px solid #e2e8f0;
        }

        .text-right {
            text-align: right;
        }

        .barra-container {
            width: 100%;
            background: #e2e8f0;
            height: 10px;
        }

        .barra {
            background: #4f46e5;
            height: 10px;
        }

        .rodape {
            position: fixed;
            bottom: -15px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 8px;
            color: #94a3b8;
        }

        .quebra-pagina {
            page-break-before: always;
        }

    </style>
</head>

<body>

    {{-- CABEÇALHO --}}
    <div class="cabecalho">

        <h1>Relatório de Atendimentos</h1>

        <p class="periodo">
            Período:
            {{ $dataInicio->format('d/m/Y') }}
            até
            {{ $dataFim->format('d/m/Y') }}
        </p>

        <p class="periodo">
            Gerado em {{ now()->format('d/m/Y H:i') }}
        </p>

    </div>


    {{-- RESUMO --}}
    <div class="resumo">

        <div class="card">
            <div class="card-titulo">
                Total de atendimentos
            </div>

            <div class="card-valor">
                {{ $resumo['total'] }}
            </div>
        </div>


        <div class="card">
            <div class="card-titulo">
                Pacientes atendidos
            </div>

            <div class="card-valor">
                {{ $resumo['pacientes'] }}
            </div>
        </div>


        <div class="card">
            <div class="card-titulo">
                Tipos utilizados
            </div>

            <div class="card-valor">
                {{ $resumo['tipos'] }}
            </div>
        </div>


        <div class="card">
            <div class="card-titulo">
                Usuários
            </div>

            <div class="card-valor">
                {{ $resumo['usuarios'] }}
            </div>
        </div>

    </div>


    {{-- ATENDIMENTOS POR TIPO --}}
    <h2>Atendimentos por tipo</h2>

    <table>

        <thead>
            <tr>
                <th>Tipo de atendimento</th>
                <th class="text-right">Quantidade</th>
                <th class="text-right">Percentual</th>
            </tr>
        </thead>

        <tbody>

            @forelse ($porTipo as $tipo)

                <tr>

                    <td>
                        {{ $tipo['nome'] }}

                        <div class="barra-container">
                            <div
                                class="barra"
                                style="width: {{ $tipo['porcentagem'] }}%;"
                            ></div>
                        </div>
                    </td>

                    <td class="text-right">
                        {{ $tipo['quantidade'] }}
                    </td>

                    <td class="text-right">
                        {{ $tipo['porcentagem'] }}%
                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="3">
                        Nenhum atendimento encontrado.
                    </td>
                </tr>

            @endforelse

        </tbody>

    </table>


    {{-- ATENDIMENTOS POR USUÁRIO --}}
    <h2>Atendimentos por usuário</h2>

    <table>

        <thead>

            <tr>
                <th>Usuário</th>
                <th class="text-right">
                    Quantidade
                </th>
            </tr>

        </thead>

        <tbody>

            @forelse ($porUsuario as $usuario)

                <tr>

                    <td>
                        {{ $usuario['nome'] }}
                    </td>

                    <td class="text-right">
                        {{ $usuario['quantidade'] }}
                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="2">
                        Nenhum atendimento encontrado.
                    </td>
                </tr>

            @endforelse

        </tbody>

    </table>


    {{-- ATENDIMENTOS POR DIA --}}
    <h2>Atendimentos por dia</h2>

    <table>

        <thead>

            <tr>
                <th>Data</th>
                <th class="text-right">
                    Quantidade
                </th>
            </tr>

        </thead>

        <tbody>

            @forelse ($porDia as $dia)

                <tr>

                    <td>
                        {{ $dia['data'] }}
                    </td>

                    <td class="text-right">
                        {{ $dia['quantidade'] }}
                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="2">
                        Nenhum atendimento encontrado.
                    </td>
                </tr>

            @endforelse

        </tbody>

    </table>


    {{-- RODAPÉ --}}
    <div class="rodape">
        Sistema de Controle de Atendimentos — Relatório gerado automaticamente
    </div>

</body>

</html>