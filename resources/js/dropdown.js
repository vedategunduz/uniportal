class UniportalDropdown {
    constructor(options = {}) {
        this.options = {
            closeOnOutsideClick: true,
            closeOnEscape: true,
            triggerType: 'click',
            ...options
        };

        this.init();
    }

    init() {
        this.triggers = document.querySelectorAll('[data-uniportal-dropdown-trigger]');
        this.targets = document.querySelectorAll('[data-uniportal-dropdown-target]');

        this.triggers.forEach(trigger => {
            trigger.addEventListener(this.options.triggerType, () => {
                this.toggle(trigger);
                this.setPosition(trigger);
            });
        });

        document.addEventListener(this.options.triggerType, (e) => this.handleOutsideClick(e));
    }

    setPosition(trigger) {
        const targetId = trigger.dataset.uniportalDropdownTrigger;
        if (!targetId) return;
        const target = document.getElementById(targetId);
        if (!target) return;

        const { left, right, bottom, top } = trigger.getBoundingClientRect();

        const targetWidth = target.offsetWidth;
        const targetHeight = target.offsetHeight;

        const windowWidth = window.innerWidth;
        const windowHeight = window.innerHeight;

        const gap = 8; // 8px boşluk ekleniyor

        let x, y;
        y = bottom + window.scrollY + gap;

        let alignment = trigger.dataset.uniportalDropdownAlignment || 'auto';
        // alignment seçeneğine göre yatay konumlandırma:
        if (alignment === 'left') {
            x = left + window.scrollX;
        } else if (alignment === 'right') {
            x = right + window.scrollX - targetWidth;
        } else {
            // 'auto': ekran dışına çıkıyorsa sağa göre hizala, aksi halde normal
            x = left + window.scrollX;
            if (x + targetWidth > windowWidth) {
                x = right + window.scrollX - targetWidth;
            }
        }

        // Dikey konumlandırma: Alt kısım ekran dışına çıkıyorsa, yukarı aç
        if (y + targetHeight > windowHeight + window.scrollY) {
            target.style.top = `${top + window.scrollY - targetHeight - gap}px`;
        } else {
            target.style.top = `${y}px`;
        }

        target.style.left = `${x}px`;
    }

    toggle(trigger) {
        if (trigger.getAttribute('aria-expanded') === 'true')
            this.hide(trigger);
        else
            this.show(trigger);
    }

    show(trigger) {
        const target = document.getElementById(trigger.dataset.uniportalDropdownTrigger);
        target.querySelectorAll('[role="menuitem"]').forEach(menuitem => menuitem.removeAttribute('tabindex'));
        trigger.setAttribute('aria-expanded', 'true');
        target.setAttribute('aria-hidden', 'false');
        target.classList.remove('hidden');
        this.closeOtherTargets(target);
    }

    hide(trigger) {
        const target = document.getElementById(trigger.dataset.uniportalDropdownTrigger);
        target.querySelectorAll('[role="menuitem"]').forEach(menuitem => menuitem.setAttribute('tabindex', '-1'));
        trigger.setAttribute('aria-expanded', 'false');
        target.setAttribute('aria-hidden', 'true');
        target.classList.add('hidden');
    }

    closeOtherTargets(targetEl) {
        const targets = document.querySelectorAll('[data-uniportal-dropdown-target][aria-hidden="false"]');
        targets.forEach(target => {
            if (target == targetEl) return;
            target.setAttribute('aria-hidden', 'true');
            target.classList.add('hidden');
            target.querySelectorAll('[role="menuitem"]').forEach(menuitem => menuitem.setAttribute('tabindex', '-1'));
        });
    }

    closeAllDropdowns() {
        const targets = document.querySelectorAll('[data-uniportal-dropdown-target][aria-hidden="false"]');
        const triggers = document.querySelectorAll('[data-uniportal-dropdown-trigger][aria-expanded="true"]');

        targets.forEach(target => {
            target.setAttribute('aria-hidden', 'true');
            target.classList.add('hidden');
            target.querySelectorAll('[role="menuitem"]').forEach(menuitem =>
                menuitem.setAttribute('tabindex', '-1')
            );
        });

        triggers.forEach(trigger => {
            trigger.setAttribute('aria-expanded', 'false');
        });
    }

    handleOutsideClick(event) {
        if (!this.options.closeOnOutsideClick) return;

        // Eğer tıklama, dropdown target içerisinde olup,
        // ve bu target "data-uniportal-dropdown-close-on-item-click"="true" içeriyorsa:
        const target = event.target.closest('[data-uniportal-dropdown-target]');
        if (target && target.getAttribute('data-uniportal-dropdown-close-on-item-click')) {
            this.closeAllDropdowns();
            return;
        }

        // Eğer tıklama, trigger veya target dışında bir alana yapıldıysa:
        if (!event.target.closest('[data-uniportal-dropdown-trigger], [data-uniportal-dropdown-target]')) {
            this.closeAllDropdowns();
        }
    }

    refresh() {
        this.init();
    }
}
export default UniportalDropdown;
