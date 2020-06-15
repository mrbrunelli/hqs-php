<?php
if (!isset($pagina)) exit;

$sql = "SELECT id, nome FROM personagem ORDER BY nome";
$consulta = $pdo->prepare($sql);
$consulta->execute();
?>

<form name="formPersonagem" method="POST" action="adicionarPersonagem.php" data-parsley-validate target="personagens">
    <h3>Adicionar Personagens</h3>
    <input type="hidden" name="quadrinho_id" value="<?= $id ?>">
    <div class="row">
        <div class="col-8">
            <select name="personagem_id" id="personagem_id" class="form-control" required data-parsley-required-message="Selecione um personagem">
                <option />
                <?php foreach ($dados = $consulta->fetchAll(PDO::FETCH_OBJ) as $d) : ?>
                    <option value="<?= $d->id ?>"><?= $d->nome ?></option>
                <?php endforeach ?>
            </select>
        </div>

        <div class="col-4">
            <button type="submit" class="btn btn-success">
                Ok
            </button>

            <button type="reset" class="btn btn-danger">
                Novo
            </button>
        </div>
    </div>
</form>

<iframe name="personagens" width="100%" height="300px" src="adicionarPersonagem.php"></iframe>