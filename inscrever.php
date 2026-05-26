<?php
include("conexao.php");

include("verificar_sessao.php");

if (isset($_POST['inscrever'])) {

    $curso_id = $_POST['curso_id'];

    // Verificar
    $verificar = "SELECT id FROM inscricoes 
                  WHERE usuario_id=$usuario_id AND curso_id=$curso_id";
    $resultado = mysqli_query($conexao, $verificar);

    if (mysqli_num_rows($resultado) > 0) {
        echo "Já estás inscrito neste curso!";
    } else {
        $sql = "INSERT INTO inscricoes (usuario_id, curso_id) 
                VALUES ($usuario_id, $curso_id)";
        mysqli_query($conexao, $sql);
        echo "Inscrição realizada com sucesso!";
    }
}

// procura cursos disponíveis
$cursos = mysqli_query($conexao, "SELECT id, nome, categoria, nivel FROM cursos");
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Inscrever em Curso</title>
</head>
<body>

<h1>Cursos Disponíveis</h1>

<a href="index.php">Início</a>
<hr>

<?php while($curso = mysqli_fetch_assoc($cursos)): ?>

    <div class="curso-card">
        <h3><?= $curso['nome'] ?></h3>
        <p>Categoria: <?= $curso['categoria'] ?></p>
        <p>Nível: <?= $curso['nivel'] ?></p>

        <form method="POST">
            <input type="hidden" name="curso_id" value="<?= $curso['id'] ?>">
            <button type="submit" name="inscrever">Inscrever-me</button>
        </form>
    </div>

    <hr>

<?php endwhile; ?>

</body>
</html>