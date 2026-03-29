ALTER TABLE `event_inscricoes`
ADD COLUMN `reset_token` VARCHAR(255) DEFAULT NULL,
ADD COLUMN `reset_token_expires` DATETIME DEFAULT NULL;