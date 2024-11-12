<?php
    include_once('cabecalho.php');

    if ((isset($_GET['id'])) && (is_numeric($_GET['id'])))
    {
        $id = $_GET['id'];
    } else if ((isset($_POST['id'])) && (is_numeric($_POST['id'])))
    {
        $id = $_POST['id'];
    } else
    {
        header("Location: folclore_menu.php");
        exit();
    }

    require_once('conexao.php');

    if (isset($_POST['enviou'])) {

            //SQL de exclusão
            $q = "DELETE FROM folclore 
                    WHERE id = $id";         
            $r = @mysqli_query($dbc, $q);
           
            if ($r) {
                $sucesso = "<h1><b>Sucesso!</b></h1>
                <p>Seu registro foi alterado com sucesso!</p>
                <p>Aguarde... Redirecionando!</p>";
                echo "<meta HTTP-EQUIV='refresh'
                    CONTENT='0;URL=folclore_menu.php'>";
            }
    }

    //pesquisa para exibir o registro para alteração
    $q = "SELECT * FROM folclore WHERE id = $id";
    $r = mysqli_query($dbc, $q);

    if (mysqli_num_rows($r) == 1)
    {
        $row = mysqli_fetch_array($r, MYSQLI_NUM);
    ?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">folclore - Exclusão</h1>      
    </div>

    <?php
        if (isset($sucesso))
        echo "<div class='alert alert-success'>
            $sucesso</div>";            
    ?>

    <form action="folclore_exc.php" method="post">
    <div class="row">
        <div class="col-md-9 form-group">
            <label>Nome</label>
            <input type="text" name="nome"
                class="form-control"
                maxlength="80"
                disabled
                placeholder="Digite o nome"
                value="<?php echo $row[1]; ?>" />
        </div>
    </div>

    <div class="row">
        <div class="col-md-9 form-group">
            <label>Descrição</label>
            <input type="text" name="descricao"
                class="form-control"
                maxlength="80"
                disabled
                placeholder="Escreva o terxto"
                value="<?php echo $row[2]; ?>" />
        </div>
    </div>

    <div class="row">
        <div class="col-md-9 form-group">
            <label>Tipo de produto</label>
            <input type="text" name="regiao"
                class="form-control"
                maxlength="80"
                disabled
                placeholder="Digite o país ou regiao de origem"
                value="<?php echo $row[3]; ?>" />
        </div>
    </div>
    </div>

    
    <div class="row">
        <div class="col-md-12 text-right">
            <a href="folclore_menu.php" 
               class="btn btn-secondary">Fechar sem salvar
            </a>

            <input type="submit" 
                class="btn btn-danger"
                value="Excluir" />
        </div>
    </div>
  <input type="hidden" name="enviou" value="true" />
  <input type="hidden" name="id" 
        value="<?php echo $row[0]; ?>" />
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
    }
    mysqli_close($dbc);
    include_once('rodape.php');
?>
