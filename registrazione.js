function jsonCheckUsername(response)
{
    if (formStatus.username = !response.exists) 
    {
        document.querySelector('#username div').classList.add('errordiv');
    } 
    else 
    {
        document.querySelector('#username span').textContent = "Username già utilizzato";
        document.querySelector('#username .errordiv').classList.remove('errordiv');
    }
}

function jsonCheckEmail(response) 
{    
    if (formStatus.email = !response.exists) 
    {
        document.querySelector('#email div').classList.add('errordiv');
    } 
    else 
    {
        document.querySelector('#email span').textContent = "Email già utilizzata";
        document.querySelector('#email .errordiv').classList.remove('errordiv');
    }

}

function fetchResponse(response)
{
    if (!response.ok) return null;
    return response.json();
}

function checkUsername(event) 
{
    const input = event.currentTarget;

    if(!/^[a-zA-Z0-9_]{1,15}$/.test(input.value)) 
    {
        document.querySelector('#username div').classList.remove('errordiv');
        document.querySelector('#username div span').textContent = "Sono ammesse lettere, numeri e underscore. Max. 15";
        formStatus.username = false;
        console.log(document.querySelector('#username div span').textContent);
    } 
    else
    {
        document.querySelector('#username div').classList.add('errordiv');
        fetch("check_username.php?username="+encodeURIComponent(input.value)).then(fetchResponse).then(jsonCheckUsername);
    }    
}

function checkEmail(event) 
{
    const emailInput = event.currentTarget;

    if(!/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(String(emailInput.value).toLowerCase())) 
    {
        document.querySelector('#email div').classList.remove('errordiv');
        document.querySelector('#email div span').textContent = "Email non valida";
        formStatus.email = false;
    } 
    else 
    {
        document.querySelector('#email div').classList.add('errordiv');
        fetch("check_email.php?email="+encodeURIComponent(String(emailInput.value).toLowerCase())).then(fetchResponse).then(jsonCheckEmail);
    }
}

function checkPassword(event)
{
    const password = document.querySelector('#password input');
    formStatus.password = password.value;

    if(password.value.length <= 5)
    {
        document.querySelector('#password div').classList.remove('errordiv');
        document.querySelector('#password div span').textContent = "Password non valida";
    }
    else if(!/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/.test(password.value))
    {
        document.querySelector('#password div').classList.remove('errordiv');
        document.querySelector('#password div span').textContent = "La password deve contenere almeno una lettera maiuscola, una minuscola e un numero";
    }
    else if(/[!@#$%^&*(),.?":{}|<>]/.test(password.value))
    {
        document.querySelector('#password div').classList.remove('errordiv');
        document.querySelector('#password div span').textContent = "La password non può contenere caratteri speciali";
    }
    else
    {
        document.querySelector('#password div').classList.add('errordiv');
        document.querySelector('#password div span').textContent = "";
    }
}

function checkConfirmPassword(event)
{
    const confirm = document.querySelector('#c_password input');
    formStatus.confirm = confirm.value;

    if(confirm.value !== formStatus.password)
    {
        document.querySelector('#c_password div').classList.remove('errordiv');
        document.querySelector('#c_password div span').textContent = "Le password non coincidono";
    }
    else
    {
        document.querySelector('#c_password div').classList.add('errordiv');
        document.querySelector('#c_password div span').textContent = "";
    }
}

const formStatus = {'username': true, 'email': true};
document.querySelector('#username input').addEventListener('blur', checkUsername);
document.querySelector('#email input').addEventListener('blur', checkEmail);
document.querySelector('#password input').addEventListener('blur', checkPassword);
document.querySelector('#c_password input').addEventListener('blur', checkConfirmPassword);