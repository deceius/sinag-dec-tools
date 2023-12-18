import './bootstrap';

import Alpine from 'alpinejs';
import profile from './controllers/profile';
import deathlog from './controllers/deathlog';

window.Alpine = Alpine;


Alpine.data('profile', profile);
Alpine.data('deathlog', deathlog);
Alpine.start();
