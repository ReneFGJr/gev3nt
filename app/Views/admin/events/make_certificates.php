<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>
<div class="container py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
        <div>
            <h2 class="mb-1">Gerar Certificados</h2>
            <div class="text-muted">Evento: <?= esc($event['e_name'] ?? '-') ?></div>
        </div>
        <a href="<?= base_url('admin/events/view/' . ($event['id_e'] ?? 0)) ?>" class="btn btn-secondary">Voltar ao evento</a>
    </div>

    <?php if (!empty($message)): ?>
        <div class="alert alert-<?= esc($messageType ?? 'info') ?>"><?= esc($message) ?></div>
    <?php endif; ?>

    <?php if (empty($trabalhos)): ?>
        <div class="alert alert-info">Nenhum trabalho encontrado para este evento.</div>
    <?php else: ?>
        <form action="<?= base_url('admin/events/make_certificates/' . ($event['id_e'] ?? 0)) ?>" method="post">
            <div class="d-flex flex-wrap gap-2 mb-3">
                <button type="button" id="btn-select-all" class="btn btn-outline-primary">Selecionar todos</button>
                <button type="submit" class="btn btn-success">Gerar certificados</button>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width:56px;">Sel.</th>
                            <th>Autores</th>
                            <th>Título do trabalho</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($trabalhos as $trabalho): ?>
                            <?php
                            $idEin = (int) ($trabalho['id_ein'] ?? 0);
                            $isChecked = in_array($idEin, $selectedIds ?? [], true);
                            $autorPrincipal = trim((string) ($trabalho['n_nome'] ?? ''));
                            $coautores = trim((string) ($trabalho['ein_coautores'] ?? ''));
                            $autores = $autorPrincipal;
                            if ($coautores !== '') {
                                $autores = $autores !== '' ? ($autores . ', ' . $coautores) : $coautores;
                            }
                            if ($autores === '') {
                                $autores = '-';
                            }
                            $titulo = trim((string) ($trabalho['ein_titulo_trabalho'] ?? ''));
                            if ($titulo === '') {
                                $titulo = '(Sem título informado)';
                            }
                             ?>
                            <tr>
                                <td class="text-center">
                                    <input class="form-check-input cert-check" type="checkbox" name="selected_inscritos[]" value="<?= esc((string) $idEin) ?>" <?= $isChecked ? 'checked' : '' ?>>
                                </td>
                                <td>
                                    <div><?= esc($autores) ?></div>
                                    <?php if (!empty($trabalho['n_email'])): ?>
                                        <div class="small text-muted"><?= esc($trabalho['n_email']) ?></div>
                                    <?php endif; ?>
                                </td>
                                <td><?= esc($titulo) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </form>
    <?php endif; ?>

    <?php if (!empty($gerados)): ?>
        <div class="card mt-4 border-success">
            <div class="card-header bg-success text-white">Trabalhos selecionados para gerar certificados</div>
            <ul class="list-group list-group-flush">
                <?php foreach ($gerados as $item): ?>
                    <?php
                    $autoresGerado = trim((string) ($item['n_nome'] ?? ''));
                    $coautoresGerado = trim((string) ($item['ein_coautores'] ?? ''));
                    if ($coautoresGerado !== '') {
                        $autoresGerado = $autoresGerado !== '' ? ($autoresGerado . ', ' . $coautoresGerado) : $coautoresGerado;
                    }
                    if ($autoresGerado === '') {
                        $autoresGerado = '-';
                    }
                    $tituloGerado = trim((string) ($item['ein_titulo_trabalho'] ?? ''));
                    if ($tituloGerado === '') {
                        $tituloGerado = '(Sem título informado)';
                    }
                     ?>
                    <li class="list-group-item">
                        <strong><?= esc($tituloGerado) ?></strong>
                        <div class="text-muted small"><?= esc($autoresGerado) ?></div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
</div>

<script>
(function () {
    var button = document.getElementById('btn-select-all');
    if (!button) {
        return;
    }

    button.addEventListener('click', function () {
        var checks = document.querySelectorAll('.cert-check');
        if (!checks.length) {
            return;
        }

        var allChecked = true;
        checks.forEach(function (checkbox) {
            if (!checkbox.checked) {
                allChecked = false;
            }
        });

        checks.forEach(function (checkbox) {
            checkbox.checked = !allChecked;
        });

        button.textContent = allChecked ? 'Selecionar todos' : 'Desmarcar todos';
    });
})();
</script>
<?= $this->endSection() ?>
