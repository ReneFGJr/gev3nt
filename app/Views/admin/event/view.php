<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">Visualizar Registro - event</h2>
        <div class="d-flex gap-2">
            <a href="<?= base_url('admin/event') ?>" class="btn btn-outline-secondary" title="Voltar" aria-label="Voltar">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H2.707l4.147 4.146a.5.5 0 0 1-.708.708l-5-5a.5.5 0 0 1 0-.708l5-5a.5.5 0 0 1 .708.708L2.707 7.5H14.5A.5.5 0 0 1 15 8z"/>
                </svg>
            </a>
            <a href="<?= base_url('admin/event/edit/' . ($item['id_e'] ?? 0)) ?>" class="btn btn-primary" title="Editar" aria-label="Editar">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                    <path d="M12.146.854a.5.5 0 0 1 .708 0l2.292 2.292a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 3 10.707V13h2.293l7.5-7.5z"/>
                </svg>
            </a>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <dl class="row mb-0">
                <dt class="col-sm-3">ID</dt>
                <dd class="col-sm-9"><?= esc((string) ($item['id_e'] ?? '')) ?></dd>

                <dt class="col-sm-3">Nome</dt>
                <dd class="col-sm-9"><?= esc($item['e_name'] ?? '-') ?></dd>

                <dt class="col-sm-3">URL</dt>
                <dd class="col-sm-9"><?= esc($item['e_url'] ?? '-') ?></dd>

                <dt class="col-sm-3">Descrição</dt>
                <dd class="col-sm-9"><?= nl2br(esc($item['e_description'] ?? '-')) ?></dd>

                <dt class="col-sm-3">Logo</dt>
                <dd class="col-sm-9"><?= esc($item['e_logo'] ?? '-') ?></dd>

                <dt class="col-sm-3">Cidade</dt>
                <dd class="col-sm-9"><?= esc($item['e_cidade'] ?? '-') ?></dd>

                <dt class="col-sm-3">Ativo</dt>
                <dd class="col-sm-9"><?= (int) ($item['e_active'] ?? 0) === 1 ? 'Sim' : 'Não' ?></dd>

                <dt class="col-sm-3">Data Inicial</dt>
                <dd class="col-sm-9"><?= esc($item['e_data_i'] ?? '-') ?></dd>

                <dt class="col-sm-3">Data Final</dt>
                <dd class="col-sm-9"><?= esc($item['e_data_f'] ?? '-') ?></dd>

                <dt class="col-sm-3">Inscrição até</dt>
                <dd class="col-sm-9"><?= esc($item['e_sigin_until'] ?? '-') ?></dd>

                <dt class="col-sm-3">Background</dt>
                <dd class="col-sm-9">
                    <?php if (!empty($item['e_background'])): ?>
                        <a href="<?= base_url($item['e_background']) ?>" target="_blank" rel="noopener noreferrer"><?= esc($item['e_background']) ?></a>
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </dd>
            </dl>
        </div>
    </div>
</div>
<?= $this->endSection() ?>