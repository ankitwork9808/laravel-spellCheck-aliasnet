require('./bootstrap');

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import { Head, Link } from '@inertiajs/inertia-vue3';
import axios from 'axios';

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./Pages/${name}.vue`),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .component('Head', Head)
            .component('Link', Link)
            .component('axios', axios)
            .mixin({ methods: { route } })
            .mount(el);
    },
});

window.$ = require( "jquery" );

const Swal = require('sweetalert2').default

window.Toast = Swal.mixin({
    toast: true,
    position: 'top-right',
    timer: 10000,
    timerProgressBar: true
})

window.log =  function log(object){
    console.log(`%c BEGIN: Log`, 'background: #66a5d1; color: #fff');
    console.log(object);
    console.log(`%c END: Log`, 'background: #66a5d1; color: #fff');
};

$("body").on("keypress", ".phone", function(event){

    var number = $(this).val();
    const key = event.key;

    if (number.match(/^0+/)) {
        $(this).val(number.substr(0,-1));
    }

    if(/^[0-9]+$/.test(key) && number.length <= 9 ) {
        return true;
    }
    event.preventDefault();
});

$("body").on("click", "#searchCompany", function(event){
    $( "div#inboxItems" ).animate({
            width: "toggle"
        }, 500, function() {
    });
    $(".search-company").focus();
});


(function () {
    'use strict'
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    tooltipTriggerList.forEach(function (tooltipTriggerEl) {
      new bootstrap.Tooltip(tooltipTriggerEl)
    })
})()

$("body").on("keypress", ".zipcode", function(event){

    var number = $(this).val();
    const key = event.key;

    if (number.match(/^0+/)) {
        $(this).val(number.substr(0,-1));
    }

    if(/^[0-9]+$/.test(key) && number.length <= 5 ) {
        return true;
    }
    event.preventDefault();
});

InertiaProgress.init({ color: '#4B5563' });

$(document).ready(function() { 

    if($(window).width() <= 556) { 
        $("body").on("click", "#inboxitems", function(event){
            $(this).animate({
                    width: "toggle"
                }, 500, function() {
            });
            $("#caseInfo").animate({
                width: "toggle"
            }, 500, function() {
          });
        });
       }

       
    function createRipple(event) {
        const button = event.currentTarget;
        
        const circle = document.createElement("span");
        const diameter = Math.max(button.clientWidth, button.clientHeight);
        const radius = diameter / 2;
      
        circle.style.width = circle.style.height = `${diameter}px`;
        circle.style.left = `${event.clientX - button.offsetLeft - radius}px`;
        circle.style.top = `${event.clientY - button.offsetTop - radius}px`;
        circle.classList.add("ripple");
      
        const ripple = button.getElementsByClassName("ripple")[0];
      
        if (ripple) {
          ripple.remove();
        }
      
        button.appendChild(circle);
      }
      
      const buttons = document.getElementsByClassName("ripple");
      for (const button of buttons) {
        console.log('triggred');
        button.addEventListener("click", createRipple);
      }
  $(".btnOuter").click(function(){
    $(".btnOuter i").toggleClass("fa-arrow-circle-right").toggleClass("fa-arrow-circle-left");
  });
});

// $(".btn").on("click",function(){
      
//     const button = $(this)[0];
//     const circle = document.createElement("span");
//     const diameter = Math.max(button.clientWidth, button.clientHeight);
//     const radius = diameter / 2;
   
//     circle.style.width = circle.style.height = `${diameter}px`;
//     circle.style.left = `${event.clientX - button.offsetLeft - radius}px`;
//     circle.style.top = `${event.clientY - button.offsetTop - radius}px`;
//     circle.classList.add("ripple");
  
//     const ripple = button.getElementsByClassName("ripple")[0];
  
//     if (ripple) {
//       ripple.remove();
//     }
  
//     button.appendChild(circle);

//  })