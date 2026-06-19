<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>
<style>
    .sections-page {
        padding: 24px 0 8px;
    }

    .sections-shell {
        background: linear-gradient(180deg, #ffffff 0%, #f7fafc 100%);
        border: 1px solid #d9e0ea;
        border-radius: 18px;
        padding: 24px;
        box-shadow: 0 14px 40px rgba(15, 23, 42, 0.08);
        color: #0f172a;
    }

    .sections-topo {
        display: flex;
        justify-content: space-between;
        gap: 16px;
        align-items: flex-start;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    .sections-title {
        margin: 0 0 8px 0;
        font-size: 26px;
        font-weight: 700;
        color: #0f172a;
    }

    .sections-meta {
        margin: 2px 0;
        color: #475569;
        font-size: 14px;
    }

    .sections-actions {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .sections-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 10px 14px;
        border-radius: 10px;
        border: 1px solid #0f172a;
        color: #0f172a;
        background: #fff;
        text-decoration: none;
    }

    .sections-btn-primary {
        background: #1976d2;
        color: #fff;
        border-color: #1976d2;
    }

    .sections-btn-inline {
        margin: 8px 0 12px;
    }

    .sections-action-row {
        margin-bottom: 12px;
    }

    .sections-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 14px;
    }

    .sections-item {
        border: 1px solid #d9e0ea;
        border-radius: 14px;
        padding: 16px;
        background: #fff;
        color: #0f172a;
    }

    .sections-item h3 {
        margin: 0 0 8px 0;
        font-size: 18px;
        color: #0f172a;
    }

    .sections-item strong,
    .sections-item li,
    .sections-item ul {
        color: #0f172a;
    }

    .sections-kv {
        margin: 4px 0;
        font-size: 14px;
    }

    .sections-empty {
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        color: #1e3a8a;
        border-radius: 12px;
        padding: 16px;
    }

    .highlight-card {
        background: linear-gradient(135deg, #1976d2 0%, #0b4f8a 100%);
        color: #fff;
        border-radius: 18px;
        padding: 18px 20px;
        min-width: 220px;
        box-shadow: 0 16px 34px rgba(25, 118, 210, 0.22);
    }

    .highlight-card .label {
        font-size: 13px;
        opacity: 0.9;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        margin-bottom: 8px;
    }

    .highlight-card .value {
        font-size: 44px;
        line-height: 1;
        font-weight: 800;
    }
</style>

<div class="container sections-page">
    <div class="sections-shell">
        <div class="sections-topo">
            <div>
                <h1 class="sections-title">Seções do Evento</h1>
                <div class="sections-meta"><strong>Evento:</strong> <?= esc($event['e_name'] ?? '-') ?></div>
                <div class="sections-meta"><strong>ID do evento:</strong> <?= esc((string) ($event['id_e'] ?? '')) ?></div>
                <div class="sections-meta">As seções abaixo vêm da tabela events vinculada por e_event.</div>
            </div>
            <div class="highlight-card">
                <div class="label">Inscritos</div>
                <div class="value"><?= esc((string) ($totalInscritos ?? 0)) ?></div>
            </div>
        </div>

        <?php if (empty($sections)): ?>
            <div class="sections-empty">Nenhuma seção encontrada para este evento.</div>
        <?php else: ?>
            <div class="sections-grid">
                <?php foreach ($sections as $section): ?>
                    <?php $sectionId = (int) ($section['id_e'] ?? 0);
                    $inscritos = $inscritosBySection[$sectionId] ?? []; ?>
                    <div class="sections-item">
                        <div class="sections-action-row">
                            <a href="<?= base_url('admin/events/sign-list/' . (int) ($section['id_e'] ?? 0)) ?>" class="sections-btn sections-btn-primary sections-btn-inline full">Lista de presença</a>
                        </div>

                        <h3 style="font-weight: bold;"><?= esc($section['e_name'] ?? '-') ?></h3>
                        <div class="sections-kv"><strong>Descrição:</strong> <?= nl2br(esc((string) ($section['e_texto'] ?? '-'))) ?></div>
                        <div class="sections-kv"><strong>Data inicial:</strong> <?= esc($section['e_data_i'] ?? '-') ?></div>
                        <div class="sections-kv"><strong>Data final:</strong> <?= esc($section['e_data_f'] ?? '-') ?></div>
                        <div class="sections-kv"><strong>Hora:</strong> <?= esc(($section['e_hora_inicio'] ?? '-') . ' - ' . ($section['e_hora_fim'] ?? '-')) ?></div>
                        <div class="sections-kv"><strong>Local:</strong> <?= esc($section['e_location'] ?? '-') ?></div>
                        <div class="sections-kv"><strong>Ativo:</strong> <?= ((int) ($section['e_status'] ?? 0) !== 9) ? 'Sim' : 'Não' ?></div>
                        <div class="sections-kv"><strong>Inscritos nesta seção:</strong> <?= esc((string) count($inscritos)) ?></div>

                        <?php if (!empty($inscritos)): ?>
                            <div class="mt-3">
                                <div class="sections-kv"><strong>Participantes:</strong></div>
                                <ul class="mb-0 ps-3">
                                    <?php foreach ($inscritos as $inscrito): ?>
                                        <li>
                                            <?= esc($inscrito['n_nome'] ?? '-') ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>