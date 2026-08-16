<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Imprimir etiqueta</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 24px;
            background: #f5f5f5;
        }

        .toolbar {
            display: flex;
            gap: 12px;
            margin-bottom: 24px;
        }

        .toolbar a,
        .toolbar button {
            border: 1px solid #0d6efd;
            background: #0d6efd;
            color: #fff;
            padding: 10px 16px;
            text-decoration: none;
            cursor: pointer;
            border-radius: 6px;
            font-size: 14px;
        }

        .toolbar a {
            background: #6c757d;
            border-color: #6c757d;
        }

        .label-sheet {
            width: 100mm;
            min-height: 35mm;
            background: #fff;
            border: 1px solid #000;
            padding: 10mm 8mm;
            box-sizing: border-box;
        }

        .label-name {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .label-institution {
            font-size: 14px;
        }

        @media print {
            body {
                background: #fff;
                padding: 0;
            }

            .toolbar {
                display: none;
            }

            .label-sheet {
                border: none;
                width: 100%;
                min-height: auto;
            }
        }
    </style>
</head>
<body>
    <div class="toolbar">
        <button type="button" onclick="window.print()">Imprimir</button>
        <a href="<?= base_url('admin/label') ?>">Voltar</a>
    </div>

    <div class="label-sheet">
        <div class="label-name"><?= esc($label['nome']) ?></div>
        <div class="label-institution"><?= esc($label['instituicao']) ?></div>
    </div>
</body>
</html>