<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lista de Inscritos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #000;
            background: #fff;
            margin: 24px;
        }
        .topo {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 16px;
        }
        h1 {
            font-size: 22px;
            margin: 0 0 8px 0;
        }
        .meta {
            margin: 2px 0;
            font-size: 14px;
        }
        .btn-print {
            border: 1px solid #222;
            background: #fff;
            padding: 8px 12px;
            cursor: pointer;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #111;
            padding: 8px;
            font-size: 13px;
            vertical-align: middle;
        }
        th {
            text-align: left;
        }
        .assinatura {
            height: 34px;
        }
        @media print {
            .btn-print {
                display: none;
            }
            body {
                margin: 8mm;
            }
        }
    </style>
</head>
<body>
    <?php
    $totalInscritos = is_array($inscritos ?? null) ? count($inscritos) : 0;
    ?>
    <div class="topo">
        <div>
            <h1>Lista de Inscritos para Assinatura</h1>
            <div class="meta"><strong>Evento:</strong> <?= esc($event['e_name'] ?? '-') ?></div>
            <div class="meta"><strong>Data:</strong> <?= esc($event['e_data_i'] ?? '-') ?> até <?= esc($event['e_data_f'] ?? '-') ?></div>
            <div class="meta"><strong>Total de inscritos:</strong> <?= esc((string) $totalInscritos) ?></div>
        </div>
        <button class="btn-print" onclick="window.print()">Imprimir</button>
    </div>

    <?php if ($totalInscritos === 0): ?>
        <p>Nenhum inscrito encontrado para este evento.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th style="width: 52px;">#</th>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th style="width: 35%;">Assinatura</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($inscritos as $index => $inscrito): ?>
                    <tr>
                        <td><?= esc((string) ($index + 1)) ?></td>
                        <td><?= esc($inscrito['n_nome'] ?? '-') ?></td>
                        <td><?= esc($inscrito['n_email'] ?? '-') ?></td>
                        <td><div class="assinatura"></div></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>
