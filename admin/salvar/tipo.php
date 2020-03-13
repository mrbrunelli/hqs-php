<?php

if (!isset($_SESSION['hqs']['id'])) {
    exit;
}

if ($_POST) {
    $id = $tipo = '';

    foreach ($_POST as $key => $value) {
        $$key = trim($value);
    }

    if (empty($tipo)) {
        echo '<script>alert("Preencha o tipo");history.back();</script>';
        exit;
    }

    $sql = "select id from tipo where tipo = ? and id <> ? limit 1";

    $consulta = $pdo->prepare($sql);

    $consulta->bindParam(1, $tipo);
    $consulta->bindParam(2, $id);

    $consulta->execute();

    $dados = $consulta->fetch(PDO::FETCH_OBJ);

    if (!empty($dados->id)) {
        echo '<script>alert("Já existe um tipo de quadrinho com esse nome registrado!");history.back();</script>';
        exit;
    }

    if (empty($id)) {
        $sql = "insert into tipo (tipo) values (?)";

        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(1, $tipo);
    } else {
        $sql = "update tipo set tipo = ? where id = ? limit 1";

        $consulta = $pdo->prepare($sql);

        $consulta->bindParam(1, $tipo);
        $consulta->bindParam(2, $id);
    }

    if ($consulta->execute()) {
        echo '<script>alert("Registro salvo!");location.href="listar/tipo";</script>';
    } else {
        echo '<script>alert("Erro ao salvar!");history.back();</script>';
    }
} else {
    echo '<script>alert("Erro ao realizar requisição!");history.back();</script>';
}
