<?php

// Verificar se não está logado
if (!isset($_SESSION['hqs']['id'])) {
    exit;
}

if ($_POST) {
    include "functions.php";
    include "config/conexao.php";

    // Inicializar as variáveis
    $id = $nome = $cpf = $datanascimento = $email = $senha = $endereco = $complemento = $cidade_id = $telefone = $celular = $bairro = $cep = '';

    foreach ($_POST as $key => $value) {
        $$key = trim($value);
    }

    // Verificar informações pessoias
    if ((empty($nome)) || (empty($cpf)) || (empty($email)) || (empty($senha)) || (empty($datanascimento)) || (empty($celular))) {
        echo "<script>alert('Não deixe informações pessoais em branco');history.back();</script>";
        exit;
    }

    // Verificar informações de endereço
    if ((empty($cep)) || (empty($cidade_id)) || (empty($bairro)) || (empty($endereco)) || (empty($complemento))) {
        echo "<script>alert('Não deixe informações de endereço em branco');history.back();</script>";
        exit;
    }

    // Iniciar uma transação
    $pdo->beginTransaction();

    // Formatando os valores
    $datanascimento = formatarData($datanascimento);

    // Concatenar a hora atual com o nome do cliente e com o id do usuário
    $arquivo = time() . "-" . $_SESSION["hqs"]["id"];

    if (empty($id)) {
        // Inserir
        $sql = "INSERT INTO cliente
                    (nome, cpf, datanascimento, email, senha, cep, endereco, complemento, bairro, cidade_id, foto, telefone, celular) VALUES
                    (:nome, :cpf, :datanascimento, :email, :senha, :cep, :endereco, :complemento, :bairro, :cidade_id, :foto, :telefone, :celular)";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(":nome", $nome);
        $consulta->bindParam(":cpf", $cpf);
        $consulta->bindParam(":datanascimento", $datanascimento);
        $consulta->bindParam(":email", $email);
        $consulta->bindParam(":senha", $senha);
        $consulta->bindParam(":cep", $cep);
        $consulta->bindParam(":endereco", $endereco);
        $consulta->bindParam(":complemento", $complemento);
        $consulta->bindParam(":bairro", $bairro);
        $consulta->bindParam(":cidade_id", $cidade_id);
        $consulta->bindParam(":foto", $arquivo);
        $consulta->bindParam(":telefone", $telefone);
        $consulta->bindParam(":celular", $celular);
    } else {
        // Editar - Update
        if (!empty($_FILES["foto"]["name"]))
            $foto = $arquivo;

        $sql = "UPDATE cliente SET 
                    nome = :nome,
                    cpf = :cpf,
                    datanascimento = :datanascimento,
                    email = :email,
                    senha = :senha,
                    cep = :cep,
                    endereco = :endereco,
                    complemento = :complemento,
                    bairro = :bairro,
                    cidade_id = :cidade_id,
                    foto = :foto,
                    telefone = :telefone,
                    celular = :celular
                WHERE
                    id = :id LIMIT 1";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(":nome", $nome);
        $consulta->bindParam(":cpf", $cpf);
        $consulta->bindParam(":datanascimento", $datanascimento);
        $consulta->bindParam(":email", $email);
        $consulta->bindParam(":senha", $senha);
        $consulta->bindParam(":cep", $cep);
        $consulta->bindParam(":endereco", $endereco);
        $consulta->bindParam(":complemento", $complemento);
        $consulta->bindParam(":bairro", $bairro);
        $consulta->bindParam(":cidade_id", $cidade_id);
        $consulta->bindParam(":foto", $foto);
        $consulta->bindParam(":telefone", $telefone);
        $consulta->bindParam(":celular", $celular);
        $consulta->bindParam(":id", $id);
    }

    // Executar o SQL
    if ($consulta->execute()) {

        // Verificar se o arquivo não está sendo enviado
        // Foto deve estar vazia e o id não pode estar vazio - editando
        if ((empty($_FILES["foto"]["type"])) && (!empty($id))) {
            $pdo->commit();
            echo "<script>alert('Registro salvo');location.href='listar/cliente';</script>";
            exit;
        }

        // Verificar se o tipo de imagem é JPG
        if ($_FILES["foto"]["type"] != "image/jpeg") {
            echo "<script>alert('Selecione uma imagem JPG válida');history.back();</script>";
            exit;
        }

        // Copiar a imagem para o servidor
        if (move_uploaded_file($_FILES["foto"]["tmp_name"], "../fotos/" . $_FILES["foto"]["name"])) {
            // Redimensionar imagem
            $pastaFotos = "../fotos/";
            $imagem = $_FILES["foto"]["name"];
            $nome = $arquivo;
            redimensionarImagem($pastaFotos, $imagem, $nome);

            // Gravar no banco - se tudo deu certo
            $pdo->commit();
            echo "<script>alert('Registro salvo');location.href='listar/cliente';</script>";
            exit;
        }

        // Erro ao gravar
        echo "<script>alert('Erro ao salvar ou enviar arquivo para o servidor');history.back();</script>";
        exit;
    }

    print_r($_POST);
    exit;
}

echo "<p class='alert alert-danger'>Requisição inválida</p>";
