<?php

require_once 'valida.php';
require_once 'conecta.php';

//excluir oet
if (isset($_GET['acao']) && $_GET['acao'] === 'excluir' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $stmt = mysqli_prepare($conn, "DELETE FROM pets WHERE id = ?");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    header("Location: index.php");
    exit;
}

$sql = "SELECT pets.*, especies.nome AS especie_nome 
        FROM pets 
        INNER JOIN especies ON pets.especie_id = especies.id 
        ORDER BY pets.id DESC";

$resultado = mysqli_query($conn, $sql);


require_once 'cabeçalho.php'; ?>

<div class="page-header">
    <h2>Gerenciamento de Pets</h2>
    <a href="form_pet.php" class="botao-primary">+ Novo Pet</a>
</div>

<div class="table-container">
    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Nascimento</th>
                <th>Espécie</th>
                <th>Gênero</th>
                <th>Prontuário</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
    <?php if ($resultado && mysqli_num_rows($resultado) > 0): ?>
        <?php while ($pet = mysqli_fetch_assoc($resultado)): ?>
            <tr>
                <td><?php echo $pet['id']; ?></td>
                <td><?php echo htmlspecialchars($pet['nome']); ?></td>
                <td><?php echo date('d/m/Y', strtotime($pet['nascimento'])); ?></td>
                <td><?php echo htmlspecialchars($pet['especie_nome']); ?></td>
                <td><?php echo ucfirst($pet['genero']); ?></td>
                <td><?php echo htmlspecialchars($pet['prontuario']); ?></td>
                <td class="actions">
                    <a href="form_pet.php?id=<?php echo $pet['id']; ?>" class="botao-editar">Editar</a>
                    <a href="index.php?acao=excluir&id=<?php echo $pet['id']; ?>" 
                       class="botao-deletar" 
                       onclick="return confirm('Tem certeza que deseja excluir este pet?');">Excluir</a>
                </td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr>
            <td colspan="7" style="text-align: center; padding: 1.5rem;">Nenhum pet cadastrado até o momento.</td>
        </tr>
    <?php endif; ?>
</tbody>
    </table>
</div>

<?php require_once 'rodape.php'; ?>