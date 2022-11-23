window.formMakerModal = () => {
    return {
        show: false,
        showActiveModal: true,
        activeModal: false,
        modalHistory: [],
        closeModalOnEscape(trigger) {
            this.closeModal(true);
        },
        closeModalOnClickAway(trigger) {
            this.closeModal(true);
        },
        closeModal(force = false, skipPreviousModals = 0, destroySkipped = false) {
            if(this.show === false) {
                return;
            }

            Livewire.emit('deleteModal', this.activeModal);

            if (skipPreviousModals > 0) {
                for (var i = 0; i < skipPreviousModals; i++) {
                    if (destroySkipped) {
                        const id = this.modalHistory[this.modalHistory.length - 1];
                        Livewire.emit('destroyComponent', id);
                    }
                    this.modalHistory.pop();
                }
            }

            const id = this.modalHistory.pop();

            if (id && force === false) {
                if (id) {
                    this.setActiveEditFieldModal(id, true);
                } else {
                    this.setShowPropertyTo(false);
                }
            } else {
                this.setShowPropertyTo(false);
            }
        },
        setActiveEditFieldModal(id, skip = false) {
            this.setShowPropertyTo(true);

            if (this.activeModal === id) {
                return;
            }

            if (this.activeModal !== false && skip === false) {
                this.modalHistory.push(this.activeModal);
            }

            let focusableTimeout = 50;

            if (this.activeModal === false) {
                this.activeModal = id
                this.showActiveModal = true;
            } else {
                this.showActiveModal = false;

                focusableTimeout = 400;

                setTimeout(() => {
                    this.activeModal = id;
                    this.showActiveModal = true;
                }, 300);
            }

            this.$nextTick(() => {
                let focusable = this.$refs[id]?.querySelector('[autofocus]');
                if (focusable) {
                    setTimeout(() => {
                        focusable.focus();
                    }, focusableTimeout);
                }
            });
        },
        focusables() {
            let selector = 'a, button, input, textarea, select, details, [tabindex]:not([tabindex=\'-1\'])'

            return [...this.$el.querySelectorAll(selector)]
                .filter(el => !el.hasAttribute('disabled'))
        },
        firstFocusable() {
            return this.focusables()[0]
        },
        lastFocusable() {
            return this.focusables().slice(-1)[0]
        },
        nextFocusable() {
            return this.focusables()[this.nextFocusableIndex()] || this.firstFocusable()
        },
        prevFocusable() {
            return this.focusables()[this.prevFocusableIndex()] || this.lastFocusable()
        },
        nextFocusableIndex() {
            return (this.focusables().indexOf(document.activeElement) + 1) % (this.focusables().length + 1)
        },
        prevFocusableIndex() {
            return Math.max(0, this.focusables().indexOf(document.activeElement)) - 1
        },
        setShowPropertyTo(show) {
            this.show = show;

            if (show) {
                document.body.classList.add('YLDF-overflow-y-hidden');
            } else {
                document.body.classList.remove('YLDF-overflow-y-hidden');

                setTimeout(() => {
                    this.activeModal = false;
                    this.$wire.resetModals();
                }, 300);
            }
        },
        init() {
            Livewire.on('closeModal', (force = false, skipPreviousModals = 0, destroySkipped = false) => {
                this.closeModal(force, skipPreviousModals, destroySkipped);
            });

            Livewire.on('activeEditFieldModalChanged', (id) => {
                this.setActiveEditFieldModal(id);
            });
        }
    };

}
