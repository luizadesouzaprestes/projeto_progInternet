<?php

require_once 'valida.php';
require_once 'conecta.php';

// Excluir espécie
if (isset($_GET['acao']) && $_GET['acao'] === 'excluir' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $stmt = mysqli_prepare($conn, "DELETE FROM especies WHERE id = ?");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    header("Location: especies.php");
    exit;
}

// Buscar as espécies no banco
$sql = "SELECT * FROM especies ORDER BY id DESC";
$resultado = mysqli_query($conn, $sql);


require_once 'cabeçalho.php'; 
?>


<div class="page-header">
    <h2> Gerenciamento de Espécies</h2>
    <a href="form_especie.php" class="botao-primary">+ Nova Espécie</a>
</div>

<div class="table-container">
    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Espécie</th>
                <th>Ações</th>
            </tr>
        </thead>
       <tbody>
        <?php if ($resultado && mysqli_num_rows($resultado) > 0): ?>
            <?php while ($especie = mysqli_fetch_assoc($resultado)): ?>
                <tr>
                    <td><?php echo $especie['id']; ?></td>
                    <td><?php echo htmlspecialchars($especie['nome']); ?></td>
                    <td class="actions">
                        <a href="especies.php?acao=excluir&id=<?php echo $especie['id']; ?>" 
                        class="botao-deletar" 
                        onclick="return confirm('Deseja excluir esta espécie?');">Excluir</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="3" style="text-align: center; padding: 1.5rem;">Nenhuma espécie cadastrada no banco.</td>
            </tr>
        <?php endif; ?>
</tbody>
    </table>
</div>

<?php require_once 'rodape.php'; ?>