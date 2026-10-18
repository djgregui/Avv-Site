/* ==========================================================================
   AVV TRAVEL — INTERAÇÕES DO SITE
   ==========================================================================
   Dependências: variáveis AVV_LANG, AVV_I18N, AVV_WHATSAPP e função avvT,
   definidas no index.php ANTES de carregar este ficheiro.

   Áreas: viagem ida/volta, navbar, animações, FAQ, formulários WhatsApp,
   botão para o topo e seletores personalizados de passageiros e assunto.

   Os IDs e valores internos foram preservados.
   ========================================================================== */

/* ===============================================
   AVV - SELETOR DE VIAGEM COM REGRESSO DINÂMICO
   =============================================== */

const tripOptions = document.querySelectorAll('.trip-option');
const tripTypeInput = document.getElementById('tripType');
const returnFields = document.getElementById('returnFields');
const returnDateInput = document.getElementById('returnDate');
const returnTimeInput = document.getElementById('returnTime');
const departureInput = document.getElementById('departure');

function updateTripMode(mode) {
    const roundTrip = mode === 'roundtrip';

    tripTypeInput.value = roundTrip ? 'Ida e volta' : 'Só ida';

    tripOptions.forEach(button => {
        const selected = button.dataset.trip === mode;
        button.classList.toggle('active', selected);
        button.setAttribute('aria-pressed', String(selected));
    });

    returnFields.hidden = !roundTrip;

    returnDateInput.disabled = !roundTrip;
    returnTimeInput.disabled = !roundTrip;
    returnDateInput.required = roundTrip;
    returnTimeInput.required = roundTrip;

   if (!roundTrip) {
      returnDateInput.value = '';
      returnTimeInput.value = '';

      returnDateInput.setCustomValidity('');
      returnTimeInput.setCustomValidity('');
   }
}

tripOptions.forEach(button => {
    button.addEventListener('click', () => {
        updateTripMode(button.dataset.trip);
    });
});

departureInput.addEventListener('change', () => {
    returnDateInput.min = departureInput.value;

    if (returnDateInput.value &&
        returnDateInput.value < departureInput.value) {
        returnDateInput.value = '';
    }
});

updateTripMode('oneway');


/* ==========================================================================
   COMPORTAMENTO DA PÁGINA
   ========================================================================== */

/* Navbar: fica sólida ao dar scroll + barra de progresso no topo */
const nav=document.getElementById('nav'), progress=document.getElementById('progress'), cursor=document.getElementById('cursor');
addEventListener('scroll',()=>{nav.classList.toggle('scrolled',scrollY>40);progress.style.width=(scrollY/(document.body.scrollHeight-innerHeight)*100)+'%'});

/* Cursor personalizado que segue o rato e cresce sobre links/botões */
addEventListener('mousemove',e=>{cursor.style.left=e.clientX+'px';cursor.style.top=e.clientY+'px'});
document.querySelectorAll('a,button').forEach(el=>{el.addEventListener('mouseenter',()=>cursor.classList.add('big'));el.addEventListener('mouseleave',()=>cursor.classList.remove('big'))});

/* Abre/fecha o menu de ecrã inteiro */
const menu=document.getElementById('menu'),menuBtn=document.getElementById('menuBtn');
menuBtn.onclick=()=>menu.classList.toggle('open');
document.querySelectorAll('.menu-links a').forEach(a=>a.onclick=()=>menu.classList.remove('open'));

/* Animação de entrada (fade+subida) quando os elementos .reveal entram no ecrã */
const obs=new IntersectionObserver(es=>es.forEach(e=>{if(e.isIntersecting)e.target.classList.add('show')}),{threshold:.12});
document.querySelectorAll('.reveal').forEach(x=>obs.observe(x));

/* Abre/fecha cada pergunta do FAQ */
document.querySelectorAll('.faq-q').forEach(q=>q.onclick=()=>q.parentElement.classList.toggle('open'));

/* Orçamento enviado pelo WhatsApp (não cria registos no servidor). */

/* ==========================================
   AVV TRAVEL - ORÇAMENTOS VIA WHATSAPP
   ========================================== */

const bookingForm = document.getElementById('booking');

// Data local de hoje, no formato YYYY-MM-DD
function getTodayLocal() {
    const now = new Date();

    const year = now.getFullYear();
    const month = String(now.getMonth() + 1).padStart(2, '0');
    const day = String(now.getDate()).padStart(2, '0');

    return `${year}-${month}-${day}`;
}

