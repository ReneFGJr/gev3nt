<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>
<div class="container py-4">
    <div class="row">
        <div class="col-12 col-md-6">
            <h2>Dados do Evento</h2>
            <div class="card mb-4">
                <div class="card-body">
                    <h4 class="card-title mb-3">
                        <?= esc($event['e_name']) ?>
                        <?php
                        $statusLabels = [
                            0 => ['label' => 'Aberto para inscrição', 'class' => 'bg-success'],
                            1 => ['label' => 'Finalizado', 'class' => 'bg-secondary'],
                            9 => ['label' => 'Cancelado', 'class' => 'bg-danger'],
                        ];
                        $status = $event['e_status'] ?? 0;
                        ?>
                        <span class="badge <?= $statusLabels[$status]['class'] ?? 'bg-info' ?> ms-2" style="font-size:1rem;">
                            <?= $statusLabels[$status]['label'] ?? 'Desconhecido' ?>
                        </span>
                    </h4>
                    <?php if (!empty($event['e_ass_img'])): ?>
                        <img src="<?= base_url($event['e_ass_img']) ?>" alt="Imagem do Evento" style="max-width:300px;" class="mb-3 d-block">
                    <?php endif; ?>
                    <p><strong>Descrição:</strong> <?= nl2br(esc($event['e_texto'])) ?></p>
                    <p><strong>Localização:</strong> <?= esc($event['e_location']) ?></p>
                    <p><strong>Data Inicial:</strong> <?= esc($event['e_data_i']) ?>
                        <?php if (!empty($event['e_hora_inicio'])): ?>
                            <span class="ms-2"><strong>Hora Inicial:</strong> <?= esc($event['e_hora_inicio']) ?></span>
                        <?php endif; ?>
                    </p>
                    <p><strong>Data Final:</strong> <?= esc($event['e_data_f']) ?>
                        <?php if (!empty($event['e_hora_fim'])): ?>
                            <span class="ms-2"><strong>Hora Final:</strong> <?= esc($event['e_hora_fim']) ?></span>
                        <?php endif; ?>
                    </p>
                </div>
            </div>
            <a href="/admin/events" class="btn btn-secondary">Voltar</a>
            <a href="/admin/events/edit/<?= esc($event['id_e']) ?>" class="btn btn-primary">Editar</a>
            <a href="/admin/event/import/<?= esc($event['id_e']) ?>" class="btn btn-warning ms-2">Importar usuários / dados</a>
        </div>
        <div class="col-12 col-md-6">
            <h2>Detalhes do Evento</h2>
            <div class="mb-3 p-3 border rounded bg-light shadow-sm" style="min-width:220px;">
                <strong class="d-block mb-2 text-secondary" style="font-size:1.1rem;">Indicadores</strong>
                <div class="container">
                <div class="row">

                </div></div>
                <span class="badge bg-primary" style="font-size:1rem;">Inscritos: <?= esc($totalInscritos ?? 0) ?></span>
                <span class="badge bg-success ms-2" style="font-size:1rem;">Presentes: <?= esc($totalPresentes ?? 0) ?></span>
            </div>
        </div>
    </div>
    <?= $this->endSection() ?>