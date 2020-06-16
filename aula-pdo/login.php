<?php

    require_once('./config/conexao.php');

    if(isset($_POST) && $_POST){
        // 1 - recebendo as informacoes que o usuario preencheu no formulario
        $email = $_POST["email"];
        $senha = $_POST["senha"];

        // 2 - Criando query para buscar usuário de acordo com o email que ele enviou ao preencher o formulário de login
        $query = $dbh->prepare('select * from usuarios where email = :email');

        // 3 - Executando a query para efetivamente buscar o registro na tabela usuarios de acordo com o email informado
        $query->execute([
            ':email' => $email
        ]);

        // 4 - Armazenando o retorno obtido do banco de dados em uma variável
        $usuario = $query->fetch(PDO::FETCH_ASSOC);
        //cria um array associativo = $usuario['nome']

        // 5 - Verificando se não foi encontrado nenhum registro encontrado
        if(!$usuario){
            //6 - criando variável logado para verificar se o usuário obteve erro
            //ao digitar a senha ou até mesmo se ele existe na nossa base de dados
            $logado = false;
        } else {
            // 7 - se o usuario for encontrado iremos verificar se a senha informada confere com a senha que temos armazenada no banco de dados
            if(password_verify($senha, $usuario["senha"])){

                // 8 - Transformando o valor da variável $logado em TRUE, pois quer dizer
                // que o usuário conseguiu efetuar login com sucesso
                $logado = true;

                // 9 - iniciando sessao caso usuario tenha informado email e senha corretos
                session_start();

                //10 - criando variaveis de sessao para verificar se usuario esta logado, e, obter o id e o nome do usuario
                $_SESSION["logado"] = $logado;
                $_SESSION["id"] = $usuario["id"];
                $_SESSION["nome"] = $usuario["nome"];

                // 11 - redirecionando usuario para lista de usuarios
                header("Location: usuarios.php");
            } else {
                // 12 - Se o usuário for encontrado mas a senha informada não conferir
                // com a senha salva no banco de dados,isso indica que ele errou a senha
                $logado = false;
            }
        }
    }
?>


<?php $tituloPagina = "Formulário de Login"; ?>
<?php require_once("./inc/head.php"); ?>
<?php require_once("./inc/header.php"); ?>
<main class="container">
    <article class="row">
        <section class="col-12 mx-auto bg-light my-5 py-5 rounded border" id="cadastroForm">
        <h3 class="col-12 text-center my-3"><?= $tituloPagina ?></h3>
            <form action="login.php" method="post">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="senha">Senha</label>
                        <input type="password" class="form-control" id="senha" name="senha" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary" id="btnLogar">Entrar</button>
                <div class="form-group">
                    <?php
                        if(isset($_POST) && $_POST){
                            if(!$logado){
                                echo '<div class="mt-2 col-md-6 alert-danger">Usuário ou senha inválidos</div>';
                            }
                        }
                    ?>
                </div>
            </form>
        </section>
    </article>
</main>
<?php require_once("./inc/footer.php"); ?>