<?php
    include_once('cabecalho.php');

    if (isset($_POST['enviou'])) {
        require_once('conexao.php');

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

        if (empty($_POST['data_nasc'])) {
            $erros[] = "Você esqueceu de digitar uma data de nascimento.";
        } else {
            $dn = 
            mysqli_real_escape_string($dbc, 
                trim($_POST['data_nasc']));
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

            //SQL de insercao
            $q = "INSERT INTO user 
                (nome, email, senha, , data_nasc, data_cad)
                VALUES ('$n','$e', SHA1('IFSPWEB.$s'), '$dn', NOW())";
            
            $r = @mysqli_query($dbc, $q);

            if ($r) {
                $sucesso = "<h1><b>Sucesso!</b></h1>
                <p>Seu registro foi incluido com sucesso!</p>
                <p>Aguarde... Redirecionando!</p>";
                echo "<meta HTTP-EQUIV='refresh'
                    CONTENT='3;URL=user_menu.php'>";
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
        <h1 class="h2">Usuários - Cadastro</h1>      
    </div>

    <?php
        if (isset($erro))
        echo "<div class='alert alert-danger'>
            $erro</div>";

        if (isset($sucesso))
        echo "<div class='alert alert-success'>
            $sucesso</div>";            
    ?>

    <form action="user_cad.php" method="post">
    <div class="row">
        <div class="col-md-12 form-group">
            <label>Nome</label>
            <input type="text" name="nome"
                class="form-control"
                maxlength="80"
                placeholder="Digite o seu nome"
                value="<?php if (isset($_POST['nome']))
                    echo $_POST['nome']; ?>" />
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 form-group">
            <label>E-mail</label>
            <input type="email" name="email"
                class="form-control"
                maxlength="100"
                placeholder="Digite o seu e-mail"
                value="<?php if (isset($_POST['email']))
                    echo $_POST['email']; ?>" />
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 form-group">
            <label>Data de Nascimento</label>
            <input type="date" name="data_nasc"
                class="form-control"
                maxlength="100"
                placeholder="Digite a sua data de nascimento"
                value="<?php if (isset($_POST['data_nasc']))
                    echo $_POST['data_nasc']; ?>" />
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 form-group">
            <label>Senha</label>
            <input type="password" name="senha1"
                class="form-control"
                maxlength="20"
                placeholder="Digite a sua senha" />
        </div>

        <div class="col-md-6 form-group">
            <label>Confirme a Senha</label>
            <input type="password" name="senha2"
                class="form-control"
                maxlength="20"
                placeholder="Digite a sua senha" />
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 text-right">
            <a href="user_menu.php" 
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
