<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title : 'Gev3nt' ?></title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ENjdO4Dr2bkBIFxQpeoA6DQD5l5/2Qp1Kkz0l6Y5rZl5QVO5d+M5Dk5t5Q5Q5Q5Q" crossorigin="anonymous">
    <link href="/style.css" rel="stylesheet">
    <?= $this->renderSection('styles') ?>
</head>
<body>
    <?= $this->include('layout/navbar') ?>
    <div class="container">
        <?= $this->renderSection('content') ?>
    </div>
    <?= $this->include('layout/footer') ?>
    <?= $this->renderSection('scripts') ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6/2Qp1Kkz0l6Y5rZl5QVO5d+M5Dk5t5Q5Q5Q5Q" crossorigin="anonymous"></script>
</body>
</html>