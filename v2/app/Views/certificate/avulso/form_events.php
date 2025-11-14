<!-- app/Views/certificates/form_search.php -->
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-4">

                    <h3 class="text-center mb-4 text-primary fw-bold">
                        <i class="bi bi-search me-2"></i> Buscar Certificado
                    </h3>

                    <form action="<?= base_url('certificado/busca') ?>" method="post">

                        <!-- Nome completo -->
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">Nome Completo</label>
                            <input
                                type="text"
                                class="form-control"
                                id="name"
                                name="name"
                                placeholder="Digite o nome completo"
                            >
                        </div>

                        <div class="text-center my-2 fw-bold">OU</div>

                        <!-- E-mail -->
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">E-mail</label>
                            <input
                                type="email"
                                class="form-control"
                                id="email"
                                name="email"
                                placeholder="Digite o e-mail"
                            >
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mt-3">
                            <i class="bi bi-check-circle me-2"></i> Buscar
                        </button>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
