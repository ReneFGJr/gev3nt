CREATE TABLE IF NOT EXISTS labels (
    id_label INT UNSIGNED NOT NULL AUTO_INCREMENT,
    nome VARCHAR(255) NOT NULL,
    instituicao VARCHAR(255) NOT NULL,
    status TINYINT(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (id_label),
    KEY idx_labels_nome (nome),
    KEY idx_labels_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;