<?php
// Verificar se não está logado
if (!isset($_SESSION["hqs"]["id"])) {
    exit;
}

if ($_POST) {
    include "functions.php";
    include "config/conexao.php";

    // Inicializar variáveis com valores nulos
    $id = $titulo = $data = $numero = $valor = $resumo = $tipo_id = $editora_id = "";

    foreach ($_POST as $key => $value) {
        $$key = trim($value);
    }

    if (empty($titulo)) {
        echo "<script>alert('Preencha o título');history.back();</script>";
        exit;
    } else if (empty($tipo_id)) {
        echo "<script>alert('Selecione o tipo de quadrinho');history.back();</script>";
        exit;
    }

    // Iniciar uma transação
    $pdo->beginTransaction();

    // Formatando os valores
    $data = formatarData($data);
    $numero = retirarUnderline($numero);
    $valor = formatarValor($valor);

    $arquivo = time() . "-" . $_SESSION["hqs"]["id"];

    if (empty($id)) {
        // Inserir
        $sql = "INSERT INTO quadrinho (titulo, numero, data, capa, resumo, valor, tipo_id, editora_id) VALUES
                (:titulo, :numero, :data, :capa, :resumo, :valor, :tipo_id, :editora_id)";

        $consulta = $pdo->prepare($sql);

        $consulta->bindParam(":titulo", $titulo);
        $consulta->bindParam(":numero", $numero);
        $consulta->bindParam(":data", $data);
        $consulta->bindParam(":capa", $arquivo);
        $consulta->bindParam(":resumo", $resumo);
        $consulta->bindParam(":valor", $valor);
        $consulta->bindParam(":tipo_id", $tipo_id);
        $consulta->bindParam(":editora_id", $editora_id);
    } else {
        // Editar - Update
        // Qual arquivo irá ser gravado
        if (!empty($_FILES["capa"]["name"]))
            $capa = $arquivo;

        $sql = "UPDATE quadrinho SET 
                    titulo = :titulo,
                    numero = :numero,
                    valor = :valor,
                    resumo = :resumo,
                    capa = :capa,
                    tipo_id = :tipo_id,
                    editora_id = :editora_id,
                    data = :data
                WHERE
                    id = :id LIMIT 1";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(":titulo", $titulo);
        $consulta->bindParam(":numero", $numero);
        $consulta->bindParam(":valor", $valor);
        $consulta->bindParam(":resumo", $resumo);
        $consulta->bindParam(":capa", $capa);
        $consulta->bindParam(":tipo_id", $tipo_id);
        $consulta->bindParam(":editora_id", $editora_id);
        $consulta->bindParam(":data", $data);
        $consulta->bindParam(":id", $id);
    }

    // Executar o SQL
    if ($consulta->execute()) {

        // Verificar se o arquivo não está sendo enviado
        // Capa deve estar vazia e o id não pode estar vazio - editando
        if ((empty($_FILES["capa"]["type"])) && (!empty($id))) {
            $pdo->commit();
            echo "<script>alert('Registro salvo');location.href='listar/quadrinho';</script>";
            exit;
        }

        // Verificar se o tipo de imagem é JPG
        if ($_FILES["capa"]["type"] != "image/jpeg") {
            echo "<script>alert('Selecione uma imagem JPG válida');history.back();</script>";
            exit;
        }

        // Copiar a imagem para o servidor
        if (move_uploaded_file($_FILES["capa"]["tmp_name"], "../fotos/" . $_FILES["capa"]["name"])) {
            // Redimensionar imagem
            $pastaFotos = "../fotos/";
            $imagem = $_FILES["capa"]["name"];
            $nome = $arquivo;
            redimensionarImagem($pastaFotos, $imagem, $nome);

            // Gravar no banco - se tudo deu certo
            $pdo->commit();
            echo "<script>alert('Registro salvo');location.href='listar/quadrinho';</script>";
            exit;
        }

        // Erro ao gravar
        echo "<script>alert('Erro ao salvar ou enviar arquivo para o servidor');history.back();</script>";
        exit;
    }

    exit;
}

echo "<p class='alert alert-danger'>Requisição inválida</p>";
