<?php
session_start();
require_once 'conecta.php';

$erro = "";

if (isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    if (!empty($email) && !empty($senha)) {
        $stmt = mysqli_prepare($conn, "SELECT id, nome, senha FROM usuarios WHERE email = ? OR nome = ?");
        
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ss", $email, $email);
            mysqli_stmt_execute($stmt);
            $res = mysqli_stmt_get_result($stmt);

            if ($usuario = mysqli_fetch_assoc($res)) {
                if ($senha === $usuario['senha']) {
                    $_SESSION['usuario_id'] = $usuario['id'];
                    $_SESSION['usuario_nome'] = $usuario['nome'];

                    header("Location: index.php");
                    exit;
                } else {
                    $erro = "Senha incorreta!";
                }
            } else {
                $erro = "Usuário não encontrado!";
            }
            mysqli_stmt_close($stmt);
        }
    } else {
        $erro = "Preencha todos os campos!";
    }
}


require_once 'cabeçalho.php'; ?>

    <!-- parte principal tela de login -->
    <div class="login-container">
        

        <div class="login-header">
            <h1> PetShop Admin </h1>
            <h2>Acesso ao  Sistema</h2>
            <p> Informe suas credenciais para continuar</p>
        </div>

        <?php if (!empty($erro)): ?>
            <p style="color: var(--cor_erro); margin-bottom: 1rem; font-weight: bold; text-align: center;"><?php echo $erro; ?></p>
        <?php endif; ?>

        <!-- formm -->
        <form action="login.php" method="POST" class="login-form">
            
            <div class="form-group">
                <label for="email">E-mail ou Usuário</label>
                <input 
                    type="text"
                    id="email"
                    name="email"
                    required placeholder="exemplo@email.com"
                >
            </div>

            <div class="form-group">
                <label for="senha">Senha</label>
                <input 
                    type="password" 
                    id="senha" 
                    name="senha" 
                    required 
                    placeholder="Digite sua senha"
                >
            </div>

            <div class="form-group">
                <button type="submit" class="btn-submit">Entrar</button>
            </div>

        </form>

        <?php require_once 'rodape.php'; ?>
