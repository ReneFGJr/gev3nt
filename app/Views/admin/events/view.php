<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>
<div class="container py-4">
    <div class="text-center mb-4">
        <img src="<?= base_url('img/logo_Gev3nt.png') ?>" alt="Logo Gev3nt" style="max-height:72px; width:auto;" class="img-fluid">
    </div>
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

                    <p><strong>Descrição:</strong> <?= nl2br(esc((string) ($event['e_texto'] ?? ''))) ?></p>
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
            <a href="<?= base_url('admin/events') ?>" class="btn btn-secondary">Voltar</a>
            <a href="<?= base_url('admin/events/edit/' . $event['id_e']) ?>" class="btn btn-primary">Editar</a>
            <a href="<?= base_url('admin/event/import/' . $event['id_e']) ?>" class="btn btn-warning ms-2">Importar usuários / dados</a>
        </div>
        <div class="col-12 col-md-6">
            <h2 class="mb-3">Detalhes do Evento</h2>
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div>
                            <strong class="d-block text-secondary text-uppercase small">Indicadores</strong>
                            <span class="text-muted small">Resumo rápido da participação</span>
                        </div>
                        <span class="badge rounded-pill bg-info-subtle text-info-emphasis px-3 py-2">Atualizado</span>
                    </div>

                    <div class="row g-3">
                        <div class="col-12 col-lg-4">
                            <div class="border rounded-4 bg-white p-3 h-100 shadow-sm">
                                <div class="text-muted small mb-1">Inscritos</div>
                                <div class="d-flex align-items-end gap-2">
                                    <span class="fw-bold text-primary" style="font-size:2rem; line-height:1;">
                                        <?= esc($totalInscritos ?? 0) ?>
                                    </span>
                                    <span class="text-muted mb-1">pessoas</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-lg-4">
                            <div class="border rounded-4 bg-white p-3 h-100 shadow-sm">
                                <div class="text-muted small mb-1">Presentes</div>
                                <div class="d-flex align-items-end gap-2">
                                    <span class="fw-bold text-success" style="font-size:2rem; line-height:1;">
                                        <?= esc($totalPresentes ?? 0) ?>
                                    </span>
                                    <span class="text-muted mb-1">pessoas</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-lg-4">
                            <div class="border rounded-4 bg-white p-3 h-100 shadow-sm">
                                <div class="text-muted small mb-1">Limite de inscritos</div>
                                <div class="d-flex align-items-end gap-2">
                                    <span class="fw-bold text-warning" style="font-size:2rem; line-height:1;">
                                        <?= esc($event['e_limit_inscritos'] ?? 9999) ?>
                                    </span>
                                    <span class="text-muted mb-1">pessoas</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 d-flex justify-content-end gap-2 flex-wrap">
                        <a href="<?= base_url('admin/events/make_certificates/' . $event['id_e']) ?>" class="btn btn-success">
                            Gerar certificados
                        </a>
                        <a href="<?= base_url('admin/events/sign-list/' . $event['id_e']) ?>" class="btn btn-outline-dark" target="_blank" rel="noopener noreferrer">
                            Gerar lista de inscritos para assinatura
                        </a>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div>
                            <strong class="d-block text-secondary text-uppercase small">Inscrições vinculadas</strong>
                            <span class="text-muted small">Registros da tabela event_inscricoes com ei_event igual ao ID do evento</span>
                        </div>
                        <span class="badge rounded-pill bg-secondary-subtle text-secondary-emphasis px-3 py-2">
                            <?= esc((string) (is_array($eventInscricoes ?? null) ? count($eventInscricoes) : 0)) ?> registro(s)
                        </span>
                    </div>

                    <?php if (empty($eventInscricoes)): ?>
                        <div class="alert alert-info mb-0">Nenhuma inscrição encontrada para este evento.</div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Modalidade</th>
                                        <th>Descrição</th>
                                        <th>Data início</th>
                                        <th>Data final</th>
                                        <th>Preço</th>
                                        <th>Ativo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($eventInscricoes as $inscricao): ?>
                                        <tr>
                                            <td><?= esc((string) ($inscricao['id_ei'] ?? '')) ?></td>
                                            <td><?= esc($inscricao['ei_modalidade'] ?? '-') ?></td>
                                            <td><?= nl2br(esc((string) ($inscricao['ei_descricao'] ?? '-'))) ?></td>
                                            <td><?= esc($inscricao['ei_data_inicio'] ?? '-') ?></td>
                                            <td><?= esc($inscricao['ei_data_final'] ?? '-') ?></td>
                                            <td><?= esc((string) ($inscricao['ei_preco'] ?? '0')) ?></td>
                                            <td><?= (int) ($inscricao['ei_ativo'] ?? 0) === 1 ? 'Sim' : 'Não' ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>