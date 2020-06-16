<?php

    // 1 - obtendo sessao iniciada
    session_start();

    // 2 - destruindo a sessao e todas as variaveis de sessao
    session_destroy();

    // 3 - redirecionando para login
    header("Location: login.php");
    
?>