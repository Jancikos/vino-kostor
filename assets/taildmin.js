// any CSS you import will output into a single css file (app.css in this case)
import './styles/taildmin.css';

// jquery setup
// import $ from 'jquery';
// global.$ = global.jQuery = $;

// alpine setup
import Alpine from 'alpinejs';
import persist from '@alpinejs/persist'
import mask from '@alpinejs/mask'
 
Alpine.plugin(mask)
Alpine.plugin(persist);
global.Alpine = Alpine;
Alpine.start();
