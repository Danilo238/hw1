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

    toDelete = true;

    const c = event.currentTarget.parentNode.parentNode.dataset.index;
    fetch("rimuovi_preferiti.php?gameId=" + encodeURIComponent(game[c][0].id)).then(rimuoviPreferitiFetch);
}

function aggiungiPreferiti(event)
{
    const c = event.currentTarget.parentNode.parentNode.dataset.index;
    toDelete = false;

    fetch("aggiungi_preferiti.php?gameName=" + encodeURIComponent(game[c][0].name) +
    "&gameId=" + encodeURIComponent(game[c][0].id)).then(onResponse).then(onJsonAggiungiPreferiti);
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

    const container = document.querySelector(".my-games .container");
    
    if(toDelete === true)
    {
        const container = document.querySelectorAll(".container");
        for(let i = 0; i < container.length; i++)
        {
            if(container[i].dataset.index === clicked)
            {
                container[i].remove();
            }
        }
    }
}

function apriModale(event)
{
    toDelete = false;
    const c = event.currentTarget.dataset.index;
    clicked = c;

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
    for(let i = 0; i < game.length; i++)
    {
        if(event.currentTarget.querySelector("h2").textContent === game[i][0].name)
        {
            text.textContent = game[i][0].summary;
        }
    }
    block.appendChild(text);

    fetch("preferiti.php?gameId=" + encodeURIComponent(game[c][0].id)).then(onResponse).then(onJsonHeart);
}

function onJsonImage(response)
{
    const section = document.querySelector("#my-games");
    const container = document.createElement('div');
    container.classList.add('container');
    container.setAttribute("data-index", j);
    j++;

    const img = document.createElement('img');

    if(response[0].url === undefined)
    {
        img.src = "nocover.jpg";
    }
    else
    {
        const url = response[0].url;
        const new_url = url.replace("t_thumb", "t_cover_big");
        img.src = new_url;
    }
    
    img.classList.add('size1');
    container.appendChild(img);
    section.appendChild(container);

    container.addEventListener("click", apriModale);

    const container2 = document.createElement('div');
    container2.classList.add('container2');
    const title = document.createElement('h2');
    title.classList.add('font-size');
    for(let i = 0; i < game.length; i++)
    {
        if(game[i][0].cover === response[0].id)
        {
            title.textContent = game[i][0].name;
        }
    }
    container2.appendChild(title);
    container.appendChild(container2);

    const loading_section = document.querySelector("#loading-section");
    loading_section.innerHTML = "";
}


function onJsonGame(response)
{
    game.push(response);
    //Per otterene le immagini dei singoli giochi
    const coverId = response[0].cover;
    fetch("image_search.php?q=" + encodeURIComponent(coverId) + "&token=" + encodeURIComponent(token)).then(onResponse).then(onJsonImage);
}

function onJsonToken(response)
{
    token = response.access_token;

    ///Per ottenere i giochi effettivi
    for(let i = 0; i < myGames.length; i++)
        fetch("oauth.php?gameId="+ encodeURIComponent(myGames[i].id_game) + "&token=" + encodeURIComponent(token)).then(onResponse).then(onJsonGame);
}

function onJsonGames(response)
{
    myGames = response;
    //Per ottere il token di accesso ad IGDB
    fetch("token.php").then(onResponse).then(onJsonToken);
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

let clicked;
let toDelete = false;
let j = 0;
let game = [];
let myGames;
let token;

const hamburger = document.querySelector("#hamburger");
hamburger.addEventListener("click", toggleNavbar);

//Per ottenere i giochi preferiti dell'utente
fetch("my_games.php").then(onResponse).then(onJsonGames);