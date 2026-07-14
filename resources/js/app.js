import Alpine from 'alpinejs';
import 'trix';
import 'trix/dist/trix.css';

window.Alpine = Alpine;

document.addEventListener('trix-file-accept', (event) => event.preventDefault());

Alpine.data('slider', (count, interval = 6000) => ({
    active: 0,
    count,
    timer: null,
    init() {
        if (this.count > 1) {
            this.timer = setInterval(() => this.next(), interval);
        }
    },
    destroy() {
        if (this.timer) {
            clearInterval(this.timer);
        }
    },
    next() {
        this.active = (this.active + 1) % this.count;
    },
    prev() {
        this.active = (this.active - 1 + this.count) % this.count;
    },
    go(index) {
        this.active = index;
        if (this.timer) {
            clearInterval(this.timer);
            this.timer = setInterval(() => this.next(), interval);
        }
    },
}));

Alpine.start();