// Formatar data para português
function formatBookingDate(value) {
    if (!value) return avvT("Não indicada");

    const [year, month, day] = value.split('-');

    return `${day}/${month}/${year}`;
}

// Impedir datas anteriores a hoje
departureInput.min = getTodayLocal();

// Atualizar limite do regresso
returnDateInput.min = departureInput.value || getTodayLocal();

// Verificar datas e horários
function validateBookingDates() {
    const today = getTodayLocal();
    const departureTime = document.getElementById('departureTime');

    if (departureInput.value < today) {
        departureInput.setCustomValidity(
            avvT("A data da partida não pode ser anterior a hoje.")
        );
        departureInput.reportValidity();
        return false;
    }

    departureInput.setCustomValidity('');

    // Se a partida for hoje, não permitir horas passadas
    if (departureInput.value === today) {
        const now = new Date();
        const currentTime =
            String(now.getHours()).padStart(2, '0') + ':' +
            String(now.getMinutes()).padStart(2, '0');

        if (departureTime.value < currentTime) {
            departureTime.setCustomValidity(
                avvT("Escolha uma hora futura para a partida.")
            );
            departureTime.reportValidity();
            return false;
        }
    }

    departureTime.setCustomValidity('');

    if (tripTypeInput.value === 'Ida e volta') {
        if (returnDateInput.value < departureInput.value) {
            returnDateInput.setCustomValidity(
                avvT("O regresso não pode ser anterior à partida.")
            );
            returnDateInput.reportValidity();
            return false;
        }

        returnDateInput.setCustomValidity('');

        const returnTime = document.getElementById('returnTime');

        if (
            returnDateInput.value === departureInput.value &&
            returnTime.value <= departureTime.value
        ) {
            returnTime.setCustomValidity(
                avvT("O regresso deve ser posterior à partida.")
            );
            returnTime.reportValidity();
            return false;
        }

        returnTime.setCustomValidity('');
    }

    return true;
}

// Limpar mensagens de validação ao editar
[
    departureInput,
    document.getElementById('departureTime'),
    returnDateInput,
    returnTimeInput
].forEach(input => {
    input.addEventListener('input', () => {
        input.setCustomValidity('');
    });
});

// Preparar pedido de orçamento
bookingForm.addEventListener('submit', function(event) {
    event.preventDefault();

    if (!bookingForm.reportValidity()) return;
    if (!validateBookingDates()) return;

    const origin = document.getElementById('from').value.trim();
    const destination = document.getElementById('to').value.trim();
    const passengers = document.getElementById('passengers').value;
    const departureTime =
        document.getElementById('departureTime').value;

    const lines = [
        avvT("*PEDIDO DE ORÇAMENTO - AVV TRAVEL*"),
        '',
        `${avvT("*Tipo de viagem:*")} ${avvT(tripTypeInput.value)}`,
        `${avvT("*Origem:*")} ${origin}`,
        `${avvT("*Destino:*")} ${destination}`,
        `${avvT("*Passageiros:*")} ${passengers}`,
        `*------------*`,
        `${avvT("*Partida:*")} ${formatBookingDate(departureInput.value)}`,
        `${avvT("*Hora da partida:*")} ${departureTime}`
    ];

    // Só acrescentar regresso quando escolhido
    if (tripTypeInput.value === 'Ida e volta') {
        lines.push(
            `*------------*`,
            `${avvT("*Regresso:*")} ${formatBookingDate(returnDateInput.value)}`,
            `${avvT("*Hora do regresso:*")} ${returnTimeInput.value}`
        );
    }

    lines.push(
        '',
        avvT("Gostaria de receber um orçamento para esta viagem."),
        avvT("Obrigado!")
    );

    const message = lines.join('\n');

    const url =
        `https://wa.me/${AVV_WHATSAPP}?text=${encodeURIComponent(message)}`;

    // Abrir WhatsApp na mesma aba, evitando bloqueios de pop-up
    window.open(url, '_blank', 'noopener,noreferrer');
});


/* ==========================================
   AVV TRAVEL — CONTACTO VIA WHATSAPP
   ========================================== */

const contactForm = document.getElementById('contactForm');

