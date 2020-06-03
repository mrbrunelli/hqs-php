<?php

if (!isset($_SESSION['hqs']['id'])) {
    exit;
}

// Verificar se o id está vazio
if (empty($id)) {
    echo "<script>alert('Não foi possível excluir o registro!');history.back();</script>";
    exit;
}

// Excluir quadrinho
$sql = "DELETE FROM quadrinho WHERE id = ? LIMIT 1";

$consulta = $pdo->prepare($sql);

$consulta->bindParam(1, $id);

// Verificar se não executou
if (!$consulta->execute()) {

    // Capturar os erros
    // $erro = $consulta->errorInfo();
    // $erro = $consulta->errorInfo()[2];
    // print_r($erro);

    echo "<script>alert('Erro ao excluir');history.back();</script>";
    exit;
}

echo "<script>alert('Quadrinho deletado com sucesso!');history.back();</script>";
