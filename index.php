<?php
// Configurações, contactos e traduções mantidos fora desta página.
require_once __DIR__ . "/config.php";
// IDIOMA PADRÃO: mudar "pt" para "en" na expressão abaixo, se desejado.
$lang = ($_GET["lang"] ?? "pt") === "en" ? "en" : "pt";
$t = require __DIR__ . "/lang/{$lang}.php";
$js_translations = $lang === "en" ? require __DIR__ . "/lang/js.php" : [];
function avv_text($key) { global $t; return htmlspecialchars($t[$key] ?? $key, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8"); }
?>
<!DOCTYPE html>
<html lang="<?= $lang === "en" ? "en" : "pt-PT" ?>">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="theme-color" content="#0b0b0b">
    <link rel="shortcut icon" href="img/logo/logo_avv.png" type="img/png">
    <title><?= $lang === "en" ? "AVV - Executive Transport & Travel" : "AVV - Transportes Executivo & Viagens" ?></title>
    <link rel="stylesheet" href="assets/css/site.css">
  </head>
  <body>
        <!-- AVV — VOLTAR AO TOPO -->
    <button id="backToTop" class="back-to-top"
            type="button"
            aria-label="<?= avv_text("voltar_ao_topo_da_pagina") ?>"
            title="<?= avv_text("voltar_ao_topo") ?>">
        ↑
    </button>

    <!-- Barra de progresso do scroll + cursor personalizado (só desktop) -->
    <div class="progress" id="progress"></div><div class="cursor" id="cursor"></div>

    <!-- ==========================================================================
        NAVBAR — logótipo AVV + menu de secções + botão de menu geral
        ========================================================================== -->
    <header class="nav" id="nav" style="margin:0; padding:0">
        <div class="container nav-inner">
        <a class="logo" href="#">
            <img src="https://www.avvtravel.com/img/logo/logo_avv.png"  style="height:50px !important; margin:0; p+adding:0; padding-bottom: 04px; padding-top: 10px" alt="AVV Travel"></a>
            <nav class="nav-center">
                <a href="#servicos"><?= avv_text("servicos") ?></a>
                <a href="#experiencia"><?= avv_text("como_funciona") ?></a>
                <a href="#frota"><?= avv_text("frota") ?></a>
                <a href="#reservar"><?= avv_text("reservar") ?></a>
                <a href="#contato"><?= avv_text("contato") ?></a>
                <a href="#faq">FAQ</a></nav>
        <div class="nav-right"><nav class="avv-lang" aria-label="Language"><a href="?lang=pt" hreflang="pt" class="<?= $lang === 'pt' ? 'is-active' : '' ?>">PT</a><span aria-hidden="true">/</span><a href="?lang=en" hreflang="en" class="<?= $lang === 'en' ? 'is-active' : '' ?>">EN</a></nav><button class="menu-btn" id="menuBtn"><?= avv_text("menu") ?> <i class="menu-icon"><i></i><i></i></i></button></div>
        </div>
    </header>

    <!-- Menu de ecrã inteiro (abre ao clicar em "Menu") -->
    <div class="menu-overlay" id="menu">
    <div class="container menu-grid">
    <nav class="menu-links"><a href="#reservar"><?= avv_text("reservar") ?></a><a href="#servicos"><?= avv_text("servicos") ?></a><a href="#experiencia"><?= avv_text("como_funciona") ?></a><a href="#frota"><?= avv_text("frota") ?></a><a href="#faq"><?= avv_text("ajuda") ?></a></nav>
    <div class="menu-info"><strong><?= avv_text("especialistas_em_mobilidade_e_transporte") ?></strong><?= avv_text("transporte_executivo_transfers_de_aeroporto") ?><br><br><?=$cidade?>, Portugal.</div>
    </div></div>

    <!-- ==========================================================================
        HERO — vídeo de fundo + título principal
        TROCAR: vídeo (fonte do <source>), poster, e o texto do <h1>
        ========================================================================== -->
    <section class="hero">
        <!-- IMAGEM DO HERO -->
        <div class="hero-image">
            <img src="img/car2escuro.png" alt="<?= avv_text("transporte_executivo") ?>">
        </div>
        <div class="hero-logo">
            <img src="https://www.avvtravel.com/img/logo/logo_avv.png" alt="AVV Travel">
        </div>
        <div class="container hero-copy">
            <div class="hero-kicker">
                <?= avv_text("transporte_executivo_transfers_autocarros_de") ?>
            </div>
            <h1 style="text-transform: uppercase;">
                <?= avv_text("chegue_ao_seu") ?> <br>
                <?= avv_text("destino") ?><br>
                <em><?= avv_text("sem_pensar_no") ?> <br>
                <?= avv_text("caminho") ?></em>
            </h1>
            <div class="hero-sub">
                <p>
                    <?= avv_text("transporte_privado_pontual_e_seguro_motorist") ?>
                </p>
                <!-- Estes números (700+/140/24-7) são fictícios do template original —
                    substitui pelos números reais da AVV -->
                <div class="hero-stats">
                    <div>
                        <b>PT</b>
                        <span><?= avv_text("cobertura_nacional") ?></span>
                    </div>
                    <div>
                        <b>2</b>
                        <span><?= avv_text("idiomas_por_motorista") ?></span>
                    </div>
                    <div>
                        <b>24/7</b>
                        <span><?= avv_text("suporte") ?></span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==========================================================================
        FORMULÁRIO DE RESERVA (flutua por cima do hero)
        ========================================================================== -->
    <section class="booking-shell" id="reservar">
      <div class="container">
            <form class="booking" id="booking">
                <div class="trip-switch">
                  <span><?= avv_text("viagem") ?></span>
                  <div class="trip-toggle" role="group" aria-label="Tipo de viagem">
                      <button type="button" class="trip-option active"
                              data-trip="oneway" aria-pressed="true">
                            <?= avv_text("so_ida") ?>
                      </button>
                      <button type="button" class="trip-option"
                              data-trip="roundtrip" aria-pressed="false">
                            <?= avv_text("ida_e_volta") ?>
                      </button>
                  </div>
                </div>
                <input type="hidden" id="tripType" value="Só ida">
                <div class="field">
                  <label for="from"><?= avv_text("de") ?></label>
                  <input id="from" required placeholder="<?= avv_text("aeroporto_ou_cidade") ?>">
                </div>
                <div class="field">
                  <label for="to"><?= avv_text("para") ?></label>
                  <input id="to" required placeholder="<?= avv_text("hotel_cidade_ou_endereco") ?>">
                </div>
                <div class="field">
                  <label for="departure"><?= avv_text("partida") ?></label>
                  <input id="departure" type="date" required>
                </div>

                <div class="field">
                  <label for="departureTime"><?= avv_text("hora") ?></label>
                  <input id="departureTime" type="time" required>
                </div>
                <div class="field">
                  <label for="passengers"><?= avv_text("pessoas") ?></label>
                  <select id="passengers" required>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="5+">5+</option>
                  </select>
                </div>
                <button class="book-btn" type="submit">
                  <?= avv_text("pedir_orcamento") ?>
                </button>
                <div class="return-fields" id="returnFields" hidden>
                  <div class="return-label"><?= avv_text("dados_do_regresso") ?></div>
                  <div class="field">
                      <label for="returnDate"><?= avv_text("data_do_regresso") ?></label>
                      <input id="returnDate" type="date" disabled>
                  </div>
                  <div class="field">
                      <label for="returnTime"><?= avv_text("hora_do_regresso") ?></label>
                      <input id="returnTime" type="time" disabled>
                  </div>
                </div>
            </form>
          <div class="booking-trust"><span><?= avv_text("preco_transparente") ?></span><span><?= avv_text("motorista_bilingue") ?></span><span><?= avv_text("frota_propria") ?></span><span><?= avv_text("suporte_24_7") ?></span></div>
      </div>
    </section>

    <!-- Faixa animada com palavras-chave -->
    <div class="marquee"><div class="track"><span><?= avv_text("transporte_executivo") ?></span><i>✦</i><span>Transfers</span><i>✦</i><span><?= avv_text("autocarros") ?></span><i>✦</i><span><?= avv_text("agencia_de_viagens") ?></span><i>✦</i><span><?= avv_text("transporte_executivo") ?></span><i>✦</i><span>Transfers</span><i>✦</i><span><?= avv_text("autocarros") ?></span><i>✦</i><span><?= avv_text("agencia_de_viagens") ?></span><i>✦</i></div></div>

    <!-- ==========================================================================
        SERVIÇOS — cartões com os 4 serviços reais da AVV
        (Gold Service, Transfers, Autocarros, Agência de Viagens)
        ========================================================================== -->
    <section class="section" id="servicos">
      <div class="container">
        <div class="head reveal">
          <div>
            <div class="eyebrow"><?= avv_text("os_nossos_servicos") ?></div>
            <h2><?= avv_text("especialistas_em") ?><br><?= avv_text("mobilidade_e_transporte") ?></h2>
          </div>
          <p class="desc"><?= avv_text("prestamos_o_melhor_servico_de_transporte_da") ?></p>
        </div>
        <div class="destinations">
          <a class="dest reveal" href="#goldservice">
            <div class="dest-bg" style="background-image: url('img/casal_viagem.jpg');"></div>
            <div class="dest-info">
              <small><?= avv_text("servico_premium") ?></small>
              <h3><?= avv_text("viver_portugal") ?></h3>
              <p><?= avv_text("conheca_novos_lugares_sem_se_preocupar_com_e") ?></p>
            </div>
          </a>
          <a class="dest reveal" href="#transfer">
            <div class="dest-bg" style="background-image:url('img/casal2.jpg');"></div>
            <div class="dest-info">
              <small><?= avv_text("aeroporto_cidade") ?></small>
              <h3><?= avv_text("viajar_juntos") ?></h3>
              <p><?= avv_text("familia_amigos_ou_empresas_todos_juntos_com") ?></p>
            </div>
          </a>
          <a class="dest reveal" href="#autocarro">
            <div class="dest-bg" style="background-image:url('img/empresa.jpg');"></div>
            <div class="dest-info">
              <small><?= avv_text("grupos") ?></small>
              <h3><?= avv_text("chegar_no_momento_certo") ?></h3>
              <p><?= avv_text("reunioes_congressos_e_compromissos_com_trans") ?></p>
            </div>
          </a>
          <a class="dest reveal" href="#">
            <div class="dest-bg" style="background-image:url('https://images.unsplash.com/photo-1509840841025-9088ba78a826?auto=format&fit=crop&w=1200&q=85')"></div>
            <div class="dest-info">
              <small><?= avv_text("viagens") ?></small>
              <h3><?= avv_text("agencia") ?></h3>
              <p><?= avv_text("apoio_na_analise_e_compra_das_suas_passagens") ?></p>
            </div>
          </a>
        </div>
      </div>
    </section>

    <!-- ==========================================================================
        "COMO FUNCIONA" — 4 passos (secção escura)
        ========================================================================== -->
    <section class="section dark" id="experiencia">
      <div class="container">
        <div class="head reveal">
          <div>
            <div class="eyebrow"><?= avv_text("como_funciona_2") ?></div>
            <h2><?= avv_text("o_seu_transporte_comeca_com_um_pedido_de_orc") ?></h2>
          </div>
          <p class="desc"><?= avv_text("simples_direto_e_acompanhado_do_inicio_ao_fi") ?></p>
        </div>
        <div class="process reveal">
          <div class="step">
            <div class="num"><?= avv_text("01_pedir") ?></div>
            <h3><?= avv_text("peca_o_orcamento") ?></h3>
            <p><?= avv_text("indique_origem_destino_data_hora_e_numero_de") ?></p>
          </div>
          <div class="step">
            <div class="num"><?= avv_text("02_confirmar") ?></div>
            <h3><?= avv_text("confirmamos_consigo") ?></h3>
            <p><?= avv_text("a_nossa_equipa_entra_em_contacto_para_confir") ?></p>
          </div>
          <div class="step">
            <div class="num"><?= avv_text("03_motorista") ?></div>
            <h3><?= avv_text("motorista_a_sua_espera") ?></h3>
            <p><?= avv_text("um_motorista_profissional_fluente_em_pelo_me") ?></p>
          </div>
          <div class="step">
            <div class="num"><?= avv_text("04_chegar") ?></div>
            <h3><?= avv_text("e_so_aproveitar") ?></h3>
            <p><?= avv_text("viagem_confortavel_segura_e_pontual_do_inici") ?></p>
          </div>
        </div> 
      </div>
    </section>
    <!-- ==========================================================================
        SOBRE NÓS — texto + vídeo/imagem + números
        ========================================================================== -->
    <section class="section" id="quemsomos">
      <div class="container split">
        <div class="visual reveal">
          <!-- FOTO -->
          <img src="img/car3.png" alt="<?= avv_text("transporte_executivo") ?>">
          <div class="stamp">
              <?= avv_text("conforto_seguranca_pontualidade") ?>
          </div>
        </div>
        <div class="reveal">
          <div class="eyebrow"><?= avv_text("quem_somos") ?></div>
          <div class="big-copy"><?= avv_text("especialistas_em") ?><br><em><?= avv_text("mobilidade_e_transporte") ?></em></div>
          <p class="desc" style="margin-top:25px"><?= avv_text("a_avv_presta_o_melhor_servico_de_transporte") ?></p>
          <div class="facts">
            <div class="fact"><strong>4</strong><span><?= avv_text("servicos_especializados") ?></span></div>
            <div class="fact"><strong>2+</strong><span><?= avv_text("idiomas_por_motorista_2") ?></span></div>
            <div class="fact"><strong>PT</strong><span><?= avv_text("base_em_arcos_de_valdevez") ?></span></div>
            <div class="fact"><strong>24/7</strong><span><?= avv_text("disponibilidade") ?></span></div>
          </div>
        </div>
      </div>
    </section>
    <!-- =========================================================
        CONTACTO — Formulário de mensagem
        ========================================================= -->
    <section class="section" id="contato">
      <div class="container">
        <div class="head reveal">
          <div>
            <div class="eyebrow"><?= avv_text("fale_connosco") ?></div>
            <h2><?= avv_text("vamos") ?><br><?= avv_text("conversar") ?></h2>
          </div>
          <p class="desc">
            <?= avv_text("tem_alguma_duvida_sugestao_ou_pedido_especia") ?>
          </p>
        </div>
        <div class="contact-layout">
          <!-- CONTACTOS -->
          <div class="contact-info reveal">
            <div class="contact-info-title">
              <?= avv_text("estamos_a_distancia") ?><br>
              <?= avv_text("de_uma_mensagem") ?>
            </div>
            <div class="contact-detail">
              <span><?= avv_text("telemovel") ?></span>
              <a href="tel:<?= preg_replace('/[^\d+]/', '', $telefone) ?>">
                <?= $telefone ?>
              </a>
                <span><?= avv_text("telefone") ?></span>
              <a href="tel:<?= preg_replace('/[^\d+]/', '', $telefone_fixo) ?>">
                <?= $telefone_fixo ?>
              </a>
            </div>
            <div class="contact-detail">
              <span>E-MAIL</span>
              <a href="mailto:<?= $email ?>">
                <?= $email ?>
              </a>
            </div>
            <div class="contact-detail">
              <span><?= avv_text("localizacao") ?></span>
              <p><?= $cidade ?>, Portugal</p>
            </div>
          </div>
          <form class="contact-form reveal" id="contactForm">
            <div class="contact-fields">
              <div class="contact-field">
                <label for="contactName"><?= avv_text("nome") ?></label>
                <input id="contactName"
                      type="text"
                      placeholder="<?= avv_text("o_seu_nome") ?>"
                      required>
              </div>
              <div class="contact-field">
                <label for="contactEmail"><?= avv_text("e_mail") ?></label>
                <input id="contactEmail"
                      type="email"
                      placeholder="<?= avv_text("o_seu_e_mail") ?>"
                      required>
              </div>
              <div class="contact-field contact-full">
                <label for="contactSubject"><?= avv_text("assunto") ?></label>
                <select id="contactSubject" required>
                  <option value=""><?= avv_text("selecione_um_assunto") ?></option>
                  <option value="Informações gerais"><?= avv_text("informacoes_gerais") ?></option>
                  <option value="Transportes e serviços"><?= avv_text("transportes_e_servicos") ?></option>
                  <option value="Parcerias"><?= avv_text("parcerias") ?></option>
                  <option value="Outro assunto"><?= avv_text("outro_assunto") ?></option>
                </select>
              </div>
              <div class="contact-field contact-full">
                <label for="contactMessage"><?= avv_text("mensagem") ?></label>
                <textarea id="contactMessage"
                          rows="6"
                          placeholder="<?= avv_text("como_podemos_ajudar") ?>"
                          required></textarea>
              </div>
            </div>
            <button type="submit" class="contact-submit">
              <?= avv_text("enviar_mensagem") ?> <span>→</span>
            </button>
            <p class="contact-note">
              <?= avv_text("ao_continuar_sera_encaminhado_para_o_whatsap") ?>
            </p>
          </form>
        </div>
      </div>
    </section>
    <!-- ==========================================================================
        FROTA — tipos de veículo
        ========================================================================== -->
    <section class="section dark" id="frota">
      <div class="container">
        <div class="head reveal">
          <div>
            <div class="eyebrow"><?= avv_text("a_frota") ?></div>
            <h2><?= avv_text("o_tamanho_certo") ?><br><?= avv_text("para_a_sua_viagem") ?></h2>
          </div>
          <p class="desc"><?= avv_text("escolha_de_acordo_com_passageiros_e_bagagem") ?></p>
        </div>
        <div class="fleet">
        <article class="car reveal">
          <div class="car-art">
            <img src="img/car1.jpg" alt="Sedan AVV Travel">
          </div>
          <h3>Gold Service</h3>
          <p><?= avv_text("para_viagens_a_dois_pequenas_familias_ou_que") ?></p>
          <div class="car-meta">
            <span><b>1–3</b> <?= avv_text("passageiros") ?></span>
            <span><b>3</b> <?= avv_text("malas") ?></span>
          </div>
        </article>
        <article class="car reveal">
          <div class="car-art">
            <img src="img/avv2.jpg" alt="Van AVV Travel" style="object-position:center 75%"></div>
            <h3>Transfer</h3>
            <p><?= avv_text("mais_espaco_para_familias_e_grupos_com_mais") ?></p>
            <div class="car-meta">
              <span><b>4–7</b> <?= avv_text("passageiros") ?></span>
              <span><b>7</b> <?= avv_text("malas") ?></span>
            </div>
          </article>
        <article class="car reveal">
          <div class="car-art">
            <img src="img/galeria/imagem_8.jpg" alt="Autocarro AVV Travel" style="object-position:center 25%"></div>
            <h3><?= avv_text("autocarro") ?></h3>
            <p><?= avv_text("para_grupos_maiores_percursos_turisticos_por") ?></p>
            <div class="car-meta"><span><b>8+</b> <?= avv_text("passageiros") ?></span>
            <span><b><?= avv_text("grupo") ?></b> <?= avv_text("bagagem") ?></span>
          </div>
        </article>
        </div>
      </div>
    </section>
    <!-- ==========================================================================
        TESTEMUNH
        ========================================================================== -->
    <section class="section">
      <div class="container review-grid">
        <div class="reveal">
          <div class="eyebrow"><?= avv_text("o_que_dizem") ?></div>
          <div class="quote"><?= avv_text("reserva_facil_otima_comunicacao") ?> <em><?= avv_text("sempre_a_horas") ?></em>”</div>
        </div>
        <div class="review-side reveal">
          <strong>AVV</strong>
          <p><?= avv_text("espaco_reservado_para_uma_citacao_real_de_um") ?></p>
        </div>
      </div>
    </section>
    <!-- ==========================================================================
        FAQ — acordeão. Conteúdo genérico, ajustar conforme processos da AVV
        ========================================================================== -->
    <section class="section" id="faq">
      <div class="container">
        <div class="head reveal">
          <div>
            <div class="eyebrow"><?= avv_text("ajuda") ?></div>
            <h2><?= avv_text("tudo_claro_antes_de_partir") ?></h2>
          </div>
          <p class="desc"><?= avv_text("as_respostas_essenciais_sobre_reserva_chegad") ?></p>
        </div>
        <div class="faq reveal">
          <div class="faq-item">
            <button class="faq-q"><?= avv_text("como_encontro_o_meu_motorista") ?>
              <span class="plus">+</span>
            </button>
            <div class="faq-a"><?= avv_text("apos_a_confirmacao_da_reserva_recebera_as_in") ?></div>
          </div>
          <div class="faq-item">
            <button class="faq-q"><?= avv_text("e_se_o_meu_voo_estiver_atrasado") ?>
              <span class="plus">+</span>
            </button>
            <div class="faq-a"><?= avv_text("ao_fornecer_o_numero_do_voo_a_nossa_equipa_p") ?></div>
          </div>
          <div class="faq-item">
            <button class="faq-q"><?= avv_text("o_que_esta_incluido_no_preco") ?>
              <span class="plus">+</span>
            </button>
            <div class="faq-a"><?= avv_text("o_orcamento_e_enviado_apos_o_pedido_com_toda") ?></div>
          </div>
          <div class="faq-item">
            <button class="faq-q"><?= avv_text("como_posso_pagar") ?>
              <span class="plus">+</span>
            </button>
            <div class="faq-a"><?= avv_text("entre_em_contacto_com_a_nossa_equipa_para_co") ?></div>
          </div>
          <div class="faq-item">
            <button class="faq-q"><?= avv_text("posso_levar_equipamento_especial") ?>
              <span class="plus">+</span>
            </button>
            <div class="faq-a"><?= avv_text("quando_disponivel_pode_solicitar_cadeiras_de") ?></div>
          </div>
        </div>
      </div>
    </section>
    <!-- CTA final (faixa amarela) -->
    <section class="cta">
      <div class="container cta-inner">
        <div>
          <div class="eyebrow"><?= avv_text("a_sua_viagem_comeca_aqui") ?></div>
          <h2><?= avv_text("peca_ja_o_seu_orcamento") ?></h2>
        </div>
        <a class="cta-btn" href="#reservar"><?= avv_text("pedir_orcamento") ?></a>
      </div>
    </section>
    <!-- ==========================================================================
        RODAPÉ — dados reais da AVV (morada, telefones, redes sociais, licenças)
        ========================================================================== -->
    <footer class="footer">
      <div class="container">
        <div class="footer-grid">
          <div>
            <div class="footer-logo">avv<span style="font-size:22px">travel</span>
                </div><p style="max-width:300px"><?= avv_text("transporte_executivo_transfers_autocarros_e") ?></p>
                <p><?=$morada?><br><?=$codigo_postal?> <?=$cidade?></p>
                <p><?=$telefone_fixo?><br><?=$telefone?></p>
                </div>
                <div>
                    <h4><?= avv_text("explorar") ?></h4>
                    <a href="#servicos"><?= avv_text("servicos") ?></a>
                    <a href="#experiencia"><?= avv_text("como_funciona") ?></a>
                    <a href="#frota"><?= avv_text("frota") ?></a>
                    <a href="#faq"><?= avv_text("ajuda") ?></a>
                </div>
                <div>
                    <h4>AVV</h4>
                    <a href="#quemsomos"><?= avv_text("quem_somos_2") ?></a>
                    <a href="#contato"><?= avv_text("contacto") ?></a>
                </div>
                <div>
                    <h4><?= avv_text("siga_nos") ?></h4><a href="<?=$facebook?>" target="_blank" rel="noopener">Facebook</a>
                    <a href="<?=$instagram?>" target="_blank" rel="noopener">Instagram</a>
                </div>
            </div>
            <div class="bottom">
                <span>© 2026 AVV Travel</span>
                <span>RNAVT Mº6641 · RNAAT Nº1663/2016</span>
            </div>
        </div>
          <!-- ==========================================
            ASSINATURA
          ========================================== -->
        <style>
          .developer-credit {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            margin: 0;
            padding: 16px 20px;
            background-color: #090909;
            border-top: 1px solid #222;
            box-sizing: border-box;
            text-align: center;
          }
          .developer-credit,
          .developer-credit * {
            font-family: Arial, sans-serif;
            box-sizing: border-box;
          }
          .developer-credit span {
            color: #888;
            font-size: 15px;
            font-weight: 400;
            letter-spacing: .04em;
            line-height: 1.6;
          }
          .developer-credit a {
            display: inline;
            color: #bbb;
            font-size: inherit;
            text-decoration: none;
            transition: color .3s ease;
          }
          .developer-credit a:hover {
            color: #c9a227;
          }
        </style>
        <div class="developer-credit">
            <span>
                Produzido por
                <a href="https://www.guilhermegregorio.com/"
                  target="_blank"
                  rel="noopener noreferrer">
                    Guilherme Gregório
                </a>
                © 2026
            </span>
        </div>
    </footer>
    <script>
      // Traduções e contactos fornecidos pelo PHP antes do JavaScript do site.
      const AVV_LANG = <?= json_encode($lang) ?>;
      const AVV_I18N = <?= json_encode($js_translations, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;
      const AVV_WHATSAPP = <?= json_encode($whatsapp) ?>;
      const avvT = text => AVV_I18N[text] || text;
    </script>
    <script src="assets/js/site.js"></script>
  </body>
</html>