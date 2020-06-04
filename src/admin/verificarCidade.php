<?php

session_start();

// Verificar se está logado
if (!isset($_SESSION['hqs']['id'])) {
    exit;
}

// Recuperar cidade
$cidade = $_GET['localidade'] ?? '';
$estado = $_GET['uf'] ?? '';

if (empty($cidade)) {
    echo "A cidade está vazia";
    exit;
}

// Incluir o arquivo de conexão
include "config/conexao.php";
include "functions.php";

// Verificar se existe essa cidade no banco
$sql = "SELECT
            id,
            cidade,
            estado
        FROM cidade
        WHERE
            cidade = :cidade AND
            estado = :estado
        LIMIT 1";
$consulta = $pdo->prepare($sql);
$consulta->bindParam(":cidade", $cidade);
$consulta->bindParam(":estado", $estado);

// Verificar se retornou algum resultado
if (!$consulta->execute()) {
    echo "Cidade não encontrada";
    exit;
}

$dados = $consulta->fetch(PDO::FETCH_OBJ);
echo json_encode($dados);
exit;
