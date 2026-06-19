-- --------------------------------------------------------

--
-- Estrutura da tabela `event_permissions`
--

CREATE TABLE IF NOT EXISTS `event_permissions` (
  `id_ep` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ep_event_id` bigint(20) UNSIGNED NOT NULL,
  `ep_user_id` bigint(20) UNSIGNED NOT NULL,
  `ep_can_manage` tinyint(1) NOT NULL DEFAULT 1,
  `ep_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_ep`),
  UNIQUE KEY `uk_event_user` (`ep_event_id`, `ep_user_id`),
  KEY `idx_event_permissions_event` (`ep_event_id`),
  KEY `idx_event_permissions_user` (`ep_user_id`),
  CONSTRAINT `fk_event_permissions_event` FOREIGN KEY (`ep_event_id`) REFERENCES `event` (`id_e`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_event_permissions_user` FOREIGN KEY (`ep_user_id`) REFERENCES `events_names` (`id_n`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;