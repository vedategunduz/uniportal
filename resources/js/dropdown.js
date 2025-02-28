class UniportalDropdown {
    constructor(options = {}) {
        this.options = {
            closeOnOutsideClick: true,
            closeOnEscape: true,
            triggerType: 'click',
            ...options
        };

        // Aşağıda, removeEventListener yaparken aynı fonksiyon referansını kullanabilmek için
        // bind edilmiş metotları saklıyoruz:
        this.handleOutsideClickBound = this.handleOutsideClick.bind(this);
        this.handleKeydownBound = this.handleKeydown.bind(this);

        this.init();
    }

    init() {
        console.log('Dropdown initialized');

        // Tetikleyicileri ve hedefleri topla
        this.triggers = document.querySelectorAll('[data-uniportal-dropdown-trigger]');
        this.targets = document.querySelectorAll('[data-uniportal-dropdown-target]');

        // Document seviyesindeki event listener'ları kaldır ve yeniden ekle
        document.removeEventListener(this.options.triggerType, this.handleOutsideClickBound);
        document.removeEventListener('keydown', this.handleKeydownBound);

        document.addEventListener(this.options.triggerType, this.handleOutsideClickBound);
        document.addEventListener('keydown', this.handleKeydownBound);

        // Tetikleyiciler üzerinde eventleri kaldırıp tekrar ekleyelim
        this.triggers.forEach(trigger => {
            // Eğer trigger üzerinde daha önce bir handler tanımlıysa kaldır
            if (trigger._dropdownHandler) {
                trigger.removeEventListener(this.options.triggerType, trigger._dropdownHandler);
            }

            // Sabit handler fonksiyonunu oluştur ve trigger ile ilişkilendir
            trigger._dropdownHandler = () => {
                this.toggle(trigger);
                this.setPosition(trigger);
            };

            trigger.addEventListener(this.options.triggerType, trigger._dropdownHandler);
        });
    }

    /** Escape tuşu ile kapatma */
    handleKeydown(e) {
        if (!this.options.closeOnEscape) return;
        if (e.key === 'Escape') {
            this.closeAllDropdowns();
        }
    }

    setPosition(trigger) {
        const container = trigger.closest('[data-uniportal-dropdown]');
        if (!container) return;

        const targetId = trigger.dataset.uniportalDropdownTrigger;
        if (!targetId) return;

        const dropdown = document.getElementById(targetId);
        if (!dropdown) return;

        const containerRect = container.getBoundingClientRect();
        const triggerRect = trigger.getBoundingClientRect();
        const gap = 8;

        // Container içindeki başlangıç konumunu hesapla
        let x = triggerRect.left - containerRect.left;
        const y = triggerRect.bottom - containerRect.top + gap;

        // Dropdown'un genişliğini al
        const dropdownWidth = dropdown.offsetWidth;

        // Dropdown'un ekran üzerindeki sol pozisyonu (container üzerinden hesaplanmış)
        const absoluteX = containerRect.left + x;
        const viewportWidth = window.innerWidth;

        // Eğer dropdown ekranın sağ kenarını aşıyorsa, yeniden hesapla
        if (absoluteX + dropdownWidth > viewportWidth) {
            x = triggerRect.right - containerRect.left - dropdownWidth;
        }

        dropdown.style.left = `${x}px`;
        dropdown.style.top = `${y}px`;
    }

    /** Tetikleyicinin durumuna göre aç/kapa */
    toggle(trigger) {
        console.log('Toggle dropdown');
        if (trigger.getAttribute('aria-expanded') === 'true') {
            this.hide(trigger);
        } else {
            this.show(trigger);
        }
    }

    /** Dropdown’ı göster */
    show(trigger) {
        const target = document.getElementById(trigger.dataset.uniportalDropdownTrigger);
        if (!target) return;

        target.querySelectorAll('[role="menuitem"]').forEach(menuitem =>
            menuitem.removeAttribute('tabindex')
        );
        trigger.setAttribute('aria-expanded', 'true');
        target.setAttribute('aria-hidden', 'false');
        target.classList.remove('hidden');

        // Başka açık dropdownlar varsa kapat
        this.closeOtherTargets(trigger);
    }

    /** Dropdown’ı gizle */
    hide(trigger) {
        const target = document.getElementById(trigger.dataset.uniportalDropdownTrigger);
        if (!target) return;

        target.querySelectorAll('[role="menuitem"]').forEach(menuitem =>
            menuitem.setAttribute('tabindex', '-1')
        );
        trigger.setAttribute('aria-expanded', 'false');
        target.setAttribute('aria-hidden', 'true');
        target.classList.add('hidden');
    }

    /** Aynı anda yalnızca tek dropdown açık kalsın istiyorsanız */
    closeOtherTargets(currentTrigger) {
        const openTargets = document.querySelectorAll(
            '[data-uniportal-dropdown-target][aria-hidden="false"]'
        );
        const openTriggers = document.querySelectorAll(
            '[data-uniportal-dropdown-trigger][aria-expanded="true"]'
        );

        const currentTarget = document.getElementById(currentTrigger.dataset.uniportalDropdownTrigger);

        openTriggers.forEach(trigger => {
            if (trigger === currentTrigger) return; // Kendisi ise dokunma
            trigger.setAttribute('aria-expanded', 'false');
        });

        openTargets.forEach(target => {
            if (target === currentTarget) return; // Kendisi ise dokunma
            target.setAttribute('aria-hidden', 'true');
            target.classList.add('hidden');
            target.querySelectorAll('[role="menuitem"]').forEach(menuitem =>
                menuitem.setAttribute('tabindex', '-1')
            );
        });
    }

    /** Tüm açık dropdownları kapat */
    closeAllDropdowns() {
        const openTargets = document.querySelectorAll('[data-uniportal-dropdown-target][aria-hidden="false"]');
        openTargets.forEach(target => {
            target.setAttribute('aria-hidden', 'true');
            target.classList.add('hidden');
            target.querySelectorAll('[role="menuitem"]').forEach(menuitem =>
                menuitem.setAttribute('tabindex', '-1')
            );
        });

        const expandedTriggers = document.querySelectorAll('[data-uniportal-dropdown-trigger][aria-expanded="true"]');
        expandedTriggers.forEach(trigger => {
            trigger.setAttribute('aria-expanded', 'false');
        });
    }

    /** Dışarıya tıklama kontrolü */
    handleOutsideClick(event) {
        if (!this.options.closeOnOutsideClick) return;

        // Eğer tıklanan, dropdown içindeyse ve "data-uniportal-dropdown-close-on-item-click" varsa
        const target = event.target.closest('[data-uniportal-dropdown-target]');
        if (target && target.hasAttribute('data-uniportal-dropdown-close-on-item-click')) {
            this.closeAllDropdowns();
            return;
        }

        // Tıklama, ne bir trigger ne de dropdown içerisinde değilse
        if (!event.target.closest('[data-uniportal-dropdown-trigger], [data-uniportal-dropdown-target]')) {
            this.closeAllDropdowns();
        }
    }

    /** Yeniden tetikleyicileri / eventleri güncelle */
    refresh() {
        // init() metodunu yeniden çağırır
        this.init();
    }
}

export default UniportalDropdown;
