/**
 * Trident Theme - Bootstrap 5.3 compatible Vanilla JavaScript Modal
 *
 * Implements full modal functionality compatible with Bootstrap 5.3 markup & data attributes:
 * - data-bs-toggle="modal"
 * - data-bs-target="#id" / href="#id"
 * - data-bs-dismiss="modal"
 * - data-bs-backdrop="true|false|static"
 * - data-bs-keyboard="true|false"
 * - data-bs-focus="true|false"
 *
 * Events:
 * - show.bs.modal
 * - shown.bs.modal
 * - hide.bs.modal
 * - hidden.bs.modal
 * - hidePrevented.bs.modal
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

    // Global Event Delegation for Bootstrap 5.3 modal data attributes
    document.addEventListener('click', (event) => {
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

    // Expose Modal to global namespace for both standalone usage & Bootstrap compatibility
    if (typeof window !== 'undefined') {
        window.bootstrap = window.bootstrap || {};
        window.bootstrap.Modal = Modal;
        window.Modal = Modal;
    }

    if (typeof module !== 'undefined' && module.exports) {
        module.exports = Modal;
        module.exports.Modal = Modal;
        module.exports.default = Modal;
    }
})();
