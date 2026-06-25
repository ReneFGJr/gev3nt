<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Marcação de Presença</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #000;
            background: #f4f6f8;
            margin: 24px;
        }
        .wrap {
            max-width: 1100px;
            margin: 0 auto;
            background: #fff;
            border: 1px solid #d8dee4;
            border-radius: 12px;
            padding: 20px;
        }
        .topo {
            display: flex;
            justify-content: space-between;
            gap: 16px;
            align-items: flex-start;
            margin-bottom: 16px;
            flex-wrap: wrap;
        }
        h1 {
            font-size: 24px;
            margin: 0 0 8px 0;
        }
        .meta {
            margin: 2px 0;
            font-size: 14px;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #111;
            background: #fff;
            padding: 10px 14px;
            text-decoration: none;
            color: #111;
            cursor: pointer;
            border-radius: 8px;
        }
        .btn-success {
            background: #198754;
            color: #fff;
            border-color: #198754;
        }
        .btn-secondary {
            background: #6c757d;
            color: #fff;
            border-color: #6c757d;
        }
        .cards {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px;
            margin-bottom: 18px;
        }
        .card {
            border: 1px solid #d8dee4;
            border-radius: 12px;
            padding: 14px;
            background: #fafbfc;
        }
        .card .label {
            font-size: 13px;
            color: #667085;
            margin-bottom: 6px;
        }
        .card .value {
            font-size: 28px;
            font-weight: 700;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
        }
        th, td {
            border: 1px solid #111;
            padding: 10px;
            font-size: 14px;
            vertical-align: middle;
        }
        th {
            text-align: left;
            background: #eef2f7;
        }
        .nome-link {
            color: #0d6efd;
            text-decoration: none;
            font-weight: 700;
        }
        .nome-link:hover {
            text-decoration: underline;
        }
        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
        }
        .badge-ok {
            background: #d1e7dd;
            color: #0f5132;
        }
        .badge-pending {
            background: #fff3cd;
            color: #664d03;
        }
        @media (max-width: 768px) {
            .cards {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="wrap">
        <?php
        $totalInscritos = (int) ($totalInscritos ?? 0);
        $totalPresentes = (int) ($totalPresentes ?? 0);
        $totalPendentes = max(0, $totalInscritos - $totalPresentes);
        ?>

        <div class="topo">
            <div>
                <h1>Marcação de presença</h1>
                <div class="meta"><strong>Evento:</strong> <?= esc($event['e_name'] ?? '-') ?></div>
                <div class="meta"><strong>Data:</strong> <?= esc($event['e_data_i'] ?? '-') ?> até <?= esc($event['e_data_f'] ?? '-') ?></div>
                <div class="meta"><strong>Instrução:</strong> clique no nome da pessoa para marcar presença.</div>
            </div>
            <div style="display:flex; gap:8px;">
                <a href="<?= base_url('admin/events/sign-list/' . (int) ($event['id_e'] ?? 0)) ?>" class="btn btn-secondary">Voltar ao resumo</a>
                <a href="<?= base_url('admin/events') ?>" class="btn">Eventos</a>
            </div>
        </div>

        <div class="cards">
            <div class="card">
                <div class="label">Total de inscritos</div>
                <div class="value"><?= esc((string) $totalInscritos) ?></div>
            </div>
            <div class="card">
                <div class="label">Presentes</div>
                <div class="value"><?= esc((string) $totalPresentes) ?></div>
            </div>
            <div class="card">
                <div class="label">Pendentes</div>
                <div class="value"><?= esc((string) $totalPendentes) ?></div>
            </div>
        </div>

        <?php if (empty($inscritos)): ?>
            <p>Nenhum inscrito encontrado para este evento.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th style="width: 52px;">#</th>
                        <th>Nome</th>
                        <th style="width: 120px;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($inscritos as $index => $inscrito): ?>
                        <?php $presente = (int) ($inscrito['ein_presente'] ?? 0) === 1; ?>
                        <tr>
                            <td><?= esc((string) ($index + 1)) ?></td>
                            <td>
                                <?php if ($presente): ?>
                                    <form action="<?= base_url('admin/events/mark-pending/' . (int) ($inscrito['id_ein'] ?? 0)) ?>" method="post" style="display:inline;">
                                        <button type="submit" class="nome-link" style="background:none; border:none; padding:0; cursor:pointer; font:inherit; text-align:left; color:#198754;">
                                            <?= esc($inscrito['n_nome'] ?? '-') ?>
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <form action="<?= base_url('admin/events/mark-present/' . (int) ($inscrito['id_ein'] ?? 0)) ?>" method="post" style="display:inline;">
                                        <button type="submit" class="nome-link" style="background:none; border:none; padding:0; cursor:pointer; font:inherit; text-align:left; font-size: 2rem;">
                                            <?= esc($inscrito['n_nome'] ?? '-') ?>
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($presente): ?>
                                    <span class="badge badge-ok">Presente</span>
                                <?php else: ?>
                                    <span class="badge badge-pending">Pendente</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>