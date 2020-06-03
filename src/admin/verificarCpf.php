<?php

session_start();

// Verificar se está logado
if (!isset($_SESSION['hqs']['id'])) {
    exit;
}

// Recuperar o CPF
$cpf = $_GET['cpf'] ?? '';
$id = $_GET['id'] ?? '';

if (empty($cpf)) {
    echo "O CPF está vazio";
    exit;
}

// Incluir o arquivo de conexão
include "config/conexao.php";
include "functions.php";

$msg = validaCpf($cpf);

if ($msg != 1) {
    echo $msg;
    exit;
}

// Verificar se existe cliente cadastrado com esse CPF
if (($id == 0) || (empty($id))) {
    // Inserindo - Ninguém pode ter esse CPF
    $sql = "SELECT id FROM cliente WHERE cpf = :cpf LIMIT 1";
    $consulta = $pdo->prepare($sql);
    $consulta->bindParam(":cpf", $cpf);
} else {
    // Atualizando - Ninguém fora o cliente pode ter esse CPF
    $sql = "SELECT id FROM cliente WHERE cpf = :cpf and id != :id LIMIT 1";
    $consulta = $pdo->prepare($sql);
    $consulta->bindParam(":cpf", $cpf);
    $consulta->bindParam(":id", $id);
}

$consulta->execute();
$dados = $consulta->fetch(PDO::FETCH_OBJ);

if (!empty($dados->id)) {
    echo "Já existe um cliente cadastrado com esse CPF";
    exit;
}
