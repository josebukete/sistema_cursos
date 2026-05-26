<?php
include("verificar_sessao.php");
so_formador();
include("conexao.php");

if (isset($_POST['enviar'])) {

    $titulo = $_POST['titulo'];
    $conteudo = $_POST['conteudo'];
    $curso_id = $_POST['curso_id'];
    $ordem_aula = $_POST['ordem_aula'];

    $sql = "INSERT INTO aulas (titulo, conteudo, curso_id, ordem_aula)
            VALUES ('$titulo', '$conteudo', '$curso_id', '$ordem_aula')";

    mysqli_query($conexao, $sql);

    header("Location: ver_aulas_formador.php?curso_id=$curso_id");
    exit();
}

// Pré-seleccionar curso se vier da URL
$curso_id_selecionado = isset($_GET['curso_id']) ? $_GET['curso_id'] : null;

// Só os cursos do formador logado
$cursos = mysqli_query($conexao, "SELECT id, nome FROM cursos WHERE formador_id=$usuario_id");
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Criar Aula</title>
</head>
<body>

<h2>Criar Aula</h2>

<form method="POST">

    <label>Curso:</label><br>
    <select name="curso_id">
        <?php while($curso = mysqli_fetch_assoc($cursos)): ?>
            <option value="<?= $curso['id'] ?>"
                <?= $curso['id'] == $curso_id_selecionado ? 'selected' : '' ?>>
                <?= $curso['nome'] ?>
            </option>
        <?php endwhile; ?>
    </select><br><br>

    <label>Título da Aula:</label><br>
    <input type="text" name="titulo" placeholder="Ex: Introdução ao HTML" required><br><br>

    <label>Conteúdo:</label><br>
    <textarea name="conteudo" rows="6" cols="50" placeholder="Descreve o conteúdo da aula"></textarea><br><br>

    <label>Ordem da Aula:</label><br>
    <input type="number" name="ordem_aula" value="1" min="1"><br><br>

    <button type="submit" name="enviar">Criar Aula</button>

</form>

<br>
<a href="index.php">Início</a>

</body>
</html>