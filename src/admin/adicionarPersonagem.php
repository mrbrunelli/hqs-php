<?php
session_start();

// Verificar se não está logado
if (!isset($_SESSION['hqs']['id'])) {
    exit;
}

// Incluir o arquivo de conexão
include 'config/conexao.php';

// Verificar se foi dado POST
if ($_POST) {
    // Inserir um quadrinho
    $personagem_id = $_POST['personagem_id'] ?? '';
    $quadrinho_id = $_POST['quadrinho_id'] ?? '';

    if ((empty($personagem_id)) || (empty($quadrinho_id))) {
        echo "<script>alert('Erro ao adicionar personagem')</script>";
    } else {
        // Inserir dentro do quadrinho_personagem
        $sql = "INSERT INTO quadrinho_personagem (quadrinho_id, personagem_id) VALUES (:quadrinho_id, :personagem_id)";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(":quadrinho_id", $quadrinho_id);
        $consulta->bindParam(":personagem_id", $personagem_id);

        if (!$consulta->execute()) {
            echo "<script>alert('Não foi possível inserir o personagem neste quadrinho')</script>";
            echo $consulta->errorInfo()[2];
        }

        echo "<script>alert('Personagem adicionado com sucesso!')</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personagem</title>

    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Datatable by mrbrunelli -->
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <script src="vendor/jquery/jquery.min.js"></script>
</head>

<body>
    <h4>Personagens deste quadrinho:</h4>
</body>

</html>