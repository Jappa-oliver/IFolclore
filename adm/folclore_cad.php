<?php
    include_once('cabecalho.php');

    if (isset($_POST['enviou'])) {
        require_once('conexao.php');

        $erros = array();

        //Verifica se há um primeiro nome
        if (empty($_POST['nome'])) {
            $erros[] = "Você esqueceu de digitar o nome ou título.";
        } else {
            $n = 
            mysqli_real_escape_string($dbc, 
                trim($_POST['nome']));
        }

        //Verifica se há um e-mail
        if (empty($_POST['descricao'])) {
            $erros[] = "Você esqueceu de digitar o texto.";
        } else {
            $d = 
            mysqli_real_escape_string($dbc, 
                trim($_POST['descricao']));
        }

        if (empty($_POST['tipo_produto'])) {
            $erros[] = "Você esqueceu de digitar o país ou reigão de origem.";
        } else {
            $r = 
            mysqli_real_escape_string($dbc, 
                trim($_POST['regiao']));
        }

        if (empty($erros)) {

            //SQL de insercao
            $q = "INSERT INTO folclore 
                (nome, descricao, data_cad, regiao)
                VALUES ('$n','$d', NOW(), '$r')";
            
            $r = @mysqli_query($dbc, $q);

            if ($r) {
                $sucesso = "<h1><b>Sucesso!</b></h1>
                <p>Seu registro foi incluido com sucesso!</p>
                <p>Aguarde... Redirecionando!</p>";
                echo "<meta HTTP-EQUIV='refresh'
                    CONTENT='3;URL=folclore_menu.php'>";
            }
        } else {
            $erro = "<h1><b>Erro!</b></h1>
            <p>Ocorreram o(s) seguinte(s) erro(s):</p>";
            foreach ($erros as $msg) {
                $erro .= "- $msg <br />";
            }
            $erro .= "<p>Por favor, tente novamente.</p>";
        }
    }
    ?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Folclore - Cadastro</h1>      
    </div>

    <?php
        if (isset($erro))
        echo "<div class='alert alert-danger'>
            $erro</div>";

        if (isset($sucesso))
        echo "<div class='alert alert-success'>
            $sucesso</div>";            
    ?>

    <form action="folclore_cad.php" method="post">
    <div class="row">
        <div class="col-md-12 form-group">
            <label>Nome</label>
            <input type="text" name="nome"
                class="form-control"
                maxlength="80"
                placeholder="Digite o nome ou título da lenda/folclore"
                value="<?php if (isset($_POST['nome']))
                    echo $_POST['nome']; ?>" />
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 form-group">
            <label>Descrição</label>
            <input type="text" name="descricao"
                class="form-control"
                maxlength="100"
                placeholder="Escreva um texto falando sobre este folclore"
                value="<?php if (isset($_POST['descricao']))
                    echo $_POST['descricao']; ?>" />
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 form-group">
            <label>País ou região de origem</label>
            <input type="text" name="regiao"
                class="form-control"
                maxlength="100"
                placeholder="Digite o país ou a região de origem"
                value="<?php if (isset($_POST['regiao']))
                    echo $_POST['regiao']; ?>" />
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 text-right">
            <a href="folclore_menu.php" 
               class="btn btn-secondary">Fechar sem salvar
            </a>

            <input type="submit" 
                class="btn btn-primary"
                value="Salvar" />
        </div>
    </div>
  <input type="hidden" name="enviou" value="true" />
  </form>

  <div class="container-fluid">
  <div class="row">
    <nav id="sidebarMenu" class="light sidebar ">
      <?php 
        include_once('menu_lateral.php');
      ?>
    </nav>
</main>

<?php
    include_once('rodape.php');
?>
