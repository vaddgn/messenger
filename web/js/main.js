$(document).ready(function() {
    $('.alert').each(function() {
        var message = $(this);

        message.addClass('show');

        setTimeout(function() {
            message.removeClass('show');
        }, 8000); 
    });
});

const menuItems = document.querySelectorAll('.menuItem a');

let currentURL = new URL(window.location.href);
let currentPath = currentURL.pathname;

if (currentPath == '/messenger/web/profile') {
    currentPath += '/'; 
}



document.addEventListener("DOMContentLoaded", function () {
        let userContainer = document.querySelector(".userContainer");

        if (window.innerWidth <= 1200) {


            const param = new URLSearchParams(window.location.search).get(
                "id"
              );

              if (!param) {
                let chatActive = document.querySelector(".chatActive");
                let chatPassive = document.querySelector(".chatPassive");
                chatActive.style.display = 'none';
                chatPassive.style.display = 'none';
              } 
              else {
                let chats = document.querySelector(".chats");
                chats.style.display = 'none';
              }


            }
});
