# Regras do Projeto Gev3nt

## Stack e Estrutura
- O projeto usa CodeIgniter 4 com PHP.
- Views, controllers e models devem seguir a estrutura existente em `app/`.
- Preserve os nomes de tabelas e colunas já usados no banco.

## Convenções
- Use português no texto da interface, mensagens e rótulos.
- Mantenha o padrão visual atual do projeto com Bootstrap.
- Reaproveite layouts existentes quando possível.
- Prefira mudanças pequenas e focadas no comportamento solicitado.

## Banco de Dados
- Antes de assumir relacionamento entre tabelas, confirme a estrutura real do schema.
- Use os nomes de colunas e tabelas já existentes no projeto.
- Quando houver dúvida, valide com `SHOW CREATE TABLE` ou leitura do SQL de documentação.

## Views e Navegação
- Se uma página faz parte do site público, ela deve usar `layout/header` e `layout/footer`.
- Se a página for administrativa, mantenha o padrão do módulo admin.
- Dropdowns do navbar devem ter contraste legível.

## Sessões e Permissões
- Use a sessão `usuario` como base para identificar o usuário logado.
- Para menus e ações protegidas, valide permissões antes de exibir links.
- Quando houver autorização por evento, use a tabela `event_permissions`.

## Listagens e Filtros
- Em listas de presença, priorize o estado funcional da operação.
- Ordene os itens de forma previsível, normalmente por nome.
- Quando existir alternância de estado, o clique deve refletir claramente a mudança.

## PDFs e Certificados
- Mantenha a geração de certificados e QR codes compatível com TCPDF e phpqrcode.
- Preserve o fluxo atual de impressão de certificados.

## Segurança e Qualidade
- Evite adicionar dependências novas sem necessidade.
- Sempre valide a sintaxe PHP após alterar controller ou view.
- Não remova mudanças do usuário sem solicitação explícita.
