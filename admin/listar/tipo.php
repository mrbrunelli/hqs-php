<?php

if (!isset($_SESSION['hqs']['id'])) {
    exit;
}
?>

<div class="container">
    <h1 class="float-left">Listar Tipo de Editora</h1>
    <div class="float-right">
        <a href="cadastro/tipo" class="btn btn-success">Novo Registro</a>
        <a href="listar/tipo" class="btn btn-info">Listar Registro</a>
    </div>

    <div class="clearfix"></div>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tipo</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "select * from tipo order by tipo";
            $consulta = $pdo->prepare($sql);
            $consulta->execute();

            while ($dados = $consulta->fetch(PDO::FETCH_OBJ)) {
                $id = $dados->id;
                $tipo = $dados->tipo;

                echo '<tr>
                            <td>' . $id . '</td>
                            <td>' . $tipo . '</td>
                            <td><a href="cadastro/tipo/' . $id . '" class="btn btn-success btn-sm"><i class="fas fa-edit"></i></td>
                      </tr>';
            }
            ?>
        </tbody>
    </table>
</div>