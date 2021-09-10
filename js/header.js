var hamburger;
var bodySize;
var nav;

var hiddenNav = 'hiddenNav';


function navToggle(){
    nav.classList.toggle(hiddenNav);
}

function bigScreen(){
    nav.classList.remove(hiddenNav);
    hamburger.classList.add(hiddenNav);
}
function smallScreen(){
    nav.classList.add(hiddenNav);
    hamburger.classList.remove(hiddenNav);
}


function screenWidth(){
    if (parseInt(document.querySelector('body').scrollWidth) >= 576){
        navToggle();
        hamburger.classList.toggle(hiddenNav)
    }
}


function screenWidthDev(){
    if (parseInt(document.querySelector('body').scrollWidth) >= 576){
        bigScreen();
    }
    else{
        smallScreen();
    }
}



window.addEventListener('DOMContentLoaded', function() {
    bodySize = document.querySelector('body');
    nav = document.querySelector('header nav');
    hamburger = document.querySelector('#hamburger');

    document.querySelector('#hamburger').addEventListener('click', navToggle);
    screenWidth();

    //Change nav when we use devTools on navigator
    window.addEventListener("resize", function(){
        screenWidthDev();
    });


});