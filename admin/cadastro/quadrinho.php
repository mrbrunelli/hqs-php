<?php

if (!isset($_SESSION['hqs']['id'])) {
    exit;
}

$id = $titulo = '';
$sql = "select id, tipo from tipo order by tipo";
$consulta = $pdo->prepare($sql);
$consulta->execute();

?>

<div class="container">
    <h1 class="floar-left">Cadastro de Quadrinhos</h1>
    <div class="float-right">
        <a href="cadastro/quadrinho" class="btn btn-success">Novo Registro</a>
        <a href="listar/quadrinho" class="btn btn-info">Listar Registros</a>
    </div>

    <div class="clearfix"></div>

    <form name="formCadastro" method="post" action="salvar/quadrinho" data-parsley-validate enctype="multipart/form-data">

        <label for="id">ID</label>
        <input type="text" id="id" name="id" class="form-control" readonly value="<?= $id ?>">

        <label for="titulo">Título do Quadrinho</label>
        <input type="text" id="titulo" name="titulo" class="form-control" required data-parsley-required-message="Por favor, preencha este campo" value="<?= $titulo ?>">

        <label for="tipo_id">Tipo de Quadrinho</label>
        <select name="tipo_id" id="tipo_id" class="form-control" required data-parsley-required-message="Selecione uma opção">
            <option value=""></option>
            <?php foreach ($consulta->fetchAll(PDO::FETCH_OBJ) as $d) : ?>
                <option value="<?= $d->id ?>"><?= $d->tipo ?></option>
            <?php endforeach ?>
        </select>

        <label for="editora_id">Editora</label>
        <select name="editora_id" id="editora_id" class="form-control" required data-parsley-required-message="Selecione uma editora">
            <option value=""></option>
            <?php
            $sql = "select id, nome from editora order by nome";
            $consulta = $pdo->prepare($sql);
            $consulta->execute();

            while ($d = $consulta->fetch(PDO::FETCH_OBJ)) : ?>
                <option value="<?= $d->id ?>"><?= $d->nome ?></option>
            <?php endwhile ?>
        </select>

        <label for="capa">Capa do Quadrinho</label>
        <input type="file" accept=".jpg,.png" name="capa" id="capa" class="form-control">

        <label for="numero">Número</label>
        <input type="text" name="numero" id="numero" class="form-control" required data-parsley-required-message="Preencha este campo">

        <label for="data">Data de Lançamento</label>
        <input type="text" name="data" id="data" class="form-control" required data-parsley-required-message="Preencha este campo">

        <label for="valor">Valor</label>
        <input type="text" name="valor" id="valor" class="form-control" required data-parsley-required-message="Preencha este campo">
    </form>
</div>