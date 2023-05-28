<?php
    //Avvia la sessione: necessario per ricollegarsi alla sessione creata in precedenza
    session_start();
    //Chiudi la sessione
    session_destroy();
    //Torna al login
    header("Location: login.php");
    exit;
?>