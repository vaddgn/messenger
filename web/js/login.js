const registrButton = document.querySelector("#registrButton");
const loginButton = document.querySelector("#loginButton");
const formLogin = document.querySelector("#loginContainer");
const formRegistr = document.querySelector("#registrationContainer");
let action = localStorage.getItem('action');





registrButton.addEventListener('click', (element) => {
    element.preventDefault();
    localStorage.setItem('action', 'registr');
    formLogin.style.transition = "opacity 0.2s";
    formLogin.style.opacity = "0";
    setTimeout(() => {
        updateTitle('registr');
        formLogin.style.display = 'none'; 
        formRegistr.style.display = 'flex';
        formRegistr.style.opacity = '0';
        formRegistr.style.transition = "opacity 0.2s";
        setTimeout(() => {
            formRegistr.style.opacity = '1';
        }, 10);
    }, 200);




})


loginButton.addEventListener('click', (element) => {
    element.preventDefault();
    localStorage.setItem('action', 'login');
    formRegistr.style.transition = "opacity 0.2s";
    formRegistr.style.opacity = "0";
    setTimeout(() => {
        updateTitle('login');
        formRegistr.style.display = 'none'; 
        formLogin.style.display = 'flex';
        formLogin.style.opacity = '0';
        formLogin.style.transition = "opacity 0.2s";
        setTimeout(() => {
            formLogin.style.opacity = '1';
        }, 10);
    }, 200);
})

if (action === 'login'){
    formRegistr.style.display = 'none';
    formLogin.style.display = 'flex';
    formLogin.style.opacity = '1';
    localStorage.removeItem('action')
    updateTitle('login');
}

else if (action === 'registr'){
    formLogin.style.display = 'none';
    formRegistr.style.display = 'flex';
    formRegistr.style.opacity = '1';
    localStorage.removeItem('action');
    updateTitle('registr');
}

function updateTitle(action) {
    if (action === 'registr'){
        document.querySelector("#h1Page").textContent = 'Регистрация аккаунта';
        document.title = 'Регистрация аккаунта';
    }
    else if (action === 'login'){
        document.querySelector("#h1Page").textContent = 'Вход в аккаунт';
        document.title = 'Вход в аккаунт';
    }
}

