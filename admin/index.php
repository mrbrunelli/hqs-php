<?php
//iniciar a sessao
session_start();

//iniciar a variavel pagina
$pagina = 'paginas/login';

//incluir o arquivo de conexao
include 'config/conexao.php';

$site = $_SERVER['SERVER_NAME'];
$porta = $_SERVER['SERVER_PORT'];
$url = $_SERVER['SCRIPT_NAME'];
$h = $_SERVER['REQUEST_SCHEME'];
//http://localhost:8080/hqs/admin/index.php
// site localhost
//porta 8888
//url /hqs/admin/index.php
$base = "$h://$site:$porta/$url";

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>Admin - Hqs</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <base href="<?= $base ?>">

    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <?php
    //completar o nome da página
    $pagina = $pagina . '.php';

    //se não está logado, mostrar tela de login
    if (!isset($_SESSION['hqs']['id'])) {
        //incluir login
        include $pagina;
    }

    //se está logado mostrar o nome ou a página que esta tentando visitar
    ?>


    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="js/parsley.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>
    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>
    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>
</body>

</html>