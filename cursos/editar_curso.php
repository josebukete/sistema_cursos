<?php
include("../config/verificar_sessao.php");
so_formador();
include("../config/conexao.php");

$id = $_GET['id'];

$verificar = "SELECT * FROM cursos WHERE id=$id AND formador_id=$usuario_id";
$resultado = mysqli_query($conexao, $verificar);

if (mysqli_num_rows($resultado) == 0) {
    echo "Acesso negado. Este curso não te pertence.";
    echo "<br><a href='../index.php'>Voltar</a>";
    exit();
}

$curso = mysqli_fetch_assoc($resultado);

if (isset($_POST['atualizar'])) {

    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $categoria = $_POST['categoria'];
    $nivel = $_POST['nivel'];
    $thumbnail = $curso['thumbnail']; // mantém a atual por defeito

    if (!empty($_FILES['thumbnail']['name'])) {
        $nome_thumb = time() . '_' . $_FILES['thumbnail']['name'];
        move_uploaded_file($_FILES['thumbnail']['tmp_name'], "../uploads/thumbs/$nome_thumb");
        $thumbnail = "uploads/thumbs/$nome_thumb";
    }

    $sql = "UPDATE cursos SET
            nome='$nome',
            descricao='$descricao',
            categoria='$categoria',
            nivel='$nivel',
            thumbnail='$thumbnail'
            WHERE id=$id AND formador_id=$usuario_id";

    mysqli_query($conexao, $sql);

    header("Location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Editar Curso</title>
</head>
<body>

<h2>Editar Curso</h2>

<form method="POST" enctype="multipart/form-data">

    <label>Nome:</label><br>
    <input type="text" name="nome" value="<?= $curso['nome'] ?>" required><br><br>

    <label>Descrição:</label><br>
    <textarea name="descricao"><?= $curso['descricao'] ?></textarea><br><br>

    <label>Categoria:</label><br>
    <input type="text" name="categoria" value="<?= $curso['categoria'] ?>"><br><br>

    <label>Nível:</label><br>
    <select name="nivel">
        <option value="iniciante" <?= $curso['nivel']=="iniciante" ? "selected" : "" ?>>Iniciante</option>
        <option value="intermediario" <?= $curso['nivel']=="intermediario" ? "selected" : "" ?>>Intermediário</option>
        <option value="avancado" <?= $curso['nivel']=="avancado" ? "selected" : "" ?>>Avançado</option>
    </select><br><br>

    <label>Thumbnail actual:</label><br>
    <?php if ($curso['thumbnail']): ?>
        <img src="../<?= $curso['thumbnail'] ?>" alt="Thumbnail" width="200"><br><br>
    <?php else: ?>
        <p>Sem thumbnail.</p>
    <?php endif; ?>

    <label>Nova thumbnail (deixa vazio para manter a actual):</label><br>
    <input type="file" name="thumbnail" accept="image/*"><br><br>

    <button type="submit" name="atualizar">Atualizar</button>

</form>

<br>
<a href="../index.php">Cancelar</a>

</body>
</html>