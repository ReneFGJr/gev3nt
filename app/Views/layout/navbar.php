<nav style="background: rgba(15,32,39,0.95); box-shadow: 0 2px 8px rgba(44,83,100,0.2); padding: 0 20px;">
    <div style="display: flex; align-items: center; height: 60px; max-width: 1200px; margin: 0 auto; justify-content: space-between;">
        <div>
            <a href="<?= base_url('/') ?>">
                <img src="<?= base_url('img/logo_Gev3nt.png') ?>" alt="Gev3nt" style="height:40px; width:auto; vertical-align:middle;">
            </a>
        </div>
        <?php
        $authorizedEvents = [];
        $firstAuthorizedEvent = null;
        if (session()->has('usuario')) {
            $userId = session('usuario.id_n') ?? session('usuario.id');
            if ($userId) {
                $authorizedEvents = (new \App\Models\EventPermissionModel())
                    ->select('event_permissions.ep_event_id, event.e_name, event_permissions.ep_created')
                    ->join('event', 'event.id_e = event_permissions.ep_event_id', 'inner')
                    ->where('event_permissions.ep_user_id', (int) $userId)
                    ->where('event_permissions.ep_can_manage', 1)
                    ->orderBy('event.e_name', 'ASC')
                    ->findAll();

                $firstAuthorizedEvent = $authorizedEvents[0] ?? null;
            }
        }
        ?>
        <ul style="list-style: none; display: flex; margin: 0 0 0 40px; padding: 0; gap: 24px;">
            <li><a href="<?=base_url('/');?>" style="font-weight: 500;">Início</a></li>
            <?php if (!empty($authorizedEvents)): ?>
                <li class="nav-item dropdown" style="position: relative;">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" role="button" aria-expanded="false" style="font-weight: 500; color: #fff; padding: 0;">
                        EVENTO
                    </a>
                    <ul class="dropdown-menu" style="background: #ffffff; border: 1px solid rgba(15,23,42,0.12); box-shadow: 0 12px 30px rgba(15,23,42,0.18); min-width: 260px;">
                        <?php foreach ($authorizedEvents as $authorizedEvent): ?>
                            <li>
                                <a class="dropdown-item" href="<?= base_url('admin/events/sections/' . (int) ($authorizedEvent['ep_event_id'] ?? 0)) ?>" style="color: #0f172a;">
                                    <?= esc($authorizedEvent['e_name'] ?? '-') ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                        <li><hr class="dropdown-divider"></li>
                        <?php if (!empty($firstAuthorizedEvent)): ?>
                            <li>
                                <a class="dropdown-item" href="<?= base_url('admin/events/sign-list/' . (int) ($firstAuthorizedEvent['ep_event_id'] ?? 0)) ?>" style="color: #0f172a;">
                                    Lista de presença
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="<?= base_url('admin/events/view/' . (int) ($firstAuthorizedEvent['ep_event_id'] ?? 0)) ?>" style="color: #0f172a;">
                                    Resumo do Evento
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            <li><a href="<?=base_url('/eventos');?>" style="font-weight: 500;">Eventos</a></li>
            <li><a href="<?=base_url('/contato');?>" style="font-weight: 500;">Sobre</a></li>
        </ul>
        <div style="margin-left: auto;">
            <?php if (session()->has('usuario')): ?>
                <span style="color: #fff; font-weight: 500; margin-right: 16px;">
                    <?= esc(explode(' ', session('usuario.nome'))[0]) ?>
                </span>
                <a href="<?=base_url('/auth/logout');?>" style="background: #1976d2; color: #fff; padding: 8px 22px; border-radius: 20px; font-weight: 500; margin-left: 4px;">Sair</a>
            <?php else: ?>
                <a href="<?=base_url('/auth/login');?>" style="background: #1976d2; color: #fff; padding: 8px 22px; border-radius: 20px; font-weight: 500;">Login</a>
            <?php endif; ?>
        </div>
    </div>
</nav>