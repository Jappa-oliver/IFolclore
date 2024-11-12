<?php
    include_once('cabecalho.php');

    require_once('conexao.php');

    //Numero de registros por pagina
    $exiba = 10;

    //Captura a busca
    $where = mysqli_real_escape_string($dbc, 
        trim(isset($_GET['q'])) ? $_GET['q'] : '');

    //Determina quantas paginas existem
    if (isset($_GET['p']) && is_numeric($_GET['p']))
    {
        $pagina = $_GET['p'];
    } else {
        //Conta Qtd de registros
        $q = "SELECT COUNT(id) 
            FROM folclore
            WHERE nome LIKE '%$where%'";
        $r = @mysqli_query($dbc, $q);
        $row = @mysqli_fetch_array($r, MYSQLI_NUM);
        $qtde = $row[0];

        //Calcula o numero de pagina
        if ($qtde > $exiba)
        {
            $pagina = ceil($qtde / $exiba);
        } else 
        {
            $pagina = 1;
        }
    }

    //Determina uma posição no BD para começar a
    //retornar os resultados
    if (isset($_GET['s']) && is_numeric($_GET['s']))
    {
        $inicio = $_GET['s'];
    } else {
        $inicio = 0;
    }

    //Determina a ordenação por padrão é Código
    $ordem = isset($_GET['ordem']) ? 
        $_GET['ordem'] : 'id';

    //Determina a ordem de classificação
    switch ($ordem)    
    {
        case 'id':
            $order_by = 'id';
            break;
        case 'n':
            $order_by = 'nome';
            break;
        case 'r':
            $order_by = 'regiao';
            break;
        case 'dc':
            $order_by = 'data_cad';
            break;
        default:
            $order_by = 'id';
            $order = 'id';                       ;
        break;
    }

    $q = "SELECT id, nome, regiao, data_cad
          FROM folclore
          WHERE nome LIKE '%$where%' 
          ORDER BY $order_by
          LIMIT $inicio, $exiba";
    $r = @mysqli_query($dbc, $q);

    if (mysqli_num_rows($r) > 0)
    {
        $saida = '<div class="table-responsive col-md-12">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th width="10%" class="text-center"><b>
                    <a href="folclore_menu.php?ordem=id">Código</a></b></th>
                    <th width="25%"><b>
                    <a href="folclore_menu.php?ordem=n">Nome</a></b></th>
                    <th width="25%"><b>
                    <a href="folclore_menu.php?ordem=p">Origem</a></b></th>
                    <th width="20%"><b>
                    <a href="folclore_menu.php?ordem=e">Data de Cadastro</a></b></th>
                    <th width="20%" class="text-center"><b>Açoes</b></th>
                </tr>
            </thead>
        </tbody>
        ';

        while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC))
        {
            $saida .= '<tr>
                <td class="text-center">' . $row['id'] . '</td>
                <td>' . $row['nome'] . '</td>
                <td>' . $row['regiao'] . '</td>
                <td>' . $row['data_cad'] . '</td>
                <td class="text-center">
                    <a href="folclore_alt.php?id=' .
                        $row['id'] . '" 
                        class="btn btn-sm btn-warning">
                        Editar
                    </a>
                    <a href="folclore_exc.php?id=' .
                        $row['id'] . '" 
                        class="btn btn-sm btn-danger">
                        Excluir
                    </a>
                </td>
            </tr>';
        }
        $saida .= '</tbody></table></div>';
    } else {
        $saida = "<div class='col-md-12'>
        <div class='alert alert-warning'>
        Sua pesquisa por <b>$where</b>
        não encontrou nenhum resultado.<br />
        <b>Dicas</b><br />
        - Tente palavras menos especificas.<br />
        - Tente palavras chaves diferentes.<br />
        - Confira a ortografia das palavras e se
        ela foram acentuadas corretamente.
        </div></div>";
    }

    //PAGINAÇÃO
    if ($pagina > 1)
    {
        $pag = '';
        $pagina_correta = ($inicio / $exiba) + 1;

        //Botão Anterior
        if ($pagina_correta != 1)
        {
            $pag .= '<li class="page-item">
            <a class="page-link" href="folclore_menu.php?s=' .
            ($inicio - $exiba) . '&p=' . $pagina . 
            '&ordem=' . $ordem . '&q=' . $where . '">Anterior</a></li>';
        } 
        else 
        {
            $pag .= '<li class="page-item disabled">
            <a class="page-link">Anterior</a></li>';
        }

        //Todas as páginas
        for ($i = 1; $i <= $pagina; $i++)
        {
            if ($pagina_correta != $i)
            {
            $pag .= '<li class="page-item">
            <a class="page-link" href="folclore_menu.php?s=' .
            ($exiba * ($i - 1)) . '&p=' . $pagina . 
            '&ordem=' . $ordem . '&q=' . $where . '">' . $i . '</a></li>';
            } 
            else 
            {
            $pag .= '<li class="page-item active">
            <a class="page-link">' . $i . '</a></li>';
            }
        }

        //Botão Próximo
        if ($pagina_correta != $pagina)
        {
            $pag .= '<li class="page-item">
            <a class="page-link" href="folclore_menu.php?s=' .
            ($inicio + $exiba) . '&p=' . $pagina . 
            '&ordem=' . $ordem . '&q=' . $where . '">Próximo</a></li>';
        } 
        else 
        {
            $pag .= '<li class="page-item disabled">
            <a class="page-link">Próximo</a></li>';
        }
    }
?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Folclore</h1>    
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="input-group mb-3">
                <input type="text" class="form-control"
                placeholder="Pesquise o nome da lenda/folclore cadastrado"
                id="busca">
                <div class="input-group-append">
                    <a class="btn btn-primary" 
                        href="#"
                        onclick="this.href='folclore_menu.php?q='+
                        document.getElementById('busca').value">
                        Pesquisar
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-4 text-right">
            <a href="folclore_menu.php"
                class="btn btn-primary">
                Cadastrar Lenda
            </a>
        </div>
    </div>

    <div class="row">
        <?php echo $saida; ?>
    </div>

    <div class='row'>
        <div class='col-md-12'>
        <ul class='pagination justify-content-end'>
            <?php if (isset($pag)) echo $pag; ?>
        </ul>
        </div>
    </div>
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