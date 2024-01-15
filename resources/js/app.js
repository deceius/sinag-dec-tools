import './bootstrap';

import Alpine from 'alpinejs';
import profile from './controllers/profile';
import deathlog from './controllers/deathlog';
import builds from './controllers/builds';
import manageRegears from './controllers/manage-regears';
import market from './controllers/market';
import regearReports from './controllers/reports/regear-reports';
import home from './controllers/home';

window.Alpine = Alpine;


Alpine.data('builds', builds);
Alpine.data('profile', profile);
Alpine.data('deathlog', deathlog);
Alpine.data('manageRegears', manageRegears);
Alpine.data('market', market);
Alpine.data('home', home);


Alpine.data('regearReports', regearReports);

Alpine.start();
