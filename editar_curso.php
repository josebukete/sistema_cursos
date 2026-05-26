<?php
include("verificar_sessao.php");
include("conexao.php");

$id = $_GET['id'];

$sql = "SELECT * FROM cursos WHERE id = $id";
$resultado = mysqli_query($conexao, $sql);
$curso = mysqli_fetch_assoc($resultado);

if (isset($_POST['atualizar'])) {

    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $categoria = $_POST['categoria'];
    $nivel = $_POST['nivel'];

    $sql = "UPDATE cursos SET
            nome='$nome',
            descricao='$descricao',
            categoria='$categoria',
            nivel='$nivel'
            WHERE id=$id";

    mysqli_query($conexao, $sql);

    echo "Curso atualizado com sucesso!";
}
?>

<h2>Editar Curso</h2>

<form method="POST">
    <input type="text" name="nome" value="<?= $curso['nome'] ?>" required><br><br>

    <textarea name="descricao"><?= $curso['descricao'] ?></textarea><br><br>

    <input type="text" name="categoria" value="<?= $curso['categoria'] ?>"><br><br>

    <select name="nivel">
        <option value="iniciante" <?= $curso['nivel']=="iniciante"?"selected":"" ?>>Iniciante</option>
        <option value="intermediario" <?= $curso['nivel']=="intermediario"?"selected":"" ?>>Intermediário</option>
        <option value="avancado" <?= $curso['nivel']=="avancado"?"selected":"" ?>>Avançado</option>
    </select><br><br>

    <button type="submit" name="atualizar">Atualizar</button>
</form>