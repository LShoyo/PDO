<?php

    // importando arquivo que efetua a instancia da conexao com banco de dados
    require_once("./config/conexao.php");

    // Bloqueando pagina para usuarios nao logados
    // 1 - obtendo sessao iniciada
    session_start();

    // 2 - aplicando validacao para redirecionar usuario caso nao esteja logado, bloqueando o acesso a essa pagina
    if(!isset($_SESSION["logado"])){
        header("Location: login.php");
    }

    // Excluindo usuarios
    if(isset($_GET) && $_GET){
        // 1 - criando query para excluir o registro da tabela usuarios de acordo com o ID obtido na URL
        $query = $dbh->prepare('delete from usuarios where id = :id');

        $excluiu = $query->execute([
            ":id" => $_GET["id"]
        ]);
    }

    // Listando usuarios
    // 1 - criando query para listar todos os registros da tabela usuarios
    $query = $dbh->prepare('select * from usuarios');

    // 2 - executando a query para efetivamente obter todos os registros da tabela usuarios
    $query->execute();

    // 3 - armazenando o retorno obtido do banco de dados em uma variavel
    $arrayUsuarios = $query->fetchAll(PDO::FETCH_ASSOC);
?>
<?php $tituloPagina = "Lista de Usuários"; ?>
<?php require_once("./inc/head.php"); ?>
<?php require_once("./inc/header.php"); ?>
    <main class="container">
        <article class="row">
            <section class="col-12 mx-auto bg-light my-5 py-5 rounded border" id="usuariosTb">
                <h3 class="col-12 text-center my-3"><?= $tituloPagina ?></h3>
                <table class="table my-5">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Nome</th>
                            <th scope="col">Sobrenome</th>
                            <th scope="col">E-mail</th>
                            <th scope="col" colspan="2">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- 3 - percorrendo o array associativo da lista de usuarios -->
                        <?php foreach ($arrayUsuarios as $usuario): ?>
                            <tr>
                                <th scope="row"><?= $usuario["nome"] ?></th>
                                <td><?= $usuario["sobrenome"] ?></td>
                                <td><?= $usuario["email"] ?></td>
                                <td>
                                    <a href="edita-usuario.php?id=<?= $usuario["id"] ?>">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                </td>
                                <td>
                                    <a href="#" data-toggle="modal" data-target="#modal<?= $usuario["id"] ?>">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                    <!-- Modal -->
                                    <div class="modal fade" id="modal<?= $usuario["id"] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Deseja realmente excluir ?</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Usuário: <?= $usuario["nome"] ?></p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                    <a href="usuarios.php?id=<?= $usuario["id"] ?>">
                                                        <button type="button" class="btn btn-danger">Excluir</button>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </section>
            <div class="col-md-12">
                <?php
                    if(isset($_GET) && $_GET){
                        if($excluiu){
                            echo '<div class="col-md-12 alert-success">Usuário exclúido com sucesso</div>';
                        } else {
                            echo '<div class="col-md-12 alert-danger">Falha ao processar requisição</div>';
                        }
                    }
                ?>
            </div>
        </article>
    </main>
    <?php require_once("./inc/footer.php"); ?>