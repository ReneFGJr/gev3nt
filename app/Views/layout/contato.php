<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>
<div class="row justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="col-md-7 col-lg-6">
        <div class="p-4 text-center" style="background: linear-gradient(135deg, #0f2027 0%, #2c5364 100%); border-radius: 18px; box-shadow: 0 2px 12px rgba(44,83,100,0.10);">
            <h2 class="mb-3" style="color:#90caf9; font-weight:700;">Fale Conosco</h2>
            <p class="lead mb-3" style="color:#f4f4f4;">Tem dúvidas, sugestões ou precisa de suporte?<br>
                Nossa equipe está pronta para ajudar você!</p>
            <p class="mb-4" style="color:#b0bec5; font-size:1.1rem;">Envie um e-mail para:</p>
            <a href="mailto:brapcici@gmail.com" class="btn btn-outline-info btn-lg fw-bold mb-2">brapcici@gmail.com</a>
            <p class="mt-4" style="color:#b0bec5; font-size:0.98rem;">Responderemos o mais breve possível.<br>Obrigado pelo seu contato!</p>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
