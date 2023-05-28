function onJsonHeart(response)
{
    const block = document.querySelector(".modal-block");

    if(response === false)
    {
        const heart = document.createElement('i');
        heart.classList.add('fa-regular');
        heart.classList.add('fa-heart');
        heart.classList.add('heart');
        block.appendChild(heart);
        heart.addEventListener("click", aggiungiPreferiti);
    }
    else
    {
        const heart = document.createElement('i');
        heart.classList.add('fa-solid');
        heart.classList.add('fa-heart');
        heart.classList.add('heart2');
        block.appendChild(heart);
        heart.addEventListener("click", rimuoviPreferiti);
    }
}

function rimuoviPreferitiFetch()
{
    const modalBlock = document.querySelector(".modal-block");

    const heart = document.querySelector('i');
    heart.removeEventListener("click", rimuoviPreferiti);
    heart.classList.add("fa-regular");
    heart.classList.remove("fa-solid");
    heart.classList.add("heart");
    heart.addEventListener("click", aggiungiPreferiti);
}

function onJsonAggiungiPreferiti(response)
{
    const modalBlock = document.querySelector(".modal-block");

    if(response === false)
    {
        const text = document.createElement('p');
        text.textContent = "Devi essere loggato per aggiungere il gioco ai preferiti";
        text.classList.add("text");
        modalBlock.appendChild(text);

        setTimeout(function(){
            text.remove();
        }, 4000);
    }
    else
    {
        const heart = document.querySelector('i');
        heart.removeEventListener("click", aggiungiPreferiti);
        heart.classList.remove("fa-regular");
        heart.classList.add("fa-solid");
        heart.classList.add("heart2");
        heart.addEventListener("click", rimuoviPreferiti);
    }
}

function rimuoviPreferiti(event)
{
    const heart = event.currentTarget;
    heart.removeEventListener("click", rimuoviPreferiti);
    heart.classList.remove("fa-solid");
    heart.classList.remove("heart2");
    heart.classList.add("fa-regular");
    heart.addEventListener("click", aggiungiPreferiti);

    const c = event.currentTarget.parentNode.parentNode.dataset.index;
    fetch("rimuovi_preferiti.php?gameId=" + encodeURIComponent(responseGame[c].id)).then(rimuoviPreferitiFetch);
}

function aggiungiPreferiti(event)
{
    const c = event.currentTarget.parentNode.parentNode.dataset.index;

    fetch("aggiungi_preferiti.php?gameName=" + encodeURIComponent(responseGame[c].name) +
    "&gameId=" + encodeURIComponent(responseGame[c].id)).then(onResponse).then(onJsonAggiungiPreferiti);
}

function chiudiModale(event)
{
    if(event.key === "Escape")
    {
        const modalView = document.querySelector("#modal-view");
        document.body.classList.remove("no-scroll");
        modalView.classList.add("hidden");
        modalView.innerHTML = "";
    }
}

function apriModale(event)
{
    const c = event.currentTarget.dataset.index;

    const modalView = document.querySelector("#modal-view");
    modalView.classList.remove("hidden");
    document.addEventListener("keydown", chiudiModale);

    document.body.classList.add("no-scroll");
    modalView.style.top = window.pageYOffset + "px";
    
    const container = document.createElement('div');
    container.classList.add('modal-container');
    container.setAttribute("data-index", c);

    modalView.appendChild(container);

    const block = document.createElement('div');
    block.classList.add('modal-block');
    container.appendChild(block);

    const img = document.createElement('img');
    img.src = event.currentTarget.querySelector('img').src;
    block.appendChild(img);

    const text = document.createElement('h6');
    text.textContent = responseGame[c].summary;
    block.appendChild(text);

    fetch("preferiti.php?gameId=" + encodeURIComponent(responseGame[c].id)).then(onResponse).then(onJsonHeart);
}

function onJsonImage(response)
{
    const section = document.querySelector("#game-view");
    const container = document.createElement('div');
    container.classList.add('container');
    for(let i = 0; i < responseGame.length; i++)
    {
        if(responseGame[i].cover === response[0].id)
        {
            container.setAttribute("data-index", i);
        }
    }

    const img = document.createElement('img');

    const url = response[0].url;
    const new_url = url.replace("t_thumb", "t_cover_big");
    img.src = new_url;
    
    img.classList.add('size1');
    container.appendChild(img);
    section.appendChild(container);

    container.addEventListener("click", apriModale);

    for(let i = 0; i < responseGame.length; i++)
    {
        if(responseGame[i].cover === response[0].id)
        {
            const container2 = document.createElement('div');
            container2.classList.add('container2');
            const title = document.createElement('h2');
            title.classList.add('font-size');
            title.textContent = responseGame[i].name;
            container2.appendChild(title);
            container.appendChild(container2);
        }
    }

    const loading_section = document.querySelector("#loading-section");
    loading_section.innerHTML= "";
}

function onJson(response)
{
    const container = document.querySelector('#game-view');
    container.innerHTML = "";

    responseGame = response;

    for(let i = 0; i < response.length; i++)
    {
        const coverId = response[i].cover;
        if(responseGame[i].cover !== undefined)
            setTimeout(function(){fetch("image_search.php?q=" + encodeURIComponent(coverId) + "&token=" + encodeURIComponent(token)).then(onResponse).then(onJsonImage);}, 300*i);
    }
}

function search(event)
{
    event.preventDefault();
    
    const input = document.querySelector("#content");
    const text = input.value;

    fetch("oauth.php?q="+ encodeURIComponent(text) + "&token=" + encodeURIComponent(token)).then(onResponse).then(onJson);
}

function onJsonToken(response)
{
    token = response.access_token;
}

function onResponse(response)
{
    return response.json();
}

function closeMenu(event)
{
    const navbar = document.querySelector("#navbar");
    navbar.classList.remove("active");
}

function toggleNavbar(event)
{
    const navbar = document.querySelector("#navbar");
    navbar.classList.toggle("active");

    const header = document.querySelector("#header");
    header.addEventListener("click", closeMenu);
}

let token;
fetch("token.php").then(onResponse).then(onJsonToken);

let responseGame;

const hamburger = document.querySelector("#hamburger");
hamburger.addEventListener("click", toggleNavbar);

const form = document.querySelector("#search_content");
form.addEventListener("submit", search);