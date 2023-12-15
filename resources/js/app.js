import './bootstrap';

import Alpine from 'alpinejs';
import profile from './controllers/profile';

window.Alpine = Alpine;


Alpine.data('profile', profile);
Alpine.start();
