function checkLenght(event)
{
    const username = document.querySelector('#username input');
    const password = document.querySelector('#password input');

    if(username.value.length == 0 || password.value.length == 0)
    {
        event.preventDefault();
        
        const box = document.querySelector('#error');
        box.classList.remove('hidden');
        const errore = document.querySelector('#error span');
        errore.textContent = 'Riempi tutti i campi';
    }
    else
    {
        const box = document.querySelector('#error');
        box.classList.add('hidden');
        const errore = document.querySelector('#error span');
        errore.textContent = '';
    }
}

const form = document.querySelector('#form');
form.addEventListener('submit', checkLenght);