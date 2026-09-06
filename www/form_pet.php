<?php

require_once 'valida.php';
require_once 'conecta.php';

$mensagem = "";
$id = "";
$nome = "";
$nascimento = "";
$especie_id = "";
$genero = "";
$prontuario = "";
$edicao = false;

// busca dados
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $stmt = mysqli_prepare($conn, "SELECT * FROM pets WHERE id = ?");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        
        if ($pet = mysqli_fetch_assoc($res)) {
            $nome = $pet['nome'];
            $nascimento = $pet['nascimento'];
            $especie_id = $pet['especie_id'];
            $genero = $pet['genero'];
            $prontuario = $pet['prontuario'];
            $edicao = true;
        }
        mysqli_stmt_close($stmt);
    }
}

//processa

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $nome = trim($_POST['nome'] ?? '');
    $nascimento = $_POST['nascimento'] ?? '';
    $especie_id = (int)($_POST['especie_id'] ?? 0);
    $genero = $_POST['genero'] ?? '';
    $prontuario = trim($_POST['prontuario'] ?? '');

    if (!empty($nome) && !empty($nascimento) && $especie_id > 0 && !empty($genero)) {
        if ($id > 0) {
            $sql = "UPDATE pets SET nome = ?, nascimento = ?, especie_id = ?, genero = ?, prontuario = ? WHERE id = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ssissi", $nome, $nascimento, $especie_id, $genero, $prontuario, $id);
        } else {
            $sql = "INSERT INTO pets (nome, nascimento, especie_id, genero, prontuario) VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ssiss", $nome, $nascimento, $especie_id, $genero, $prontuario);
        }

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            header("Location: index.php");
            exit;
        } else {
            $mensagem = "Erro ao salvar: " . mysqli_stmt_error($stmt);
        }
    } else {
        $mensagem = "Preencha todos os campos obrigatórios!";
    }
}

// Carrega
$sql_esp = "SELECT * FROM especies ORDER BY nome ASC";
$res_especies = mysqli_query($conn, $sql_esp);


require_once 'cabeçalho.php'; ?>


<section class="form-section">
    <h2> Cadastrar / Editar Pet</h2>

    <form action="form_pet.php" method="POST" class="pet-form">
        <input type="hidden" name="id" value="<?php echo $id; ?>">

        <div class="form-group">
            <label for="nome"> Nome do Pet</label>
            <input type="text" id="nome" name="nome" value= "<?php echo htmlspecialchars($nome); ?>" required placeholder="Ex: Tito, Amora...">
        </div>

        <div class="form-group">
            <label for="nascimento"> Data de Nascimento</label>
            <input type="date" id="nascimento" name="nascimento" value="<?php echo $nascimento; ?>" required>
        </div>

        <div class="form-group">
            <label for="especie_id"> Espécie</label>
            <select id="especie_id" name="especie_id" required>
                <option value=""> Selecione uma espécie </option>
                <?php if ($res_especies && mysqli_num_rows($res_especies) > 0): ?>
                <?php while ($esp = mysqli_fetch_assoc($res_especies)): ?>
                <option value="<?php echo $esp['id']; ?>" <?php echo ($esp['id'] == $especie_id) ? 'selected' : ''; ?> >
                    <?php echo htmlspecialchars($esp['nome']); ?>
                </option>
                <?php endwhile; ?>
                    <?php endif; ?>
            </select>
        </div>

        <div class="form-group">
            <label> Gênero </label>
            <div class="radio-options">
                <label><input type="radio" name="genero" value="macho" <?php echo ($genero === 'macho') ? 'checked' : ''; ?> required>Macho</label>
                <label><input type="radio" name="genero" value="femea" <?php echo ($genero === 'femea') ? 'checked' : ''; ?> required> Fêmea</label>
            </div>
        </div>

        <div class="form-group">
            <label for="prontuario">Prontuário (Histórico Médico/Observações)</label>
            <textarea id="prontuario" name="prontuario" rows="4" placeholder="Insira informações de saúde, vacinas ou alergias do animal"> <?php echo htmlspecialchars($prontuario); ?></textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="botao-salvar"> Salvar Pet</button>
            <a href="index.php" class="botao-cancelar">Cancelar</a>
        </div>

    </form>
</section>

<?php require_once 'rodape.php'; ?>