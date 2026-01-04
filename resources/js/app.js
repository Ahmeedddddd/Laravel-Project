import './bootstrap';

import Alpine from 'alpinejs';
import { initUserSearchSuggest } from './user-search-suggest';

window.Alpine = Alpine;

Alpine.start();

// Enable live suggestions on pages that opt-in.
initUserSearchSuggest();
