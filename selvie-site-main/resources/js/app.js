import './bootstrap';
import './calendar';

import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';

// Wait for document to be ready
document.addEventListener('DOMContentLoaded', () => {
    // Initialize Alpine only if it hasn't been initialized yet
    if (!window.Alpine) {
        window.Alpine = Alpine;
        Alpine.start();
    }

    // Initialize Livewire only if it hasn't been initialized yet
    if (!window.Livewire) {
        window.Livewire = Livewire;
        Livewire.start();
    }
});
