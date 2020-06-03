<?php

if (!isset($_SESSION['hqs']['id'])) {
    exit;
}

if (!isset($id)) $id = '';

$titulo = $data = $numero = $valor = $resumo = $tipo_id = $editora_id = $capa = '';

if (!empty($id)) {
    $sql = "SELECT
                *,
                date_format(data, '%d/%m/%Y') data
           FROM quadrinho
           WHERE id = :id
           LIMIT 1";
    $consulta = $pdo->prepare($sql);
    $consulta->bindParam(":id", $id);
    $consulta->execute();
    $dados = $consulta->fetch(PDO::FETCH_OBJ);

    $titulo = $dados->titulo;
    $data = $dados->data;
    $numero = $dados->numero;
    $valor = number_format($dados->valor, 2, ",", ".");
    $resumo = $dados->resumo;
    $tipo_id = $dados->tipo_id;
    $editora_id = $dados->editora_id;
    $capa = $dados->capa;

    $imagem = "../fotos/" . $capa . "p.jpg";
}

$sql = "SELECT 
            id,
            tipo 
        FROM tipo 
        ORDER BY tipo";
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
        <input type="text" name="editora" class="form-control" list="listaEditoras">
        <datalist id="listaEditoras">
            <?php
            $sql = "select id, nome from editora order by nome";
            $consulta = $pdo->prepare($sql);
            $consulta->execute();

            while ($d = $consulta->fetch(PDO::FETCH_OBJ)) : ?>
                <option value="<?= $d->id . ' - ' . $d->nome ?>">
                <?php endwhile ?>
        </datalist>

        <select name=" editora_id" id="editora_id" class="form-control" required data-parsley-required-message="Selecione uma editora">
            <option value=""></option>
            <?php
            $sql = "select id, nome from editora order by nome";
            $consulta = $pdo->prepare($sql);
            $consulta->execute();

            while ($d = $consulta->fetch(PDO::FETCH_OBJ)) : ?>
                <option value="<?= $d->id ?>"><?= $d->nome ?></option>
            <?php endwhile ?>
        </select>

        <?php
        $required = "required data-parsley-required-message='Selecione uma foto'";
        if (!empty($id)) $required = '';
        ?>

        <label for="capa">Capa do Quadrinho</label>
        <input type="file" accept=".jpg,.png" name="capa" id="capa" class="form-control" <?= $required ?> value="<?= $capa ?>">

        <input type="hidden" name="capa" value="<?= $capa ?>">

        <?php
        if (!empty($capa)) {
            echo "<img src='$imagem' alt='$titulo' width='80'><br>";
        }
        ?>

        <label for="numero">Número</label>
        <input type="text" name="numero" id="numero" class="form-control" required data-parsley-required-message="Preencha este campo" value="<?= $numero ?>">

        <label for="data">Data de Lançamento</label>
        <input type="text" name="data" id="data" class="form-control" required data-parsley-required-message="Preencha este campo" value="<?= $data ?>">

        <label for="valor">Valor</label>
        <input type="text" name="valor" id="valor" class="form-control" required data-parsley-required-message="Preencha este campo" value="<?= $valor ?>">

        <label for="resumo">Resumo / Descrição</label>
        <textarea name="resumo" id="resumo" required data-parsley-required-message="Preencha este campo" class="form-control"><?= $resumo ?></textarea>

        <button type="submit" class="btn btn-success my-3">
            <i class="fas fa-check"></i>
            Gravar Dados
        </button>

    </form>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#resumo').summernote()
        $('#valor').maskMoney({
            thousands: ".",
            decimal: ",",
            reverse: true,
            //prefix: "R$ "
        })
        $('#data').inputmask("99/99/9999")
        $('#numero').inputmask("9999")
    })
</script>