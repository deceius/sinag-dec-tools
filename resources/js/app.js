import './bootstrap';

import Alpine from 'alpinejs';
import profile from './controllers/profile';
import deathlog from './controllers/deathlog';
import builds from './controllers/builds';

window.Alpine = Alpine;


Alpine.data('builds', builds);
Alpine.data('profile', profile);
Alpine.data('deathlog', deathlog);
Alpine.start();
