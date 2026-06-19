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
            <button class="btn btn-success" type="button" data-bs-toggle="collapse" data-bs-target="#grantAccessPanel" aria-expanded="false" aria-controls="grantAccessPanel" title="Liberar acesso" aria-label="Liberar acesso">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-unlock" viewBox="0 0 16 16">
                    <path d="M11 1a2 2 0 0 0-2 2v4a2 2 0 0 1 2 2h1a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h.5A1.5 1.5 0 0 1 6 10.5v-.5a1.5 1.5 0 0 1 1.5-1.5H9V3a3 3 0 0 1 6 0h-1a2 2 0 0 0-2-2z"/>
                </svg>
            </button>
        </div>
    </div>

    <div class="collapse mb-3" id="grantAccessPanel">
        <div class="card shadow-sm border-success">
            <div class="card-body">
                <h5 class="card-title mb-3">Liberar acesso ao evento</h5>
                <p class="text-muted mb-3">Selecione o usuário que poderá gerenciar este registro.</p>

                <?php if (!empty($users)): ?>
                    <form action="<?= base_url('admin/event/grant-access/' . ($item['id_e'] ?? 0)) ?>" method="post" class="row g-3 align-items-end">
                        <div class="col-12 col-md-8">
                            <label for="ep_user_id" class="form-label">Usuário</label>
                            <select name="ep_user_id" id="ep_user_id" class="form-select" required>
                                <option value="">Selecione um usuário</option>
                                <?php foreach ($users as $user): ?>
                                    <option value="<?= esc((string) ($user['id_n'] ?? '')) ?>">
                                        <?= esc(($user['n_nome'] ?? '-') . ' - ' . ($user['n_email'] ?? '-')) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-12 col-md-4 d-grid">
                            <button type="submit" class="btn btn-success">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-unlock me-1" viewBox="0 0 16 16">
                                    <path d="M11 1a2 2 0 0 0-2 2v4a2 2 0 0 1 2 2h1a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h.5A1.5 1.5 0 0 1 6 10.5v-.5a1.5 1.5 0 0 1 1.5-1.5H9V3a3 3 0 0 1 6 0h-1a2 2 0 0 0-2-2z"/>
                                </svg>
                                Liberar acesso
                            </button>
                        </div>
                    </form>
                <?php else: ?>
                    <div class="alert alert-warning mb-0">Nenhum usuário disponível para seleção.</div>
                <?php endif; ?>

                <hr class="my-4">

                <h5 class="card-title mb-3">Usuários liberados</h5>
                <?php if (!empty($permissions)): ?>
                    <div class="table-responsive">
                        <table class="table table-sm table-striped align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>E-mail</th>
                                    <th>Liberado em</th>
                                    <th style="width: 160px;">Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($permissions as $permission): ?>
                                    <tr>
                                        <td><?= esc($permission['n_nome'] ?? '-') ?></td>
                                        <td><?= esc($permission['n_email'] ?? '-') ?></td>
                                        <td><?= esc($permission['ep_created'] ?? '-') ?></td>
                                        <td>
                                            <form action="<?= base_url('admin/event/revoke-access/' . ($permission['id_ep'] ?? 0)) ?>" method="post" onsubmit="return confirm('Excluir esta liberação?');" class="d-inline">
                                                <input type="hidden" name="event_id" value="<?= esc((string) ($item['id_e'] ?? 0)) ?>">
                                                <button type="submit" class="btn btn-danger btn-sm" title="Excluir liberação" aria-label="Excluir liberação">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                                        <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1 0-2H5.5a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1H13.5a1 1 0 0 1 1 1zm-11 1v9a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4h-8zm3-3a.5.5 0 0 0-.5.5V2h4v-.5A.5.5 0 0 0 9 1h-3z"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info mb-0">Nenhum usuário foi liberado para este evento.</div>
                <?php endif; ?>
            </div>
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

    <?php if (session('success')): ?>
        <div class="alert alert-success mt-3"><?= esc(session('success')) ?></div>
    <?php endif; ?>

    <?php if (session('error')): ?>
        <div class="alert alert-danger mt-3"><?= esc(session('error')) ?></div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>