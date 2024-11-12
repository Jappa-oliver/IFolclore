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
        header("Location: adm_menu.php");
        exit();
    }

    require_once('conexao.php');

    if (isset($_POST['enviou'])) {

        $erros = array();

        //Verifica se há um primeiro nome
        if (empty($_POST['nome'])) {
            $erros[] = "Você esqueceu de digitar um nome.";
        } else {
            $n = 
            mysqli_real_escape_string($dbc, 
                trim($_POST['nome']));
        }

        //Verifica se há um e-mail
        if (empty($_POST['email'])) {
            $erros[] = "Você esqueceu de digitar um e-mail.";
        } else {
            $e = 
            mysqli_real_escape_string($dbc, 
                trim($_POST['email']));
        }

        //Verifica se há uma senha e testa a confirmação
        if (!empty($_POST['senha1'])) {
            if ($_POST['senha1'] != $_POST['senha2']) {
                $erros[] = "Sua senha não confere com à 
                confirmação";
            } else {
                $s = mysqli_real_escape_string($dbc, 
                trim($_POST['senha1']));
            }
        } else {
            $erros[] = "Você esqueceu de digitar uma senha.";
        }

        if (empty($erros)) {           

            //SQL de alteração
            $q = "UPDATE adm SET
                    nome = '$n', 
                    email = '$e', 
                    senha = SHA1('IFSPWEB.$s')
                    WHERE id = $id";         
            $r = @mysqli_query($dbc, $q);
           
            if ($r) {
                $sucesso = "<h1><b>Sucesso!</b></h1>
                <p>Seu registro foi alterado com sucesso!</p>
                <p>Aguarde... Redirecionando!</p>";
                echo "<meta HTTP-EQUIV='refresh'
                    CONTENT='3;URL=adm_menu.php'>";
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

    //pesquisa para exibir o registro para alteração
    $q = "SELECT * FROM adm WHERE id = $id";
    $r = mysqli_query($dbc, $q);

    if (mysqli_num_rows($r) == 1)
    {
        $row = mysqli_fetch_array($r, MYSQLI_NUM);
    ?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Administrador - Alteração</h1>      
    </div>

    <?php
        if (isset($erro))
        echo "<div class='alert alert-danger'>
            $erro</div>";

        if (isset($sucesso))
        echo "<div class='alert alert-success'>
            $sucesso</div>";            
    ?>

    <form action="adm_alt.php" method="post">
    <div class="row">
        <div class="col-md-9 form-group">
            <label>Nome</label>
            <input type="text" name="nome"
                class="form-control"
                maxlength="80"
                placeholder="Digite o seu nome"
                value="<?php echo $row[1]; ?>" />
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 form-group">
            <label>E-mail</label>
            <input type="email" name="email"
                class="form-control"
                maxlength="100"
                placeholder="Digite o seu e-mail"
                value="<?php echo $row[2]; ?>" />
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 form-group">
            <label>Senha</label>
            <input type="password" name="senha1"
                class="form-control"
                maxlength="20"
                placeholder="Digite a sua senha" />
        </div>

        <div class="col-md-4 form-group">
            <label>Confirme a Senha</label>
            <input type="password" name="senha2"
                class="form-control"
                maxlength="20"
                placeholder="Digite a sua senha" />
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 text-right">
            <a href="adm_menu.php" 
               class="btn btn-secondary">Fechar sem salvar
            </a>

            <input type="submit" 
                class="btn btn-warning"
                value="Salvar" />
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
