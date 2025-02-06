const leftMenu = document.querySelector("#leftMenu");
const blackBackground = document.querySelector("#blackBackground");
const textItems = document.querySelectorAll('.textItem');
const openMenuButton = document.querySelectorAll('.openMenuButton');


const avatar = document.querySelector("#imageContainer");

function openMenu() {
    
    leftMenu.classList.add('active');
    blackBackground.classList.add('active');
    textItems.forEach(item => {
        item.classList.add('active');
    });

    openMenuButton.forEach(item => {
        item.classList.add('active');
    });
}

function closeMenu() {
    leftMenu.classList.remove('active');
    blackBackground.classList.remove('active');
    textItems.forEach(item => {
        item.classList.remove('active');
    });
    setTimeout(() => {
        openMenuButton.forEach(item => {
            item.classList.remove('active');
        });
    }, 200);
}

if (avatar) {
    avatar.addEventListener('click', openAvatar);
}



document.addEventListener("DOMContentLoaded", function () {
    function toggleUserContainer() {
        let userContainer = document.querySelector(".userContainer");

        if (window.innerWidth > 700) {
            
        leftMenu.addEventListener('mouseenter', openMenu);
        leftMenu.addEventListener('mouseleave', closeMenu);
        }

        if (window.innerWidth <= 1200) {

            


            document.querySelectorAll(".userInfo").forEach(userInfo => {
                userInfo.addEventListener("click", function (event) {
                    event.preventDefault();

                    let userId = this.value; 
                    let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content'); 

                    let formData = new FormData();
                    formData.append("userInfo", userId);
                    formData.append("_csrf", csrfToken); 

                    fetch("/messenger/web/profile/search", { 
                        method: "POST",
                        body: formData
                    })
                        .then(response => response.text()) 
                        .then(html => {
                            let parser = new DOMParser();
                            let doc = parser.parseFromString(html, "text/html");
                            let newUserContainer = doc.querySelector(".userContainer");

                            if (userContainer && newUserContainer) {
                                userContainer.innerHTML = newUserContainer.innerHTML; 
                                userContainer.style.display = "block";
                                setTimeout(() => {
                                    userContainer.style.transform = "translateX(0)";
                                    userContainer.style.opacity = "1";
                                    const exitUserContainer = document.querySelector('.exitUserContainer');
                                    setTimeout(() => {
                                        exitUserContainer.style.display = "block";
                                    }, 200);
                                }, 10);
                            }
                        })
                        .catch(error => console.error("Ошибка загрузки:", error));
                });
            });
        }


    }

    toggleUserContainer(); 
    window.addEventListener("resize", toggleUserContainer); 
});




function openAvatar() {
    const avatarContainerClone = avatar.cloneNode(true);
    const avatarImgClone = avatarContainerClone.firstElementChild;
    avatarContainerClone.id = 'avatarContainerClone';
    avatarImgClone.id = 'AvatarImgClone';

    const avatarContainerGlobal = document.createElement('div');
    avatarContainerGlobal.id = 'avatarContainerGlobal';

    const exitContainerGlobal = document.createElement('div');
    exitContainerGlobal.id = 'exitContainerGlobal';
    exitContainerGlobal.textContent = '×';

    avatarContainerGlobal.append(avatarContainerClone);

    avatarContainerGlobal.append(exitContainerGlobal);

    exitContainerGlobal.addEventListener('click', () => {
        avatarContainerGlobal.remove();
    })
    

    document.body.append(avatarContainerGlobal);
}



const submitChatButton = document.querySelector("#submitChatButton");
if (submitChatButton) {
    submitChatButton.innerHTML = '<i class="bi bi-arrow-right-short"></i>';
}

var strGET = window.location.search.replace( '?', '');
const chatActive = document.querySelector(".chatActive");
const chatPassive = document.querySelector(".chatPassive");
if (strGET && chatActive) {
        chatActive.style.display = 'flex';
        chatPassive.style.display = 'none';
}



let userContainer = document.querySelector(".userContainer");

const exitUserContainer = document.querySelector('.exitUserContainer');
if (exitUserContainer) {
    exitUserContainer.addEventListener('click', (event) => {
        if (userContainer) {
            
            userContainer.style.display = 'none';
            exitUserContainer.style.display = 'none';
        }
    });
}
