/**
 * Trident Theme - Bootstrap 5.3 compatible Vanilla JavaScript Components (Modal, Dropdown)
 *
 * Implements full modal and dropdown functionality compatible with Bootstrap 5.3 markup & data attributes:
 * - data-bs-toggle="modal" / data-bs-toggle="dropdown"
 * - data-bs-target="#id" / href="#id"
 * - data-bs-dismiss="modal"
 * - data-bs-backdrop="true|false|static"
 * - data-bs-keyboard="true|false"
 * - data-bs-focus="true|false"
 * - data-bs-auto-close="true|false|inside|outside"
 *
 * Events:
 * - show.bs.modal / shown.bs.modal / hide.bs.modal / hidden.bs.modal / hidePrevented.bs.modal
 * - show.bs.dropdown / shown.bs.dropdown / hide.bs.dropdown / hidden.bs.dropdown
 */

(() => {
    'use strict';

    const NAME = 'modal';
    const DATA_KEY = 'bs.modal';
    const EVENT_KEY = `.${DATA_KEY}`;

    const EVENT_SHOW = `show${EVENT_KEY}`;
    const EVENT_SHOWN = `shown${EVENT_KEY}`;
    const EVENT_HIDE = `hide${EVENT_KEY}`;
    const EVENT_HIDDEN = `hidden${EVENT_KEY}`;
    const EVENT_HIDE_PREVENTED = `hidePrevented${EVENT_KEY}`;

    const CLASS_NAME_FADE = 'fade';
    const CLASS_NAME_SHOW = 'show';
    const CLASS_NAME_STATIC = 'modal-static';
    const CLASS_NAME_OPEN = 'modal-open';
    const CLASS_NAME_BACKDROP = 'modal-backdrop';

    const SELECTOR_DIALOG = '.modal-dialog';
    const SELECTOR_DATA_TOGGLE = '[data-bs-toggle="modal"]';
    const SELECTOR_DATA_DISMISS = '[data-bs-dismiss="modal"]';

    const Default = {
        backdrop: true,
        keyboard: true,
        focus: true
    };

    const modalInstances = new Map();

    const parseConfigValue = (value) => {
        if (value === 'true' || value === true) return true;
        if (value === 'false' || value === false) return false;
        if (value === 'static') return 'static';
        return value;
    };

    const getSelectorFromElement = (element) => {
        let selector = element.getAttribute('data-bs-target');
        if (!selector || selector === '#') {
            let hrefAttr = element.getAttribute('href');
            if (!hrefAttr || (!hrefAttr.includes('#') && !hrefAttr.startsWith('.'))) {
                return null;
            }
            if (hrefAttr.includes('#') && !hrefAttr.startsWith('#')) {
                hrefAttr = `#${hrefAttr.split('#')[1]}`;
            }
            selector = hrefAttr && hrefAttr !== '#' ? hrefAttr.trim() : null;
        }
        return selector;
    };

    const getElementFromSelector = (element) => {
        const selector = getSelectorFromElement(element);
        return selector ? document.querySelector(selector) : null;
    };

    const getTransitionDuration = (element) => {
        if (!element) return 0;
        const style = window.getComputedStyle(element);
        const duration = Number.parseFloat(style.transitionDuration) || 0;
        const delay = Number.parseFloat(style.transitionDelay) || 0;
        return (duration + delay) * 1000;
    };

    const executeAfterTransition = (element, callback) => {
        if (!element || !element.classList.contains(CLASS_NAME_FADE)) {
            callback();
            return;
        }

        const dialog = element.querySelector(SELECTOR_DIALOG) || element;
        const duration = Math.max(getTransitionDuration(dialog), getTransitionDuration(element)) + 50;
        let called = false;

        const onTransitionEnd = (event) => {
            if (event.target !== dialog && event.target !== element) return;
            if (called) return;
            called = true;
            element.removeEventListener('transitionend', onTransitionEnd);
            callback();
        };

        element.addEventListener('transitionend', onTransitionEnd);
        setTimeout(() => {
            if (!called) {
                called = true;
                element.removeEventListener('transitionend', onTransitionEnd);
                callback();
            }
        }, Math.max(duration, 350));
    };

    const dispatchEvent = (element, eventType, detail = {}) => {
        const event = new CustomEvent(eventType, {
            bubbles: true,
            cancelable: true,
            detail
        });
        // Bootstrap compatibility: attach relatedTarget directly to the event object
        if (detail.relatedTarget) {
            Object.defineProperty(event, 'relatedTarget', {
                value: detail.relatedTarget,
                enumerable: true
            });
        }
        element.dispatchEvent(event);
        return event;
    };

    class Modal {
        constructor(element, config = {}) {
            const targetElement = typeof element === 'string' ? document.querySelector(element) : element;
            if (!targetElement) {
                throw new TypeError(`Modal target element not found: ${element}`);
            }

            this._element = targetElement;
            this._config = this._getConfig(config);
            this._isShown = false;
            this._isTransitioning = false;
            this._backdropElement = null;
            this._relatedTarget = null;
            this._ignoreBackdropClick = false;

            this._onKeyDown = this._handleKeyDown.bind(this);
            this._onMouseDown = this._handleMouseDown.bind(this);
            this._onClick = this._handleClick.bind(this);

            modalInstances.set(this._element, this);
        }

        static getInstance(element) {
            const targetElement = typeof element === 'string' ? document.querySelector(element) : element;
            return modalInstances.get(targetElement) || null;
        }

        static getOrCreateInstance(element, config = {}) {
            return this.getInstance(element) || new this(element, config);
        }

        get isShown() {
            return this._isShown;
        }

        _getConfig(config) {
            const dataset = this._element.dataset;
            const dataConfig = {};

            if ('bsBackdrop' in dataset) dataConfig.backdrop = parseConfigValue(dataset.bsBackdrop);
            if ('bsKeyboard' in dataset) dataConfig.keyboard = parseConfigValue(dataset.bsKeyboard);
            if ('bsFocus' in dataset) dataConfig.focus = parseConfigValue(dataset.bsFocus);

            return {
                ...Default,
                ...dataConfig,
                ...config
            };
        }

        toggle(relatedTarget) {
            return this._isShown ? this.hide() : this.show(relatedTarget);
        }

        show(relatedTarget) {
            if (this._isShown || this._isTransitioning) {
                return;
            }

            const showEvent = dispatchEvent(this._element, EVENT_SHOW, { relatedTarget });
            if (showEvent.defaultPrevented) {
                return;
            }

            this._isShown = true;
            this._isTransitioning = true;
            this._relatedTarget = relatedTarget || null;

            document.body.classList.add(CLASS_NAME_OPEN);

            this._showBackdrop(() => {
                this._showElement();
            });
        }

        hide() {
            if (!this._isShown || this._isTransitioning) {
                return;
            }

            const hideEvent = dispatchEvent(this._element, EVENT_HIDE, { relatedTarget: this._relatedTarget });
            if (hideEvent.defaultPrevented) {
                return;
            }

            this._isShown = false;
            this._isTransitioning = true;

            this._removeEventListeners();

            this._element.classList.remove(CLASS_NAME_SHOW);

            executeAfterTransition(this._element, () => {
                this._hideElement();
            });
        }

        dispose() {
            if (this._isShown) {
                this.hide();
            }
            this._removeEventListeners();
            modalInstances.delete(this._element);
            this._element = null;
            this._config = null;
            this._backdropElement = null;
        }

        handleUpdate() {
            // Placeholder for dynamic repositioning/scrollbar adjustment
        }

        _showElement() {
            this._element.style.display = 'block';
            this._element.removeAttribute('aria-hidden');
            this._element.setAttribute('aria-modal', 'true');
            this._element.setAttribute('role', 'dialog');

            // Force reflow
            void this._element.offsetHeight;

            this._element.classList.add(CLASS_NAME_SHOW);

            this._addEventListeners();

            executeAfterTransition(this._element, () => {
                this._isTransitioning = false;

                if (this._config.focus) {
                    this._enforceFocus();
                }

                dispatchEvent(this._element, EVENT_SHOWN, { relatedTarget: this._relatedTarget });
            });
        }

        _hideElement() {
            this._element.style.display = 'none';
            this._element.setAttribute('aria-hidden', 'true');
            this._element.removeAttribute('aria-modal');
            this._element.removeAttribute('role');

            this._hideBackdrop(() => {
                if (document.querySelectorAll(`.modal.${CLASS_NAME_SHOW}`).length === 0) {
                    document.body.classList.remove(CLASS_NAME_OPEN);
                }

                this._isTransitioning = false;

                if (this._relatedTarget && typeof this._relatedTarget.focus === 'function') {
                    this._relatedTarget.focus();
                }

                dispatchEvent(this._element, EVENT_HIDDEN, { relatedTarget: this._relatedTarget });
            });
        }

        _showBackdrop(callback) {
            if (!this._config.backdrop) {
                callback();
                return;
            }

            this._backdropElement = document.createElement('div');
            this._backdropElement.className = CLASS_NAME_BACKDROP;

            if (this._element.classList.contains(CLASS_NAME_FADE)) {
                this._backdropElement.classList.add(CLASS_NAME_FADE);
            }

            document.body.appendChild(this._backdropElement);

            // Force reflow
            void this._backdropElement.offsetHeight;

            this._backdropElement.classList.add(CLASS_NAME_SHOW);

            if (this._element.classList.contains(CLASS_NAME_FADE)) {
                const duration = getTransitionDuration(this._backdropElement) + 50;
                setTimeout(callback, Math.max(duration, 150));
            } else {
                callback();
            }
        }

        _hideBackdrop(callback) {
            if (!this._backdropElement) {
                callback();
                return;
            }

            this._backdropElement.classList.remove(CLASS_NAME_SHOW);

            const removeBackdrop = () => {
                if (this._backdropElement && this._backdropElement.parentNode) {
                    this._backdropElement.parentNode.removeChild(this._backdropElement);
                }
                this._backdropElement = null;
                callback();
            };

            if (this._backdropElement.classList.contains(CLASS_NAME_FADE)) {
                const duration = getTransitionDuration(this._backdropElement) + 50;
                setTimeout(removeBackdrop, Math.max(duration, 150));
            } else {
                removeBackdrop();
            }
        }

        _triggerBackdropTransition() {
            const hidePreventedEvent = dispatchEvent(this._element, EVENT_HIDE_PREVENTED);
            if (hidePreventedEvent.defaultPrevented) {
                return;
            }

            this._element.classList.add(CLASS_NAME_STATIC);

            const dialog = this._element.querySelector(SELECTOR_DIALOG) || this._element;
            const duration = getTransitionDuration(dialog) + 50;

            setTimeout(() => {
                this._element.classList.remove(CLASS_NAME_STATIC);
            }, Math.max(duration, 300));
        }

        _addEventListeners() {
            document.addEventListener('keydown', this._onKeyDown);
            this._element.addEventListener('mousedown', this._onMouseDown);
            this._element.addEventListener('click', this._onClick);
        }

        _removeEventListeners() {
            document.removeEventListener('keydown', this._onKeyDown);
            if (this._element) {
                this._element.removeEventListener('mousedown', this._onMouseDown);
                this._element.removeEventListener('click', this._onClick);
            }
        }

        _handleKeyDown(event) {
            if (event.key === 'Escape' || event.keyCode === 27) {
                if (this._config.keyboard) {
                    event.preventDefault();
                    this.hide();
                } else if (this._config.backdrop === 'static') {
                    event.preventDefault();
                    this._triggerBackdropTransition();
                }
            }
        }

        _handleMouseDown(event) {
            // Track if mousedown happened inside the modal dialog
            const dialog = this._element.querySelector(SELECTOR_DIALOG);
            if (dialog && dialog.contains(event.target)) {
                this._ignoreBackdropClick = true;
            } else {
                this._ignoreBackdropClick = false;
            }
        }

        _handleClick(event) {
            if (this._ignoreBackdropClick) {
                this._ignoreBackdropClick = false;
                return;
            }

            // If clicked directly on the modal container (backdrop area)
            if (event.target === this._element) {
                if (this._config.backdrop === 'static') {
                    this._triggerBackdropTransition();
                } else if (this._config.backdrop) {
                    this.hide();
                }
            }
        }

        _enforceFocus() {
            const autoFocusElement = this._element.querySelector('[autofocus]');
            if (autoFocusElement) {
                autoFocusElement.focus();
            } else {
                this._element.focus();
            }
        }
    }

    // ==========================================
    // Bootstrap 5.3 Dropdown Implementation
    // ==========================================

    const DROPDOWN_NAME = 'dropdown';
    const DROPDOWN_DATA_KEY = 'bs.dropdown';
    const DROPDOWN_EVENT_KEY = `.${DROPDOWN_DATA_KEY}`;

    const EVENT_DROPDOWN_SHOW = `show${DROPDOWN_EVENT_KEY}`;
    const EVENT_DROPDOWN_SHOWN = `shown${DROPDOWN_EVENT_KEY}`;
    const EVENT_DROPDOWN_HIDE = `hide${DROPDOWN_EVENT_KEY}`;
    const EVENT_DROPDOWN_HIDDEN = `hidden${DROPDOWN_EVENT_KEY}`;

    const SELECTOR_DROPDOWN_TOGGLE = '[data-bs-toggle="dropdown"]';
    const SELECTOR_DROPDOWN_MENU = '.dropdown-menu';
    const SELECTOR_DROPDOWN_ITEM = '.dropdown-item:not(.disabled):not(:disabled)';

    const DropdownDefault = {
        autoClose: true,
        boundary: 'clippingParents',
        display: 'dynamic',
        offset: [0, 2],
        popperConfig: null,
        reference: 'toggle'
    };

    const dropdownInstances = new Map();

    class Dropdown {
        constructor(element, config = {}) {
            const targetElement = typeof element === 'string' ? document.querySelector(element) : element;
            if (!targetElement) {
                throw new TypeError(`Dropdown target element not found: ${element}`);
            }

            this._element = targetElement;
            this._config = this._getConfig(config);
            this._isShown = this._element.classList.contains(CLASS_NAME_SHOW);

            dropdownInstances.set(this._element, this);
        }

        static getInstance(element) {
            const targetElement = typeof element === 'string' ? document.querySelector(element) : element;
            return dropdownInstances.get(targetElement) || null;
        }

        static getOrCreateInstance(element, config = {}) {
            return this.getInstance(element) || new this(element, config);
        }

        static clearMenus(event) {
            for (const instance of dropdownInstances.values()) {
                if (!instance.isShown) {
                    continue;
                }

                if (event) {
                    const toggle = instance._element;
                    const menu = instance._getMenuElement();

                    // If clicked on the toggle button itself, skip as toggle click handler manages it
                    if (toggle && (toggle === event.target || toggle.contains(event.target))) {
                        continue;
                    }

                    const isClickInsideMenu = menu && (menu === event.target || menu.contains(event.target));
                    const isClickInsideForm = isClickInsideMenu && (event.target.closest('form') && !event.target.classList.contains('dropdown-item'));

                    const autoClose = instance._config.autoClose;

                    if (autoClose === false) {
                        continue;
                    }

                    if (autoClose === 'inside') {
                        if (!isClickInsideMenu || isClickInsideForm) {
                            continue;
                        }
                    } else if (autoClose === 'outside') {
                        if (isClickInsideMenu) {
                            continue;
                        }
                    } else { // autoClose === true / 'default'
                        if (isClickInsideForm) {
                            continue;
                        }
                    }
                }

                instance.hide();
            }
        }

        get isShown() {
            return this._isShown;
        }

        _getConfig(config) {
            const dataset = this._element.dataset || {};
            const dataConfig = {};

            const autoClose = this._element.getAttribute('data-bs-auto-close') ?? dataset.bsAutoClose;
            if (autoClose !== undefined && autoClose !== null) {
                if (autoClose === 'true' || autoClose === true) dataConfig.autoClose = true;
                else if (autoClose === 'false' || autoClose === false) dataConfig.autoClose = false;
                else if (autoClose === 'inside') dataConfig.autoClose = 'inside';
                else if (autoClose === 'outside') dataConfig.autoClose = 'outside';
                else if (autoClose === 'default') dataConfig.autoClose = true;
                else dataConfig.autoClose = autoClose;
            }

            const display = this._element.getAttribute('data-bs-display') ?? dataset.bsDisplay;
            if (display) dataConfig.display = display;

            const offset = this._element.getAttribute('data-bs-offset') ?? dataset.bsOffset;
            if (offset) dataConfig.offset = offset;

            const reference = this._element.getAttribute('data-bs-reference') ?? dataset.bsReference;
            if (reference) dataConfig.reference = reference;

            return {
                ...DropdownDefault,
                ...dataConfig,
                ...config
            };
        }

        _getParentFromElement() {
            return getElementFromSelector(this._element) || this._element.closest('.dropdown, .dropup, .dropend, .dropstart, .dropdown-center, .dropup-center, .btn-group, .input-group') || this._element.parentNode;
        }

        _getMenuElement() {
            // Check data-bs-target or href
            const target = getElementFromSelector(this._element);
            if (target) {
                if (target.classList.contains('dropdown-menu')) {
                    return target;
                }
                const menu = target.querySelector(SELECTOR_DROPDOWN_MENU);
                if (menu) return menu;
            }

            // Check next siblings
            let sibling = this._element.nextElementSibling;
            while (sibling) {
                if (sibling.classList.contains('dropdown-menu')) {
                    return sibling;
                }
                sibling = sibling.nextElementSibling;
            }

            // Check parent
            const parent = this._getParentFromElement();
            if (parent) {
                return parent.querySelector(SELECTOR_DROPDOWN_MENU);
            }

            return null;
        }

        show() {
            if (this._element.disabled || this._element.classList.contains('disabled') || this._element.getAttribute('aria-disabled') === 'true' || this._isShown) {
                return;
            }

            const menu = this._getMenuElement();
            if (!menu) {
                return;
            }

            const showEvent = dispatchEvent(this._element, EVENT_DROPDOWN_SHOW, { relatedTarget: this._element });
            if (showEvent.defaultPrevented) {
                return;
            }

            // Close other open dropdowns
            Dropdown.clearMenus();

            menu.setAttribute('data-bs-popper', 'static');
            menu.classList.add(CLASS_NAME_SHOW);
            this._element.classList.add(CLASS_NAME_SHOW);
            this._element.setAttribute('aria-expanded', 'true');

            this._isShown = true;

            dispatchEvent(this._element, EVENT_DROPDOWN_SHOWN, { relatedTarget: this._element });
        }

        hide() {
            if (this._element.disabled || this._element.classList.contains('disabled') || this._element.getAttribute('aria-disabled') === 'true' || !this._isShown) {
                return;
            }

            const menu = this._getMenuElement();

            const hideEvent = dispatchEvent(this._element, EVENT_DROPDOWN_HIDE, { relatedTarget: this._element });
            if (hideEvent.defaultPrevented) {
                return;
            }

            if (menu) {
                menu.classList.remove(CLASS_NAME_SHOW);
                menu.removeAttribute('data-bs-popper');
            }

            this._element.classList.remove(CLASS_NAME_SHOW);
            this._element.setAttribute('aria-expanded', 'false');

            this._isShown = false;

            dispatchEvent(this._element, EVENT_DROPDOWN_HIDDEN, { relatedTarget: this._element });
        }

        toggle() {
            if (this._element.disabled || this._element.classList.contains('disabled') || this._element.getAttribute('aria-disabled') === 'true') {
                return;
            }

            return this._isShown ? this.hide() : this.show();
        }

        update() {
            // Placeholder for positioning recalculation
        }

        dispose() {
            if (this._isShown) {
                this.hide();
            }
            dropdownInstances.delete(this._element);
            this._element = null;
            this._config = null;
        }
    }

    // Global Event Delegation for Bootstrap 5.3 modal & dropdown data attributes
    document.addEventListener('click', (event) => {
        // Toggle dropdown button clicked
        const dropdownToggleBtn = event.target.closest(SELECTOR_DROPDOWN_TOGGLE);
        if (dropdownToggleBtn) {
            if (dropdownToggleBtn.tagName === 'A' || dropdownToggleBtn.tagName === 'BUTTON') {
                event.preventDefault();
            }

            if (!dropdownToggleBtn.disabled && !dropdownToggleBtn.classList.contains('disabled') && dropdownToggleBtn.getAttribute('aria-disabled') !== 'true') {
                const dropdown = Dropdown.getOrCreateInstance(dropdownToggleBtn);
                dropdown.toggle();
            }
        }

        // Close dropdowns according to autoClose rules
        Dropdown.clearMenus(event);

        // Toggle modal button clicked
        const toggleBtn = event.target.closest(SELECTOR_DATA_TOGGLE);
        if (toggleBtn) {
            if (toggleBtn.tagName === 'A' || toggleBtn.tagName === 'BUTTON') {
                event.preventDefault();
            }

            const targetModal = getElementFromSelector(toggleBtn);
            if (!targetModal) return;

            const modal = Modal.getOrCreateInstance(targetModal);
            modal.toggle(toggleBtn);
            return;
        }

        // Dismiss modal button clicked
        const dismissBtn = event.target.closest(SELECTOR_DATA_DISMISS);
        if (dismissBtn) {
            if (dismissBtn.tagName === 'A' || dismissBtn.tagName === 'BUTTON') {
                event.preventDefault();
            }

            const targetModal = dismissBtn.closest('.modal') || getElementFromSelector(dismissBtn);
            if (!targetModal) return;

            const modal = Modal.getOrCreateInstance(targetModal);
            modal.hide();
        }
    });

    // Keyboard navigation for dropdowns
    document.addEventListener('keydown', (event) => {
        // Escape closes open dropdowns
        if (event.key === 'Escape' || event.keyCode === 27) {
            let closedAny = false;
            for (const instance of dropdownInstances.values()) {
                if (instance.isShown) {
                    instance.hide();
                    if (instance._element && typeof instance._element.focus === 'function') {
                        instance._element.focus();
                    }
                    closedAny = true;
                }
            }
            if (closedAny) {
                event.preventDefault();
            }
            return;
        }

        // Arrow navigation, Home, End
        const isArrowUp = event.key === 'ArrowUp' || event.keyCode === 38 || event.key === 'Up';
        const isArrowDown = event.key === 'ArrowDown' || event.keyCode === 40 || event.key === 'Down';
        const isHome = event.key === 'Home' || event.keyCode === 36;
        const isEnd = event.key === 'End' || event.keyCode === 35;

        if (isArrowUp || isArrowDown || isHome || isEnd) {
            const toggleBtn = event.target.closest(SELECTOR_DROPDOWN_TOGGLE);
            const menu = event.target.closest(SELECTOR_DROPDOWN_MENU);

            if (!toggleBtn && !menu) return;

            let instance = null;
            if (toggleBtn) {
                instance = Dropdown.getOrCreateInstance(toggleBtn);
            } else if (menu) {
                for (const inst of dropdownInstances.values()) {
                    if (inst._getMenuElement() === menu) {
                        instance = inst;
                        break;
                    }
                }
            }

            if (!instance) return;

            const menuEl = instance._getMenuElement();
            if (!menuEl) return;

            if (!instance.isShown) {
                if (isArrowDown || isArrowUp) {
                    event.preventDefault();
                    instance.show();
                    const items = Array.from(menuEl.querySelectorAll(SELECTOR_DROPDOWN_ITEM));
                    if (items.length > 0) {
                        const targetItem = isArrowUp ? items[items.length - 1] : items[0];
                        targetItem.focus();
                    }
                }
                return;
            }

            const items = Array.from(menuEl.querySelectorAll(SELECTOR_DROPDOWN_ITEM));
            if (items.length === 0) return;

            event.preventDefault();

            if (isHome) {
                items[0].focus();
                return;
            }
            if (isEnd) {
                items[items.length - 1].focus();
                return;
            }

            const activeIndex = items.indexOf(document.activeElement);
            if (activeIndex === -1) {
                if (isArrowUp) {
                    items[items.length - 1].focus();
                } else {
                    items[0].focus();
                }
            } else {
                let nextIndex;
                if (isArrowUp) {
                    nextIndex = activeIndex > 0 ? activeIndex - 1 : items.length - 1;
                } else {
                    nextIndex = activeIndex < items.length - 1 ? activeIndex + 1 : 0;
                }
                items[nextIndex].focus();
            }
        }
    });

    // Expose Modal & Dropdown to global namespace for both standalone usage & Bootstrap compatibility
    if (typeof window !== 'undefined') {
        window.bootstrap = window.bootstrap || {};
        window.bootstrap.Modal = Modal;
        window.bootstrap.Dropdown = Dropdown;
        window.Modal = Modal;
        window.Dropdown = Dropdown;
    }

    if (typeof module !== 'undefined' && module.exports) {
        module.exports = {
            Modal,
            Dropdown,
            default: { Modal, Dropdown }
        };
        module.exports.Modal = Modal;
        module.exports.Dropdown = Dropdown;
        module.exports.default = module.exports;
    }
})();
