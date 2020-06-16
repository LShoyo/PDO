<?php

    // 1 - criando variaveis de sessao para verificar se usuario esta logado, e, obter o id e o nome do usuario
    if(isset($_SESSION) && $_SESSION){
        $id = $_SESSION["id"];
        $nome = $_SESSION["nome"];
    }

?>
<body>
    <header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="./index.php">JSON PHP</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- 3 - aplicando validacao para exibir header diferente para usuario logado -->
            <?php if(isset($_SESSION) && $_SESSION): ?>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="">Olá, <?= $nome; ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./usuarios.php">Usuários</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./logout.php">Sair</a>
                    </li>
                </ul>
            <?php else: ?>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="./index.php">Cadastro <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./login.php">Login</a>
                    </li>
                </ul>
            <?php endif; ?>
        </div>
        </nav>
    </header>