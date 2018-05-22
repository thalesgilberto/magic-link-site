<?php
require 'seguranca.php';
require_once 'pessoa.php';
require_once 'planos_pessoa.php';

$p = new Pessoa();
$planos_pessoa = new Planos_pessoa();

$dados_boleto = $planos_pessoa->listar_boleto_pessoa($_SESSION["id_pessoa_cliente"]);
$dados = $p->mostrar_dados_pessoa($_SESSION["id_pessoa_cliente"]);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Magic LINK</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="icon" href="imagens/logo_magic.ico" type="image/x-icon" />
        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" href="scripts/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="scripts/bower_components/font-awesome/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="scripts/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="scripts/css/AdminLTE.min.css">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="scripts/css/skins/skin-blue.min.css">
        <link href="scripts/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css"/>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Google Font -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    </head>
    <!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
    <body class="hold-transition skin-blue layout-top-nav">
        <div class="wrapper">

            <header class="main-header">
                <nav class="navbar navbar-static-top" style="background-color: black">
                    <div class="container">
                        <div class="navbar-header">
                            <a href="#" class="logo-lg"><img src="imagens/logo_magic.png" height="60"></a>
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                                <i class="fa fa-bars"></i>
                            </button>
                        </div>
                        <!-- /.navbar-collapse -->
                        <!-- Navbar Right Menu -->
                        <div class="navbar-custom-menu">
                            <ul class="nav navbar-nav">
                                <!-- User Account Menu -->
                                <li class="dropdown user user-menu">
                                    <!-- Menu Toggle Button -->
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        <!-- The user image in the navbar-->
                                        <img src="imagens/default.jpg" class="user-image" alt="User Image">
                                        <!-- hidden-xs hides the username on small devices so only the image appears. -->
                                        <span class="hidden-xs"><?= $_SESSION['nome_cliente'] ?></span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <!-- The user image in the menu -->
                                        <li class="user-header" style="background-color: black">
                                            <img src="imagens/default.jpg" class="img-circle" alt="User Image">
                                            <p>
                                                <?= $_SESSION['nome_cliente'] ?>
                                                <small><?= $_SESSION['email_cliente'] ?></small>
                                            </p>
                                        </li>
                                        <!-- Menu Footer-->
                                        <li class="user-footer">
                                            <div class="pull-right">
                                                <a href="login.php" class="btn btn-default btn-flat">
                                                    <i class="fa fa-sign-out"></i>&nbsp;Sair
                                                </a>
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </header>
            <div class="content-wrapper">
                <div class="container">
                    <section class="content-header">
                        <h1>
                            Lista de boletos
                            <small>Boletos do cliente</small>
                        </h1>
                    </section>
                    <section class="content">
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title"><?= $_SESSION['id_pessoa_cliente'] . " - " . $_SESSION['nome_cliente'] ?></h3>
                            </div>
                            <div class="box-body">
                                <div class="table" style="height: 400px; width: auto ; overflow-y: scroll">
                                    <table id="listar_boleto_tabela" class="table table-striped table-responsive">
                                        <thead>
                                            <tr>
                                                <th>
                                                    Plano
                                                </th>
                                                <th>
                                                    Data de vencimento
                                                </th>
                                                <th>
                                                    Valor R$
                                                </th>
                                                <th>

                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($dados_boleto as $item) {
                                                $data_vencimento_boleto = date_create($item[3]);
                                                ?>
                                                <tr>
                                                    <td>
                                                        <?= $item[6] ?>
                                                    </td>
                                                    <td>
                                                        <?= date_format($data_vencimento_boleto, 'd/m/Y') ?>
                                                    </td>
                                                    <td>
                                                        <?="R$" . $item[7]?>
                                                    </td>
                                                    <td>
                                                        <a href="boleto/boleto_bradesco.php?b=<?= $item[0] ?>" target="_blank" class="btn btn-sm btn-default" title="Imprimir boleto"><i class="fa fa-print"></i></a>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            <footer class="main-footer text-center">
                <!-- Default to the left -->
                <strong>Copyright &copy; <?= date('Y') ?> <a>Magic LINK</a>.</strong> Todos os direitos reservados.
            </footer>
        </div>
        <!-- ./wrapper -->

        <!-- jQuery 3 -->
        <script src="scripts/js/jquery.min.js"></script>
        <!-- Bootstrap 3.3.7 -->
        <script src="scripts/js/bootstrap.min.js"></script>
        <!-- AdminLTE App -->
        <script src="scripts/js/adminlte.min.js"></script>
        <script src="scripts/js/dataTables.bootstrap.min.js" type="text/javascript"></script>
        <script src="scripts/js/jquery.dataTables.min.js" type="text/javascript"></script>
        <script>
            $(document).ready(function () {
                $('#listar_boleto_tabela').DataTable({
                    "bInfo": false,
                    "bSort": false,
                    "bLengthChange": false,
                    "bPaginate": false,
                    "oLanguage": {
                        "sProcessing": "Processando...",
                        "sLengthMenu": "Mostrar _MENU_ registros",
                        "sZeroRecords": "Nenhum registro correspondente encontrado",
                        "sEmptyTable": "Não há dados para serem mostrados",
                        "sLoadingRecords": "Carregando...",
                        "sInfo": "Mostrando de _START_ a _END_ de _TOTAL_ registros",
                        "sInfotEmpty": "Mostrando 0 até 0 de 0 registros",
                        "sInfoFiltered": "(filtro aplicado em _MAX_ registros)",
                        "sInfoThousands": ".",
                        "sSearch": "Pesquisar:",
                        "sUrl": "",
                        "oPaginate": {
                            "sFirst": "Primeiro",
                            "sPrevious": "Anterior",
                            "sNext": "Próximo",
                            "sLast": "Último"
                        }
                    }
                });
            });
        </script>
    </body>    
</html>


