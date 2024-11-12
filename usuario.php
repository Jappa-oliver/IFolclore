<?php /*
    if ((isset($_GET['id'])) && (is_numeric($_GET['id'])))
    {
        $id = $_GET['id'];
    } else if ((isset($_POST['id'])) && (is_numeric($_POST['id'])))
    {
        $id = $_POST['id'];
    } else
    {
        header("Location: sobre.php");
        exit();
    }

    require_once('adm/conexao.php');

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
				if (empty($_POST['data_nasc'])) {
					$erros[] = "Você esqueceu de digitar a data de nascimento.";
			} else {
					$e = 
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

            //SQL de alteração
            $q = "UPDATE user SET
                    nome = '$n', 
                    email = '$e', 
                    senha = SHA1('IFSPWEB.$s',
										data_nasc = '$dt')
                    WHERE id = $id";         
            $r = @mysqli_query($dbc, $q);
           
            if ($r) {
                $sucesso = "<h1><b>Sucesso!</b></h1>
                <p>Seu registro foi alterado com sucesso!</p>
                <p>Aguarde... Redirecionando!</p>";
                echo "<meta HTTP-EQUIV='refresh'
                    CONTENT='3;URL=index.php'>";
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
    $q = "SELECT * FROM user WHERE id = $id";
    $r = mysqli_query($dbc, $q);

    if (mysqli_num_rows($r) == 1)
    {
        $row = mysqli_fetch_array($r, MYSQLI_NUM);*/
    ?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>IFolclore - Usuário</title>
	<link rel="stylesheet" href="css/usuario.css">

</head>

<body>

<?php
include_once("pages/navbar.html");
include_once("pages/menu_lateral.html");
?>
	<div class="h1">
		<h1>Bem vindo!</h1>
	</div>

	<div id="container">

		<div class="h2">
			<h2>Editar perfil:</h2>
		</div>

		<form action="">

			<div class="container2">
				<div class="input1">
					<span> Nome de Usuário:</span>
					<input type="text" name="nome" value="<?php echo $row[1]; ?>" class="box">
				</div>
				<div class="input2">
					<span>Email:</span>
					<input type="email" name="email" value="<?php echo $row[2]; ?>" class="box">

				</div>

				<div class="input3">
					<span>Data de Nascimento:</span>
					<input type="date" name="data_nasc" value="<?php echo $row[4]; ?>" class="box">
				</div>

				<div class="input4">
					<span>Senha atual:</span>
					<input type="password" name="senha_atual" placeholder="Entre com a senha atual" class="box">
				</div>

				<div class="input5">
					<span>Criar nova senha:</span>
					<input type="password" name="senha_nova" placeholder="Insira a nova senha" class="box">
				</div>

				<div class="input6">
					<span>Confirmar nova senha:</span>
					<input type="password" name="senha_confirmar" placeholder="Confira a nova senha" class="box">
				</div>


				<div class='btn'>
					<input type="submit" value="Atualizar Cadastro" name="update_profile" class="btn-input">

				</div>

			</div>


		</form>

	</div>
	</div>
    <?php
include('pages/footer.html');
?>
</body>

</html>