contactForm.addEventListener('submit', function(event) {
    event.preventDefault();

    // Validar os campos obrigatórios
    if (!contactForm.reportValidity()) return;

    // Recolher os dados
    const nome = document.getElementById('contactName').value.trim();
    const email = document.getElementById('contactEmail').value.trim();
    const assunto = document.getElementById('contactSubject').value;
    const mensagem = document.getElementById('contactMessage').value.trim();

    // Impedir mensagens só com espaços
    if (!nome || !mensagem) {
        alert(avvT("Por favor, preencha o nome e a mensagem."));
        return;
    }

    // Construir a mensagem
    const texto = [
        avvT("*CONTACTO PELO SITE - AVV TRAVEL*"),
        '',
        `${avvT("*Nome:*")} ${nome}`,
        `${avvT("*E-mail:*")} ${email}`,
        `${avvT("*Assunto:*")} ${avvT(assunto)}`,
        '',
        avvT("*Mensagem:*"),
        mensagem,
        '',
        avvT("Enviado através do formulário de contacto do site.")
    ].join('\n');

    // Utilizar a constante existente do formulário de orçamento
    const url = `https://wa.me/${AVV_WHATSAPP}?text=${encodeURIComponent(texto)}`;

    // Abrir o WhatsApp numa nova guia
    window.open(url, '_blank', 'noopener,noreferrer');
});

/* ==========================================
   AVV — VOLTAR AO TOPO
   ========================================== */

const backToTop = document.getElementById('backToTop');

// Mostrar quando ultrapassar metade da página
function updateBackToTop() {
    const alturaPagina =
        document.documentElement.scrollHeight - window.innerHeight;

    const limite = alturaPagina * 0.15;

    const mostrar = alturaPagina > 0 && window.scrollY >= limite;

    backToTop.classList.toggle('visible', mostrar);
}

// Verificar durante o scroll
window.addEventListener('scroll', updateBackToTop, { passive: true });
window.addEventListener('resize', updateBackToTop);

// Verificar ao abrir a página
updateBackToTop();

// Voltar ao início
backToTop.addEventListener('click', function() {
    window.scrollTo({
        top: 0,
        behavior: window.matchMedia('(prefers-reduced-motion: reduce)').matches
            ? 'instant'
            : 'smooth'
    });
});


/* ==========================================
   AVV — SELECT PERSONALIZADO DE PASSAGEIROS
   ========================================== */

(function () {
    const select = document.getElementById('passengers');
    if (!select) return;

    const field = select.closest('.field');
    if (!field) return;

    field.classList.add('avv-select-field');
    select.classList.add('avv-native-select');

    const trigger = document.createElement('button');
    trigger.type = 'button';
    trigger.className = 'avv-select-trigger';
    trigger.setAttribute('aria-haspopup', 'listbox');
    trigger.setAttribute('aria-expanded', 'false');
    trigger.setAttribute('aria-label', 'Selecionar passageiros');

    const selectedText = document.createElement('span');
    const arrow = document.createElement('span');
    arrow.className = 'avv-chevron';
    arrow.setAttribute('aria-hidden', 'true');

    trigger.append(selectedText, arrow);

    const menu = document.createElement('div');
    menu.className = 'avv-select-menu';
    menu.setAttribute('role', 'listbox');
    menu.setAttribute('aria-label', 'Número de passageiros');

    const buttons = [];

    function closeMenu() {
        field.classList.remove('avv-open');
        trigger.setAttribute('aria-expanded', 'false');
        buttons.forEach(button => button.tabIndex = -1);
    }

    function openMenu() {
        field.classList.add('avv-open');
        trigger.setAttribute('aria-expanded', 'true');
        const current = buttons.find(b => b.dataset.value === select.value);
        if (current) {
            current.tabIndex = 0;
            current.focus();
        }
    }

    function syncSelection() {
        selectedText.textContent = select.value;

        buttons.forEach(button => {
            const active = button.dataset.value === select.value;
            button.classList.toggle('selected', active);
            button.setAttribute('aria-selected', String(active));
        });
    }

    Array.from(select.options).forEach((option, index) => {
        const button = document.createElement('button');
        button.type = 'button';
        button.className = 'avv-select-option';
        button.textContent = option.value === '5+' ? avvT("5+ passageiros")
            : option.value === '1' ? avvT("1 passageiro")
            : option.value + ' ' + avvT('passageiros');

        button.dataset.value = option.value;
        button.setAttribute('role', 'option');
        button.tabIndex = -1;

        function choose() {
            select.value = option.value;
            select.dispatchEvent(new Event('change', { bubbles: true }));
            syncSelection();
            closeMenu();
            trigger.focus();
        }

        button.addEventListener('click', choose);

        button.addEventListener('keydown', event => {
            if (event.key === 'ArrowDown' || event.key === 'ArrowUp') {
                event.preventDefault();
                const direction = event.key === 'ArrowDown' ? 1 : -1;
                const next = (index + direction + buttons.length) % buttons.length;
                buttons[next].tabIndex = 0;
                buttons[next].focus();
                button.tabIndex = -1;
            }

            if (event.key === 'Escape') {
                event.preventDefault();
                closeMenu();
                trigger.focus();
            }
        });

        menu.appendChild(button);
        buttons.push(button);
    });

    field.append(trigger, menu);

    trigger.addEventListener('click', () => {
        field.classList.contains('avv-open') ? closeMenu() : openMenu();
    });

    trigger.addEventListener('keydown', event => {
        if (['ArrowDown', 'ArrowUp', 'Enter', ' '].includes(event.key)) {
            event.preventDefault();
            openMenu();
        }
    });

    document.addEventListener('click', event => {
        if (!field.contains(event.target)) closeMenu();
    });

    field.addEventListener('focusout', event => {
        if (!field.contains(event.relatedTarget)) closeMenu();
    });

    select.addEventListener('change', syncSelection);

    syncSelection();
})();


