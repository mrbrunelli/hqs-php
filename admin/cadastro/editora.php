<?php

//VERIFICAR SE ESTÁ LOGADO
if (!isset($_SESSION['hqs']['id'])) {
    exit;
}

?>

<div class="container">
    <h1 class="float-left">Cadastro de Editora</h1>
    <div class="float-right">
        <a href="cadastro/editora" class="btn btn-success">Novo Registro</a>
        <a href="listar/editora" class="btn btn-info">Listar Registros</a>
    </div>

    <div class="clearfix"></div>

    <form name="cadastro" method="post" action="salvar/editora" data-parsley-validate>
        <label for="id">ID</label>
        <input type="text" class="form-control" name="id" id="id" readonly>

        <label for="nome">Nome da Editora</label>
        <input type="text" class="form-control" name="nome" id="nome" required data-parsley-required-message="Preencha este campo">

        <label for="site">Site da Editora</label>
        <input type="text" class="form-control" name="site" id="site" required data-parsley-required-message="Preencha este campo">

        <button type="submit" class="btn btn-success mt-3"><i class="fas fa-check"></i> Gravar Dados</button>
    </form>
</div>