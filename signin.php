<?php
require_once('adm/conexao.php');

session_start();

if (isset($_POST['email']) && isset($_POST['senha'])) {
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);

    if (empty($email)) {
        echo "Preencha o campo email";
    } elseif (empty($senha)) {
        echo "Preencha o campo senha";
    } else {
        // Usando prepared statements para evitar SQL Injection
        $stmt = $mysqli->prepare("SELECT * FROM user WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            // Verifica a senha usando password_verify
            if (password_verify($senha, $user['senha'])) {
                $_SESSION['id'] = $user['id'];
                $_SESSION['nome'] = $user['nome'];
                $_SESSION['email'] = $user['email'];

                header("Location: index.php");
                exit;
            } else {
                echo "Login inválido! Corrija seu email ou senha!";
            }
        } else {
            echo "Login inválido! Corrija seu email ou senha!";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/sign-in.css">
    <title>IFolclore - Login de Usuário</title>
</head>
<body>

<?php include('pages/navbar.html');
include('pages/menu_lateral.html');
        $page = 'sign-up';
    ?>

<script>
function validaForm() {
    if (document.login_form.email.value == "") {
        alert("Por favor, preencha o campo 'e-mail'");
        document.login_form.email.focus();
        return false;
    } else if (document.login_form.senha.value == "") {
        alert("Por favor, preencha o campo 'senha'");
        document.login_form.senha.focus();
        return false;
    }
    return true;
}
</script>

<div class="main-login">
    <div class="left-login">
        <h1>É bom ter você por aqui novamente!</h1>
        <img src="imagens/Logo.jpg" class="left-login-image" alt="">
    </div>

    <div class="right-login">
        <div class="card-login">
            <form name="login_form" action="signin.php" onsubmit="return validaForm();" method="post">
                <h1>Coloque suas informações para logar</h1>
                <div class="textfield">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="email" placeholder="Email">
                </div>
                <div class="textfield">
                    <label for="senha">Senha</label>
                    <input type="password" name="senha" class="senha" placeholder="Senha">
                </div>
                <button type="submit" class="btn-login">Entrar</button>
            </form>
            <p><a href="#">Esqueceu sua senha?</a></p>
            <p>Ainda não tem conta?<a href="signup.php"> Cadastre-se agora!</a></p>
        </div>
    </div>
</div>

<?php
include('pages/footer.html');
?>

</body>

</html>