/* ==========================================
   AVV — SELECT PERSONALIZADO DE ASSUNTO
   ========================================== */

(function () {
    const select = document.getElementById('contactSubject');
    if (!select) return;

    const field = select.closest('.contact-field');
    if (!field) return;

    field.classList.add('avv-select-field');
    select.classList.add('avv-native-select');

    const trigger = document.createElement('button');
    trigger.type = 'button';
    trigger.className = 'avv-select-trigger';
    trigger.setAttribute('aria-haspopup', 'listbox');
    trigger.setAttribute('aria-expanded', 'false');
    trigger.setAttribute('aria-label', 'Selecionar assunto');

    const selectedText = document.createElement('span');
    const arrow = document.createElement('span');
    arrow.className = 'avv-chevron';
    arrow.setAttribute('aria-hidden', 'true');

    trigger.append(selectedText, arrow);

    const menu = document.createElement('div');
    menu.className = 'avv-select-menu';
    menu.setAttribute('role', 'listbox');
    menu.setAttribute('aria-label', 'Assunto da mensagem');

    const buttons = [];

    function closeMenu() {
        field.classList.remove('avv-open');
        trigger.setAttribute('aria-expanded', 'false');
        buttons.forEach(button => button.tabIndex = -1);
    }

    function openMenu() {
        field.classList.add('avv-open');
        trigger.setAttribute('aria-expanded', 'true');

        const current = buttons.find(
            button => button.dataset.value === select.value
        ) || buttons[0];

        current.tabIndex = 0;
        current.focus();
    }

    function syncSelection() {
        const selectedOption = select.options[select.selectedIndex];

        selectedText.textContent = selectedOption
            ? selectedOption.textContent
            : 'Selecione um assunto';

        buttons.forEach(button => {
            const active = button.dataset.value === select.value;
            button.classList.toggle('selected', active);
            button.setAttribute('aria-selected', String(active));
        });
    }

    Array.from(select.options).forEach((option, index) => {
        const button = document.createElement('button');
        button.type = 'button';
        button.className = 'avv-select-option';
        button.textContent = option.textContent;
        button.dataset.value = option.value;
        button.setAttribute('role', 'option');
        button.tabIndex = -1;

        function choose() {
            select.value = option.value;
            select.dispatchEvent(new Event('change', {
                bubbles: true
            }));

            syncSelection();
            closeMenu();
            trigger.focus();
        }

        button.addEventListener('click', choose);

        button.addEventListener('keydown', event => {
            if (event.key === 'ArrowDown' ||
                event.key === 'ArrowUp') {

                event.preventDefault();

                const direction =
                    event.key === 'ArrowDown' ? 1 : -1;

                const next =
                    (index + direction + buttons.length)
                    % buttons.length;

                buttons[next].tabIndex = 0;
                buttons[next].focus();
                button.tabIndex = -1;
            }

            if (event.key === 'Escape') {
                event.preventDefault();
                closeMenu();
                trigger.focus();
            }
        });

        menu.appendChild(button);
        buttons.push(button);
    });

    field.append(trigger, menu);

    trigger.addEventListener('click', () => {
        field.classList.contains('avv-open')
            ? closeMenu()
            : openMenu();
    });

    trigger.addEventListener('keydown', event => {
        if (['ArrowDown', 'ArrowUp', 'Enter', ' '].includes(event.key)) {
            event.preventDefault();
            openMenu();
        }
    });

    document.addEventListener('click', event => {
        if (!field.contains(event.target)) closeMenu();
    });

    field.addEventListener('focusout', event => {
        if (!field.contains(event.relatedTarget)) closeMenu();
    });

    select.addEventListener('change', syncSelection);

    syncSelection();
})();
