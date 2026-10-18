# AVV Travel — Projeto PT/EN

## Instalação
Copie o conteúdo da pasta `site_avv` para o alojamento com suporte para PHP (recomendado PHP 8+). O ponto de entrada é `index.php`.
Não copie `_original_backup` para uma pasta pública do servidor.

## Organização
- `index.php`: página original, com estilos e JavaScript mantidos no mesmo ficheiro para minimizar alterações de comportamento.
- `config.php`: dados centrais da AVV (contactos, WhatsApp, redes sociais, etc.).
- `lang/pt.php`: textos portugueses do HTML.
- `lang/en.php`: textos ingleses do HTML.
- `lang/js.php`: traduções inglesas das mensagens e validações JavaScript.
- `img/`: todas as imagens originais, sem alterações.

## Idioma
Português: `index.php` ou `index.php?lang=pt`
Inglês: `index.php?lang=en`
O seletor PT / EN está no topo. O idioma não é gravado em cookies.
As chaves de tradução são iguais em `pt.php` e `en.php`; altere apenas os valores.
A lógica de formulários, IDs, campos e valores de opção permanece em português/invariante para assegurar a compatibilidade com a lógica existente. Mensagens visíveis são traduzidas no inglês.

## Painel administrativo futuro
Os arrays de `lang/*.php` podem ser substituídos por dados MySQL mantendo a variável `$t` e a função `avv_text()`. O JavaScript recebe traduções por `$js_translations`.

## Segurança e mudanças controladas
A pasta `_original_backup` do ZIP inclui o ficheiro tal como veio no RAR. Guarde esta cópia fora do servidor público.
Não foram feitos ajustes de layout, remoções de CSS, nem refatoração das interações dos formulários nesta etapa. A limpeza de código fica para uma fase seguinte, depois de validar PT e EN num ambiente de testes.

## Testes recomendados
1. Verifique os idiomas em ecrãs grandes e pequenos.
2. Faça orçamento de ida e de ida e volta e valide as datas.
3. Teste o seletor de passageiros e o assunto, ambos personalizados.
4. Confira as mensagens do WhatsApp em PT e EN.
5. Verifique menu, âncoras, FAQ, voltar ao topo e imagens.

NOTA: verificação sintática PHP e JavaScript concluída, mas sem ensaio completo no browser do seu alojamento. Não substitua a versão de produção antes de testar.
