<!-- app/Views/import/form_import.php -->

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-4">

                    <h3 class="text-center mb-4 text-primary fw-bold">
                        <i class="bi bi-upload me-2"></i> Importar Dados
                    </h3>

                    <form action="<?= base_url('certificado/import') ?>" method="post">

                        <div class="mb-3">
                            <label for="data" class="form-label fw-semibold">
                                Cole os dados abaixo
                                Ex: Nome;Email;Outro dado
                            </label>

                            <textarea
                                id="data"
                                name="data"
                                rows="10"
                                class="form-control"
                                placeholder="Digite ou cole aqui a lista de dados, um por linha..."
                                required
                            ></textarea>
                        </div>

                        <button type="submit" class="btn btn-success w-100 mt-3">
                            <i class="bi bi-check-circle me-2"></i> Processar Importação
                        </button>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
