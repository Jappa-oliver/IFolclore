<?php

require_once('adm/conexao.php');


    if(isset($_POST['email']) || isset($_POST['senha']))
    {
    //Verificar se os campos estão preenchidos

    if(strlen($_POST['email']) == 0)
    {
        echo "Preencha o campo email";
    }
    else if(strlen($_POST['senha']) == 0)
    {
        echo "Preencha o campo senha";
    }
    else if(strlen($_POST['confirmarSenha']) == 0)
    {
        echo "Confirme sua senha";
    }
    else if($_POST['senha'] != $_POST['confirmarSenha']){
        echo "As senhas digitadas são diferentes!";
    }
    else
    {
        $nome = $mysqli->real_escape_string($_POST['nome']);
        $email = $mysqli->real_escape_string($_POST['email']);
        $senha = $mysqli->real_escape_string($_POST['senha']);

        $mysqliCode = "INSERT INTO user (nome, email, senha) VALUES ('$nome', '$email', '$senha')";
        $mysqliQuery = $mysqli->query($mysqliCode) or die("Falha ao executar requisição");
    }
    
    }

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/sign-up.css">
    <title>IFolclore - Cadastro de Usuário</title>
</head>
<body>
<?php include('pages/navbar.html');
include('pages/menu_lateral.html');
        $page = 'sign-up';
    ?>
   

    <script>

    function validaForm() {
            
        if(document.cad_form.nome.value == ""){
            alert("Por favor, preencha o campo 'nome'");
            cad_form.nome.focus();
            return false;
        }
        else if(document.cad_form.email.value == ""){
            alert("Por favor, preencha o campo 'e-mail'");
            cad_form.email.focus();
            return false;
        }
        else if(document.cad_form.senha.value == ""){
            alert("Por favor, preencha o campo 'senha'");
            cad_form.senha.focus();
            return false;
        }
        else if(document.cad_form.cofirmarSenha.value == ""){
            alert("Por favor, preencha o campo 'Confirme senha'");
            cad_form.confirmarSenha.focus();
            return false;
        }
        
            return true;
    }

    </script>

    <div class="main-signup">

        <div class="right-signup">
            <div class="card-signup">

                <form name="cad_form" action="signup.php" onsubmit="return validaForm(this);" method="post">


                <br>
                <br> 

                    <h1>Coloque suas informações para cadastrar-se</h1>
            
                    <div class="textfield">
                        <label for="" class="nome">Nome</label>
                        <input type="text" name="nome" class="nome" placeholder="Digite seu nome">
                    </div>            
                        
                    <div class="textfield">
                        <label for="" class="email">Email</label>
                        <input type="email" name="email" class="email" placeholder="Digite seu e-mail">
                    </div>
                                
                    <div class="textfield">
                        <label for="" class="senha">Senha</label>
                        <input type="password" name="senha" class="senha" placeholder="Digite uma senha">
                    </div>
                        
                    <div class="textfield">
                        <label for="" class="confirmarSenha">Confirme a Senha</label>
                        <input type="password" name="confirmarSenha" class="confirmarSenha" placeholder="Confirme sua senha">
                    </div>
<div class="botao">

<button type="submit" class="btn-signup">Cadastre-se</button>
</div>

                    

                </form>

                <p class="texto">Já tem conta?<a href="signin.php" class="link"> Logue agora!</a></p>

            </div>       
        </div>
    </div>

    <script>
        const list = document.querySelectorAll('.list');
        function activeLink() {
            list.forEach((item) =>
                item.classList.remove('active'));
            this.classList.add('active');
        }
        list.forEach((item) =>
            item.addEventListener('click', activeLink));
    </script>
    <?php
include('pages/footer.html');
?>
</body>
</html>
