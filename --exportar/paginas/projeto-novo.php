

<div class="form-container">
  <h2>Criar novo projeto</h2>
  <form class="novoCadastro" action="?pg=projeto-back-cadastrar" method="POST">

    <div class="input-group">
      <input type="text" name="nome_projeto" id="nome_projeto" required placeholder=" " />
      <label for="nome_projeto">Nome do Projeto</label>
    </div>

    <div class="input-group">
      <input type="text" name="diretorio_projeto" id="diretorio_projeto" required placeholder=" " />
      <label for="diretorio_projeto">Diretório do Projeto</label>
    </div>

    <div class="input-group">
      <input type="date" name="data_criacao" id="data_criacao" required placeholder=" " />
      <label for="data_criacao">Data de Criação</label>
    </div>

      <button type="submit" class="submit-btn">Criar Projeto</button>


    <label class="formErro" style="display:none;" for="erro">Erro! falha ao cadastrar!</label>
  </form>
</div>

<script>
  document.getElementById('nome_projeto').focus();
  // Preenche a data atual no campo de data
  const dataInput = document.getElementById('data_criacao');
  const hoje = new Date();
  const dataFormatada = hoje.toISOString().split('T')[0];
  dataInput.value = dataFormatada;

  var bntEnviar = new ClassId('.submit-btn');
  var formErro = new ClassId('.formErro');
  new Formulario('.novoCadastro',
    () => {
      bntEnviar.attr('style','display:none;');
  },
    (res) => {
      if (res.ok) {
        window.location.href='?pg=projeto-listar';
      } else {
        bntEnviar.attr('style','display:block;');
        formErro.attr('style','display:none');

    }
  });


</script>
