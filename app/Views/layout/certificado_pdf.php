<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Certificado</title>
    <style>
        body { font-family: Arial, sans-serif; background: #fff; color: #222; }
        .certificado {
            border: 8px solid #1976d2;
            padding: 40px 60px;
            margin: 30px auto;
            max-width: 900px;
            background: #f4faff;
            border-radius: 18px;
            text-align: center;
        }
        .titulo {
            font-size: 2.5rem;
            color: #1976d2;
            font-weight: bold;
            margin-bottom: 30px;
        }
        .texto {
            font-size: 1.3rem;
            margin: 30px 0;
        }
        .assinatura {
            margin-top: 60px;
            font-size: 1.1rem;
        }
        .evento {
            font-size: 1.1rem;
            color: #1976d2;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="certificado">
        <div class="titulo">Certificado de Participação</div>
        <div class="evento">
            Evento: <strong><?= esc($cert['nome'] ?? $cert['id_e']) ?></strong><br>
            Data: <?= esc(date('d/m/Y', strtotime($cert['i_date_in']))) ?>
        </div>
        <div class="texto">
            Certificamos que <strong><?= esc($cert['i_autores'] ?? '-') ?></strong><br>
            participou do evento <strong><?= esc($cert['nome'] ?? $cert['id_e']) ?></strong><br>
            com o trabalho intitulado <strong><?= esc($cert['i_titulo_trabalho'] ?? '-') ?></strong>,<br>
            com carga horária de <strong><?= esc($cert['i_carga_horaria'] ?? '-') ?> horas</strong>.<br>
        </div>
        <div class="assinatura">
            _______________________________<br>
            Comissão Organizadora
        </div>
    </div>
</body>
</html>
