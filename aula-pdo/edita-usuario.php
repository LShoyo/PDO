<?php

    // obtendo usuario referente ao ID passado na URL para trazer informacoes preenchidas no formulario
    if(isset($_GET) && $_GET){

        // 1 - obtendo ID que recebemos como parametro na URL
        $id = $_GET["id"];

        // 2 - obtendo o conteudo do arquivo usuarios.json
        $usuariosJson = file_get_contents("./data/usuarios.json");

        // 3 - transformando o conteudo do arquivo usuarios.json em um array associativo
        $arrayUsuarios = json_decode($usuariosJson, true);

        // 4 - criando um array vazio para adicionar o usuario que tem o ID correspondente passado na URL        
        $usuarioEncontrado = [];

        // 5 - percorrendo o array associativo da lista de usuarios
        foreach ($arrayUsuarios["usuarios"] as $usuario) {
            // verificando se encontramos o usuario para fazer a alteracao
            if($usuario["id"] == $id){
                array_push($usuarioEncontrado, $usuario);
            }
        }
    }

    // alterando informacoes do usuarios no arquivo usuarios.json
    if(isset($_POST) && $_POST){

        // 1 - recebendo as informacoes que o usuario preencheu no formulario 
        $id = $_POST["id"];
        $nome = $_POST["nome"];
        $sobrenome = $_POST["sobrenome"];
        $email = $_POST["email"];
        $senha = $_POST["senha"];

        // 2 - obtendo o conteudo do arquivo usuarios.json
        $usuariosJson = file_get_contents("./data/usuarios.json");

        // 3 - transformando o conteudo do arquivo usuarios.json em um array associativo
        $arrayUsuarios = json_decode($usuariosJson, true);

        // 4 - percorrendo o array que contem a lista de usuarios
        foreach ($arrayUsuarios["usuarios"] as $chave => $usuario) {
            // 5 - verificando se encontramos o usuario
            if($usuario["id"] == $id){
                // alterando nome, sobrenome, email e senha do usuario especifico
                $arrayUsuarios["usuarios"][$chave]["nome"] = $nome;
                $arrayUsuarios["usuarios"][$chave]["sobrenome"] = $sobrenome;
                $arrayUsuarios["usuarios"][$chave]["email"] = $email;

                if($senha != ""){
                    $arrayUsuarios["usuarios"][$chave]["senha"] = $senha;
                }
            }
        }

        // 6 - transformar o conteudo do arquivo usuarios.json que foi alterado em uma string json
        $jsonUsuarios = json_encode($arrayUsuarios);

        // 7 - sobrescrever o conteudo do arquivo usuarios.json
        $alterou = file_put_contents("./data/usuarios.json", $jsonUsuarios);
    }
?>

<?php $tituloPagina = "Formulário de Alteração de Cadastro"; ?>
<?php require_once("./inc/head.php"); ?>
<?php require_once("./inc/header.php"); ?>
<main class="container">
    <article class="row">
        <section class="col-12 mx-auto bg-light my-5 py-5 rounded border" id="cadastroForm">
        <h3 class="col-12 text-center my-3"><?= $tituloPagina ?></h3>
            <form action="edita-usuario.php" method="post">
                <input type="hidden" class="form-control" id="id" name="id" 
                value="<?= isset($_GET["id"]) ? $_GET["id"] : $_POST["id"]  ?>" required>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="nome">Nome</label>
                        <!--
                            verifica dentro do value se existe id na URL que ira indicar que esta listando o usuario encontrado
                            caso nao encontre o parametro id na URL quer dizer que o formulario foi enviado atraves do metodo POST
                            e o usuario fez uma alteracao, portanto, iremos listar a informacao obtida atraves do envio do formulario
                            para conseguir exibir o valor que o usuario altera no campo nome apos clicar no botao Editar
                        -->
                        <input type="text" class="form-control" id="nome" name="nome" value="<?= isset($_GET["id"]) ? $usuarioEncontrado[0]["nome"] : $_POST["nome"] ?>" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="sobrenome">Sobrenome</label>
                        <!--
                            verifica dentro do value se existe id na URL que ira indicar que esta listando o usuario encontrado
                            caso nao encontre o parametro id na URL quer dizer que o formulario foi enviado atraves do metodo POST
                            e o usuario fez uma alteracao, portanto, iremos listar a informacao obtida atraves do envio do formulario
                            para conseguir exibir o valor que o usuario altera no campo sobrenome apos clicar no botao Editar
                        -->
                        <input type="text" class="form-control" id="sobrenome" name="sobrenome" value="<?= isset($_GET["id"]) ? $usuarioEncontrado[0]["sobrenome"] : $_POST["sobrenome"] ?>" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="email">E-mail</label>
                        <!--
                            verifica dentro do value se existe id na URL que ira indicar que esta listando o usuario encontrado
                            caso nao encontre o parametro id na URL quer dizer que o formulario foi enviado atraves do metodo POST
                            e o usuario fez uma alteracao, portanto, iremos listar a informacao obtida atraves do envio do formulario
                            para conseguir exibir o valor que o usuario altera no campo email apos clicar no botao Editar
                        -->
                        <input type="email" class="form-control" id="email" name="email" value="<?= isset($_GET["id"]) ? $usuarioEncontrado[0]["email"] : $_POST["email"] ?>" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="senha">Senha</label>                                             
                        <input type="password" class="form-control" id="senha" name="senha">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary" id="btnEditar">Editar</button>
                <div class="form-group">
                    <?php
                        if(isset($_POST) && $_POST){
                            if($alterou){
                                echo '<div class="col-md-6 mt-2 alert alert-success">Usuário alterado com sucesso</div>';
                            } else {
                                echo '<div class="col-md-6 mt-2 alert alert-danger">Falha ao processar requisição</div>';
                            }
                        }
                    ?>
                </div>
            </form>
        </section>
    </article>
</main>
<?php require_once("./inc/footer.php"); ?>