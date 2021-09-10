'use strict'
var footer;
var body;


function needFixed(){
   if(document.querySelector('main').id !== 'contactForm') {

      if (body.scrollHeight  footer.offsetHeight < window.innerHeight) {
         footer.style.position = 'fixed';
         footer.style.bottom = '0';
      }
   }
}


window.addEventListener('DOMContentLoaded', function(){
   footer= document.querySelector('footer');
   body = document.querySelector('body');

   needFixed();
});