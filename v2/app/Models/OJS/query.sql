SELECT
  s.submission_id AS id,
  ps_title.setting_value AS titulo,
  CONCAT_WS(' ',
    MAX(CASE WHEN as_given.setting_name = 'givenName' THEN as_given.setting_value END),
    MAX(CASE WHEN as_family.setting_name = 'familyName' THEN as_family.setting_value END)
  ) AS autor,
  CASE s.status
    WHEN 1 THEN 'Submetido'
    WHEN 2 THEN 'Submetido?2'
    WHEN 3 THEN 'Publicado'
    WHEN 4 THEN 'Arquivado'
    WHEN 5 THEN 'Submetido?5'
    ELSE 'Outro'
  END AS situacao,
  MAX(CASE WHEN ps_abstract.setting_name = 'abstract' THEN ps_abstract.setting_value END) AS resumo,
  GROUP_CONCAT(DISTINCT cves.setting_value SEPARATOR '; ') AS palavras_chave
FROM
  submissions s
JOIN publications p ON p.submission_id = s.submission_id
JOIN publication_settings ps_title ON ps_title.publication_id = p.publication_id
  AND ps_title.setting_name = 'title' AND ps_title.locale = 'pt_BR'
LEFT JOIN publication_settings ps_abstract ON ps_abstract.publication_id = p.publication_id
  AND ps_abstract.setting_name = 'abstract' AND ps_abstract.locale = 'pt_BR'
JOIN authors a ON a.publication_id = p.publication_id
LEFT JOIN author_settings as_given ON as_given.author_id = a.author_id AND as_given.setting_name = 'givenName'
LEFT JOIN author_settings as_family ON as_family.author_id = a.author_id AND as_family.setting_name = 'familyName'
LEFT JOIN controlled_vocab_entry_settings cves ON
  cves.locale = 'pt_BR'
  AND cves.setting_name = 'name'
  AND cves.controlled_vocab_entry_id IN (
    SELECT controlled_vocab_entry_id
    FROM controlled_vocab_entry_settings
    WHERE setting_name = 'assoc_type'
    AND setting_value = 'submissionKeyword'
  )
GROUP BY s.submission_id, a.author_id
ORDER BY s.submission_id;
