<?php require_once 'cabeçalho.php'; ?>

<section class="form-section">
    <h2>Cadastrar / Editar Espécie</h2>

    <form action="especies.php" method="POST" class="especie-form">
        
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