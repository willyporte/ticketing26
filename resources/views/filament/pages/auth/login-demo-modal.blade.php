<script>
(function () {
    const KEY = 'ticketflow_demo_popup_last_shown';

    function shouldShow() {
        const last = localStorage.getItem(KEY);
        return !last || (Date.now() - parseInt(last)) > 86400000;
    }

    function buildModal() {
        const overlay = document.createElement('div');
        overlay.id = 'demo-modal-overlay';
        overlay.style.cssText = [
            'position:fixed', 'top:0', 'left:0', 'width:100%', 'height:100%',
            'z-index:99999', 'display:flex', 'align-items:center', 'justify-content:center',
            'background:rgba(0,0,0,0.65)', 'backdrop-filter:blur(4px)',
            '-webkit-backdrop-filter:blur(4px)',
            'opacity:0', 'transition:opacity 0.3s ease',
        ].join(';');

        overlay.innerHTML = `
            <div id="demo-modal-card" style="
                position:relative;
                background:#fff;
                border-radius:1.5rem;
                box-shadow:0 25px 60px rgba(0,0,0,0.3);
                max-width:26rem;
                width:calc(100% - 2.5rem);
                padding:2rem 2rem 1.75rem;
                text-align:center;
                transform:scale(0.95);
                transition:transform 0.3s ease;
            ">
                <div style="display:flex;justify-content:center;margin-bottom:1.25rem;">
                    <svg style="width:3rem;height:3rem;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 122.88 111.54">
                        <path fill="#cf1f25" d="M2.35,84.42,45.28,10.2l.17-.27h0A23,23,0,0,1,52.5,2.69,17,17,0,0,1,61.57,0a16.7,16.7,0,0,1,9.11,2.69,22.79,22.79,0,0,1,7,7.26q.19.32.36.63l42.23,73.34.24.44h0a22.48,22.48,0,0,1,2.37,10.19,17.63,17.63,0,0,1-2.17,8.35,15.94,15.94,0,0,1-6.93,6.6c-.19.1-.39.18-.58.26a21.19,21.19,0,0,1-9.11,1.75v0H17.61c-.22,0-.44,0-.65,0a18.07,18.07,0,0,1-6.2-1.15A16.42,16.42,0,0,1,3,104.24a17.53,17.53,0,0,1-3-9.57,23,23,0,0,1,1.57-8.74,7.66,7.66,0,0,1,.77-1.51Z"/>
                        <path fill="#fec901" fill-rule="evenodd" d="M9,88.75,52.12,14.16c5.24-8.25,13.54-8.46,18.87,0l42.43,73.69c3.39,6.81,1.71,16-9.33,15.77H17.61C10.35,103.8,5.67,97.43,9,88.75Z"/>
                        <path fill="#010101" d="M57.57,83.78A5.53,5.53,0,0,1,61,82.2a5.6,5.6,0,0,1,2.4.36,5.7,5.7,0,0,1,2,1.3,5.56,5.56,0,0,1,1.54,5,6.23,6.23,0,0,1-.42,1.35,5.57,5.57,0,0,1-5.22,3.26,5.72,5.72,0,0,1-2.27-.53A5.51,5.51,0,0,1,56.28,90a5.18,5.18,0,0,1-.36-1.27,5.83,5.83,0,0,1-.06-1.31h0a6.53,6.53,0,0,1,.57-2,4.7,4.7,0,0,1,1.14-1.56Zm8.15-10.24c-.19,4.79-8.31,4.8-8.49,0-.82-8.21-2.92-29.34-2.86-37.05.07-2.38,2-3.79,4.56-4.33a12.83,12.83,0,0,1,5,0c2.61.56,4.65,2,4.65,4.44v.24L65.72,73.54Z"/>
                    </svg>
                </div>

                <h2 style="font-size:1.375rem;font-weight:700;color:#111827;margin:0 0 0.25rem;">Modalità Demo</h2>
                <p style="font-size:0.8rem;color:#6b7280;margin:0 0 1.25rem;">Ambiente dimostrativo — TicketFlow B2B Ticketing</p>

                <div style="font-size:0.875rem;color:#374151;line-height:1.65;text-align:left;margin-bottom:1.5rem;">
                    <p style="margin:0 0 0.6rem;">Stai accedendo a una <strong>versione dimostrativa</strong> di TicketFlow. Tutti i dati presenti — utenti, aziende, ticket e abbonamenti — sono <strong>generati artificialmente</strong> a scopo illustrativo.</p>
                    <p style="margin:0 0 0.6rem;">I dati vengono periodicamente <strong>ripristinati allo stato originale</strong>. Qualsiasi modifica potrebbe non essere permanente.</p>
                    <p style="margin:0;color:#dc2626;font-weight:500;">Non inserire dati personali reali o informazioni riservate.</p>
                </div>

                <button id="demo-modal-close" style="
                    width:100%;background:#f59e0b;color:#fff;font-weight:600;
                    font-size:0.9375rem;padding:0.75rem 1.5rem;border-radius:0.75rem;
                    border:none;cursor:pointer;
                    box-shadow:0 4px 14px rgba(245,158,11,0.35);
                    transition:background 0.15s;
                ">Ho capito, continua</button>
            </div>
        `;

        return overlay;
    }

    function closeModal() {
        const overlay = document.getElementById('demo-modal-overlay');
        if (!overlay) return;
        overlay.style.opacity = '0';
        document.getElementById('demo-modal-card').style.transform = 'scale(0.95)';
        setTimeout(() => overlay.remove(), 300);
        localStorage.setItem(KEY, Date.now().toString());
    }

    function openModal() {
        const overlay = buildModal();
        document.body.appendChild(overlay);

        // Trigger enter animation
        requestAnimationFrame(() => {
            requestAnimationFrame(() => {
                overlay.style.opacity = '1';
                document.getElementById('demo-modal-card').style.transform = 'scale(1)';
            });
        });

        // Chiusura SOLO tramite il tasto interno — backdrop e ESC disabilitati intenzionalmente
        document.getElementById('demo-modal-close').addEventListener('click', closeModal);
    }

    if (shouldShow()) {
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => setTimeout(openModal, 600));
        } else {
            setTimeout(openModal, 600);
        }
    }
})();
</script>
