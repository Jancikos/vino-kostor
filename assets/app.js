/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// jquery setup
import $ from 'jquery';
global.$ = global.jQuery = $;

// alpine setup
import Alpine from 'alpinejs';
global.Alpine = Alpine;
Alpine.start();

// function runned on page load
$(function() {
    // alert("JQuery is working!");
});