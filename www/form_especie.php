<?php  
require_once 'conecta.php';

$mensagem = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['especie'] ?? '');

    if (!empty($nome)) {
        $stmt = mysqli_prepare($conn, "INSERT INTO especies (nome) VALUES (?)");
        
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $nome);
            
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_close($stmt);
                header("Location: especies.php");
                exit;
            } else {
                $mensagem = "<span style='color: var(--cor_erro);'>Erro do MySQL ao executar: " . mysqli_stmt_error($stmt) . "</span>";
            }
        } else {
            $mensagem = "<span style='color: var(--cor_erro);'>Erro do MySQL ao preparar: " . mysqli_error($conn) . "</span>";
        }
    } else {
        $mensagem = "<span style='color: var(--cor_erro);'>O campo nome veio vazio!</span>";
    }
}

require_once 'cabeçalho.php';
?>


<section class="form-section">
    <h2>Cadastrar / Editar Espécie</h2>

    <?php if (!empty($mensagem)): ?>
    <p style="margin-bottom: 1rem;"><?php echo $mensagem; ?></p> 

    <?php endif; ?> 



    <form action="form_especie.php" method="POST" class="especie-form">
        
        <div class="form-group">
            <label for="especie">Nome da Espécie</label>
            <input type="text" id="especie" name="especie" required placeholder="Ex: Cachorro, Gato, Pássaro...">
        </div>

        <div class="form-actions">
            <button type="submit" class="botao-salvar">Salvar Espécie</button>
            <a href="especies.php" class="botao-cancelar">Cancelar</a>
        </div>

    </form>
</section>

<?php require_once 'rodape.php'; ?>