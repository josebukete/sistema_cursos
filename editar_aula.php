<?php
include("verificar_sessao.php");
so_formador();
include("conexao.php");

$id = $_GET['id'];

// Buscar os dados da aula atual
$sql = "SELECT * FROM aulas WHERE id=$id";
$resultado = mysqli_query($conexao, $sql);
$aula = mysqli_fetch_assoc($resultado);

// Buscar todos os cursos
$cursos = mysqli_query($conexao, "SELECT id, nome FROM cursos");

if (isset($_POST['atualizar'])) {

    $titulo = $_POST['titulo'];
    $conteudo = $_POST['conteudo'];
    $curso_id = $_POST['curso_id'];
    $ordem_aula = $_POST['ordem_aula'];

    $sql = "UPDATE aulas SET
            titulo='$titulo',
            conteudo='$conteudo',
            curso_id='$curso_id',
            ordem_aula='$ordem_aula'
            WHERE id=$id";

    mysqli_query($conexao, $sql);

    echo "Aula atualizada com sucesso!";
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Editar Aula</title>
</head>
<body>

<h2>Editar Aula</h2>

<form method="POST">

    <label>Curso:</label><br>
    <select name="curso_id">
        <?php while($curso = mysqli_fetch_assoc($cursos)): ?>
            <option value="<?= $curso['id'] ?>"
                <?= $curso['id'] == $aula['curso_id'] ? 'selected' : '' ?>>
                <?= $curso['nome'] ?>
            </option>
        <?php endwhile; ?>
    </select><br><br>

    <label>Título:</label><br>
    <input type="text" name="titulo" value="<?= $aula['titulo'] ?>" required><br><br>

    <label>Conteúdo:</label><br>
    <textarea name="conteudo" rows="6" cols="50"><?= $aula['conteudo'] ?></textarea><br><br>

    <label>Ordem da Aula:</label><br>
    <input type="number" name="ordem_aula" value="<?= $aula['ordem_aula'] ?>" min="1"><br><br>

    <button type="submit" name="atualizar">Atualizar</button>

</form>

<br>
<a href="listar_aulas.php">Voltar</a>

</body>
</html>