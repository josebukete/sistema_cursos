<?php
include("conexao.php");

include("verificar_sessao.php");
$curso_id = $_GET['curso_id'];

// Verificar se o aluno está inscrito neste curso
$verificar = "SELECT id FROM inscricoes 
              WHERE usuario_id=$usuario_id AND curso_id=$curso_id";
$resultado = mysqli_query($conexao, $verificar);

if (mysqli_num_rows($resultado) == 0) {
    echo "Não tens acesso a este curso.";
    echo "<br><a href='inscrever.php'>Ver cursos disponíveis</a>";
    exit(); // Para o PHP aqui — não mostra mais nada
}

// Buscar aulas do curso com o progresso do aluno
$sql = "SELECT aulas.id, aulas.titulo, aulas.conteudo, aulas.ordem_aula,
               progresso_aulas.concluida
        FROM aulas
        LEFT JOIN progresso_aulas ON progresso_aulas.aula_id = aulas.id
                                  AND progresso_aulas.usuario_id = $usuario_id
        WHERE aulas.curso_id = $curso_id
        ORDER BY aulas.ordem_aula";

$aulas = mysqli_query($conexao, $sql);

// Buscar o nome do curso
$curso = mysqli_fetch_assoc(mysqli_query($conexao, 
         "SELECT nome FROM cursos WHERE id=$curso_id"));
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Aulas — <?= $curso['nome'] ?></title>
</head>
<body>

<h1><?= $curso['nome'] ?></h1>
<a href="meus_cursos.php">← Voltar aos meus cursos</a>
<hr>

<?php while($aula = mysqli_fetch_assoc($aulas)): ?>

    <div class="aula-item <?= $aula['concluida'] ? 'concluida' : '' ?>">

        <h3>Aula <?= $aula['ordem_aula'] ?> — <?= $aula['titulo'] ?></h3>
        <p><?= $aula['conteudo'] ?></p>

        <?php if ($aula['concluida']): ?>
            <p>✅ Concluída</p>
        <?php else: ?>
            <form method="POST" action="marcar_concluida.php">
                <input type="hidden" name="aula_id" value="<?= $aula['id'] ?>">
                <input type="hidden" name="curso_id" value="<?= $curso_id ?>">
                <button type="submit">Marcar como concluída</button>
            </form>
        <?php endif; ?>

    </div>

    <hr>

<?php endwhile; ?>

</body>
</html>