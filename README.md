# AVV Travel — Site Institucional

Site institucional da **AVV Travel**, empresa de transporte e viagens sediada em Arcos de Valdevez, Portugal.

Apresentação da empresa, dos serviços e dos canais de contato para pedidos de orçamento.

🌐 **Site:** https://www.avvtravel.com/
📦 **Repositório:** https://github.com/djgregui/Avv-Site

## Prévia do site

![Prévia do site AVV Travel — 1](img/print1.png)
<br><br>
![Prévia do site AVV Travel — 2](img/print2.png)
<br><br>
![Prévia do site AVV Travel — 3](img/print3.png)
<br><br>
![Prévia do site AVV Travel — 4](img/print4.png)
<br><br>
![Prévia do site AVV Travel — 5](img/print5.png)
<br><br>

## Sobre a AVV

A AVV oferece soluções de mobilidade para deslocamentos particulares, profissionais e viagens em grupo, com foco no conforto, segurança e pontualidade.

### Serviços

- **Gold Service:** transporte executivo com motorista.
- **Transfers:** deslocamentos entre aeroportos, hotéis e outros destinos.
- **Autocarros:** transporte de grupos e percursos turísticos.
- **Agência de Viagens:** apoio no planejamento e contratação de viagens.

## Tecnologias

- PHP
- HTML
- CSS
- JavaScript

## Estrutura do projeto

| Caminho | Conteúdo |
|---|---|
| `index.php` | Página principal |
| `assets/css/site.css` | Estilos do site |
| `assets/js/site.js` | Scripts do site |
| `img/` | Imagens, logotipo e galeria |
| `lang/` | Arquivos de idiomas |
| `config.php` | Configuração privada, fora do Git |
| `.gitignore` | Regras de exclusão do versionamento |
| `LEIA-ME.md` | Documentação complementar |

## Executar o projeto

O site precisa de um ambiente com PHP. Abrir o arquivo
`index.php` diretamente no navegador não executa o código PHP.

1. Baixe ou clone o repositório.
2. Configure o arquivo `config.php` com os parâmetros exigidos pelo projeto.
3. Disponibilize a pasta em um servidor com suporte a PHP.

O `config.php` não acompanha o repositório. Sua configuração
deve ser obtida com o responsável pelo projeto.

## Atualizações pelo VS Code

1. Salve e revise os arquivos alterados.
2. Abra o painel **Controle do Código-Fonte**.
3. Prepare as alterações usando o botão **+**.
4. Escreva uma mensagem explicando a atualização.
5. Clique em **Commit**.
6. Use **Sincronizar Alterações** para enviar ao GitHub.

Se houver alterações feitas diretamente no GitHub, elas
precisarão ser integradas à cópia de trabalho.

## Versionamento

O primeiro commit foi identificado como **Site Avv V1**.

As atualizações ficam registradas no histórico de commits.
Tags e releases podem ser usadas para identificar versões
importantes.

## Configurações privadas

O arquivo `config.php`, arquivos `.env` e logs são ignorados
pelo Git conforme as regras do `.gitignore`.

Não inclua senhas, tokens ou credenciais nos arquivos versionados.

## Publicação

O envio de commits ao GitHub registra e compartilha o código.
A publicação no servidor depende do processo de implantação
configurado.

Ao editar diretamente a pasta usada pelo site em produção,
salvar os arquivos pode alterar imediatamente o site no ar,
mesmo antes de criar um commit.

## Responsável pelo projeto

**Guilherme Gregório**