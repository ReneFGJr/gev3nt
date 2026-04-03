<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>
<div class="container py-4 text-center">
    <h2>Administração</h2>
    <div class="list-group mt-4 mx-auto" style="max-width:400px;">
        <a href="<?= base_url('admin/event') ?>" class="list-group-item list-group-item-action">Gerenciar Evento Base (tabela event)</a>
        <a href="<?= base_url('admin/events') ?>" class="list-group-item list-group-item-action">Gerenciar Eventos</a>
        <!-- Adicione mais links de administração aqui se necessário -->
    </div>
</div>
<?= $this->endSection() ?>
