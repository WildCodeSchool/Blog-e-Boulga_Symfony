import './styles/header.scss';

let menuToggle = document.querySelector('.menuToggle');
let menu = document.querySelector('#menu-mainmenu');
let header = document.querySelector('#header');
let body = document.querySelector('#body');
let burger_icon = document.querySelector('#burger_icon');

/* TODO: Refactor this code */
window.onload = onload();

function onload() {
    menuToggle.addEventListener("click", toggleMenuClickHandler);
    mediaQueryChecker() // Check if the window size is changing
}

// Open or close the burger menue, called in onload()
function toggleMenuClickHandler(evt) {
    menu.classList.toggle("toggle");
    header.classList.toggle("header-toggle");
    body.classList.toggle("body-toggle");
    burger_icon.classList.toggle("opened");
}


// Check if the window size is changing, called in onload()
function mediaQueryChecker() {
    let myMedia = window.matchMedia("(min-width: 1090px)")

    myMediaQuerry(myMedia)

    myMedia.addEventListener('change', () => {
        myMediaQuerry(myMedia)
    });
}

// Close the burger menue if the window size going into desktop size
function myMediaQuerry(myMedia) {
    if (myMedia.matches) {
        instanCloseBurger()
    }
}

// Function called if the window size going into desktop size, closes burger menue
function instanCloseBurger() {
    menu.classList.remove("toggle");
    header.classList.remove("header-toggle");
    body.classList.remove("body-toggle");
    burger_icon.classList.remove("opened");
}
