<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>
<div class="row mt-4 justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="col-md-7 col-lg-6">
        <div class="p-4 text-center" style="background: linear-gradient(135deg, #0f2027 0%, #2c5364 100%); border-radius: 18px; box-shadow: 0 2px 12px rgba(44,83,100,0.10);">
            <img src="<?= base_url('img/logo_Gev3nt.png') ?>" alt="Logotipo Gev3nt" style="height:164px; width:auto; margin-bottom: 14px;">
            <h2 class="mb-3" style="color:#90caf9; font-weight:700;">Sobre o sistema</h2>
            <p class="mb-4" style="color:#e3f2fd; font-size:1.02rem; line-height:1.7; text-align:justify;">
                O Gev3nt é uma plataforma para gerenciamento de eventos academicos e cientificos, reunindo em um so lugar
                inscricoes, controle de participantes e emissao de certificados. O sistema facilita o trabalho da equipe
                organizadora e oferece mais praticidade para autores e participantes durante todas as etapas do evento.
            </p>
            <h2 class="mb-3" style="color:#90caf9; font-weight:700;">Fale Conosco</h2>
            <p class="mb-4" style="color:#e3f2fd; font-size:1.02rem; line-height:1.7; text-align:justify;">
                Tem dúvidas, sugestões ou precisa de suporte?<br>
                Nossa equipe está pronta para ajudar você!</p>
            <p class="mb-4" style="color:#b0bec5; font-size:1.1rem;">Envie um e-mail para:</p>
            <a href="mailto:brapcici@gmail.com" class="btn btn-outline-info btn-lg fw-bold mb-2">brapcici@gmail.com</a>
        </div>
    </div>
</div>
<?= $this->endSection() ?>