<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>
<div class="container py-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h2 class="mb-0">Eventos Abertos</h2>
        <small class="text-muted">Somente eventos com data final igual ou superior a hoje</small>
    </div>

    <?php if (session('erro')): ?>
        <div class="alert alert-danger"><?= esc(session('erro')) ?></div>
    <?php endif; ?>

    <?php if (session('success')): ?>
        <div class="alert alert-success"><?= esc(session('success')) ?></div>
    <?php endif; ?>

    <?php if (empty($eventos)): ?>
        <div class="alert alert-info">Nenhum evento disponível para inscrição no momento.</div>
    <?php else: ?>
        <div class="d-flex flex-column gap-4">
            <?php foreach ($eventos as $evento): ?>
                <div class="card shadow-sm border-0 overflow-hidden">
                    <div class="row g-0">
                        <div class="col-12 col-lg-5 bg-light d-flex align-items-center justify-content-center" style="min-height: 260px;">
                            <?php if (!empty($evento['e_ass_img'])): ?>
                                <img src="<?= base_url($evento['e_ass_img']) ?>" alt="Banner do evento" style="width: 100%; max-height: 320px; object-fit: contain;">
                            <?php else: ?>
                                <div class="text-muted">Sem banner</div>
                            <?php endif; ?>
                        </div>

                        <div class="col-12 col-lg-7">
                            <div class="card-body h-100 d-flex flex-column p-4">
                                <h5 class="card-title mb-2"><?= esc($evento['e_name'] ?? 'Evento') ?></h5>
                                <p class="card-text text-muted mb-2"><strong>Local:</strong> <?= esc($evento['e_location'] ?? 'Não informado') ?></p>
                                <?php
                                $dataInicioRaw = $evento['e_data_i'] ?? null;
                                $dataFimRaw = $evento['e_data_f'] ?? null;
                                $horaInicio = $evento['e_hora_inicio'] ?? '';
                                $horaFim = $evento['e_hora_fim'] ?? '';

                                $dataInicioBr = $dataInicioRaw ? date('d/m/Y', strtotime($dataInicioRaw)) : '-';
                                $dataFimBr = $dataFimRaw ? date('d/m/Y', strtotime($dataFimRaw)) : '-';
                                $mesmaData = $dataInicioRaw && $dataFimRaw && $dataInicioRaw === $dataFimRaw;
                                ?>
                                <p class="card-text text-muted mb-3">
                                    <strong>Período:</strong>
                                    <?php if ($mesmaData): ?>
                                        <?= esc($dataInicioBr) ?>
                                    <?php else: ?>
                                        <?= esc($dataInicioBr) ?> até <?= esc($dataFimBr) ?>
                                    <?php endif; ?>

                                    <?php if (!empty($horaInicio) || !empty($horaFim)): ?>
                                        <span class="ms-2">
                                            <strong>Horário:</strong>
                                            <?php if (!empty($horaInicio) && !empty($horaFim)): ?>
                                                <?= esc($horaInicio) ?> às <?= esc($horaFim) ?>
                                            <?php elseif (!empty($horaInicio)): ?>
                                                Início às <?= esc($horaInicio) ?>
                                            <?php else: ?>
                                                Fim às <?= esc($horaFim) ?>
                                            <?php endif; ?>
                                        </span>
                                    <?php endif; ?>
                                </p>

                                <p class="card-text mb-4"><?= esc($evento['e_texto'] ?? '') ?></p>

                                <div class="mt-auto">
                                    <?php if (session('usuario')): ?>
                                        <?php $jaInscrito = !empty($inscricoesUsuario[(int) ($evento['id_e'] ?? 0)]); ?>
                                        <?php if ($jaInscrito): ?>
                                            <div class="d-flex gap-2 flex-wrap">
                                                <button type="button" class="btn btn-secondary" disabled>Já inscrito</button>
                                                <form action="/eventos/enviar-confirmacao/<?= esc($evento['id_e']) ?>" method="post">
                                                    <button type="submit" class="btn btn-outline-primary">Enviar para meu e-mail</button>
                                                </form>
                                                <form action="/eventos/cancelar/<?= esc($evento['id_e']) ?>" method="post">
                                                    <button type="submit" class="btn btn-outline-danger">Cancelar inscrição</button>
                                                </form>
                                            </div>
                                        <?php else: ?>
                                            <form action="/eventos/inscrever/<?= esc($evento['id_e']) ?>" method="post">
                                                <button type="submit" class="btn btn-primary">Inscrever-se</button>
                                            </form>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <a href="/auth/registrar" class="btn btn-success">Cadastrar-se</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>
