<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Magic LINK | Log in</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="icon" href="imagens/logo_magic.ico" type="image/x-icon" />
        <link rel="shortcut icon" href="img/logo_magic.ico" type="image/x-icon" />
        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" href="scripts/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="scripts/bower_components/font-awesome/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="scripts/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="scripts/css/AdminLTE.min.css">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="hold-transition login-page" style="background-color: black" >
        <div class="login-box">
            <div class="login-logo">
                <!--                <a href="#"><b>Magic</b> LINK</a>-->
                <img src="imagens/logo_magic.png" style="height: 200px"/>
            </div>
            <!-- /.login-logo -->
            <div class="login-box-body">
                <p class="login-box-msg">Faça login para iniciar sua sessão</p>
                <?php
                if (isset($_SESSION['login-erro'])) {
                    ?>
                    <div class = "alert alert-danger alert-dismissible text-center">
                        <button type = "button" class = "close" data-dismiss = "alert" aria-hidden = "true">&times;
                        </button>
                        <h4><i class = "icon fa fa-ban"></i> Atenção!</h4>
                        <?= $_SESSION['login-erro'] ?>
                    </div>
                    <?php
                    session_destroy();
                } else {
                    session_destroy();
                }
                ?>
                <form action="validar_usuario.php" method="post">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                        <input type="email" id="email" name="email" class="form-control" required="required" placeholder="Email">
                    </div>
                    <br/>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-lock" style="font-size: 20px"></i></span>
                        <input type="password" id="senha" name="senha" class="form-control" required="required" placeholder="Senha">
                    </div>
                    <br/>
                    <br/>
                    <div class="row">
                        <!-- /.col -->
                        <div class="col-xs-12">
                            <!--            <a class="btn btn-primary btn-block btn-flat" href="views/cadastro-pessoa.php">Login</a>-->
                            <button type="submit" class="btn btn-primary btn-block btn-flat">Login</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
            </div>
            <!-- /.login-box-body -->
        </div>
        <!-- /.login-box -->

        <!-- jQuery 3 -->
        <script src="scripts/js/jquery.min.js"></script>
        <!-- Bootstrap 3.3.7 -->
        <script src="scripts/js/bootstrap.min.js"></script>
    </body>
</html>
