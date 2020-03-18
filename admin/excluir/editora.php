<?php

if (!isset($_SESSION['hqs']['id'])) {
    exit;
}

// Verificar se o id está vazio
if (empty($id)) {
    echo "<script>alert('Não foi possível excluir o registro!');history.back();</script>";
    exit;
}

// Verificar se existe um quadrinho cadastrado com esta editora
$sql = "select id from quadrinho where editora_id = ? limit 1";

// Preparar o sql para executar
$consulta = $pdo->prepare($sql);

// Passar o id do parâmetro
$consulta->bindParam(1, $id);

// Executar o sql
$consulta->execute();

// Recuperar os dados selecionados
$dados = $consulta->fetch(PDO::FETCH_OBJ);

// Se existir avisar e voltar
if (!empty($dados->id)) {
    echo "<script>alert('Não é possível excluir este registro, pois existe um quadrinho relacionado');history.back();</script>";
    exit;
}

// Excluir a editora
$sql = "delete from editora where id = ? limit 1";

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

echo "<script>alert('Editora deletada com sucesso!');history.back();</script>";
