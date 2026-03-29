<nav style="background: rgba(15,32,39,0.95); box-shadow: 0 2px 8px rgba(44,83,100,0.2); padding: 0 20px;">
    <div style="display: flex; align-items: center; height: 60px; max-width: 1200px; margin: 0 auto; justify-content: space-between;">
        <div style="font-size: 1.5rem; font-weight: bold; letter-spacing: 2px; color: #90caf9;">
            Gev3nt
        </div>
        <ul style="list-style: none; display: flex; margin: 0 0 0 40px; padding: 0; gap: 24px;">
            <li><a href="/" style="font-weight: 500;">Início</a></li>
            <li><a href="/eventos" style="font-weight: 500;">Eventos</a></li>
            <li><a href="/contato" style="font-weight: 500;">Contato</a></li>
        </ul>
        <div style="margin-left: auto;">
            <?php if (session()->has('usuario')): ?>
                <span style="color: #fff; font-weight: 500; margin-right: 16px;">
                    <?= esc(explode(' ', session('usuario.nome'))[0]) ?>
                </span>
                <a href="/auth/logout" style="background: #1976d2; color: #fff; padding: 8px 22px; border-radius: 20px; font-weight: 500; margin-left: 4px;">Sair</a>
            <?php else: ?>
                <a href="/auth/login" style="background: #1976d2; color: #fff; padding: 8px 22px; border-radius: 20px; font-weight: 500;">Login</a>
            <?php endif; ?>
        </div>
    </div>
</nav>