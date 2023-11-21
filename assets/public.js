// any CSS you import will output into a single css file (app.css in this case)
import './styles/public.css';

// jquery setup
import $ from 'jquery';
global.$ = global.jQuery = $;

// alpine setup
import Alpine from 'alpinejs';
import persist from '@alpinejs/persist'
import mask from '@alpinejs/mask'
Alpine.plugin(mask)
Alpine.plugin(persist);
global.Alpine = Alpine;


// swiper setup
import Swiper from 'swiper/bundle';
import 'swiper/css/bundle';
global.Swiper = Swiper;


// musi byt na konci suboru, aby sa nacitali najprv vsetky pluginy a az potom inicializoval Alpine
Alpine.start();