<?php require_once 'cabeçalho.php'; ?>

    <!-- parte principal tela de login -->
    <div class="login-container">
        

        <div class="login-header">
            <h1> PetShop Admin </h1>
            <h2>Acesso ao  Sistema</h2>
            <p> Informe suas credenciais para continuar</p>
        </div>

        <!-- formm -->
        <form action="login.php" method="POST" class="login-form">
            
            <div class="form-group">
                <label for="email">E-mail ou Usuário</label>
                <input 
                    type="email", id="email", name="email", required placeholder="exemplo@email.com"
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
