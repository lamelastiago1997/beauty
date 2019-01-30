<?php
    session_start();

    /* Includes relativos as classes da base de dados */
    include('./bd/conf.php');
    include('./bd/bd.php');

    /* Includes relativos as classes do utilizador */
    include("./classes/classesuser.php");
    include("./classes/daouser.php");

    /* Includes relativos as classes de confirmação */
    include("./classes/classeconf.php");
    include("./classes/daoconf.php");

    /* Include relativo a classe de email */
    include("./classes/email.php");

    $mydb = new bd();

    $user = new DAOUser($mydb->DBH);
    $conf = new DAOConf($mydb->DBH);

    /* Código para registar na base de dados */
    /* Variáveis para registar na base de dados */
    $email = $password = $password_re = "";

    $u_id = 0;
    $codigo = 0;

    if(isset($_POST["btnRegisto"])) {
        if(isset($_POST["inputEmailRg"])) {
            if(!empty($_POST["inputEmailRg"])) {
                $email = $_POST["inputEmailRg"];
            }
        }

        if(isset($_POST["inputPasswordRg"])) {
            if(!empty($_POST["inputPasswordRg"])) {
                $password = $_POST["inputPasswordRg"];
            }
        }

        if(isset($_POST["inputPasswordReRg"])) {
            if(!empty($_POST["inputPasswordReRg"])) {
                $password_re = $_POST["inputPasswordReRg"];
            }
        }

        /* Confirmar que o email não existe na base de dados */
        if($user->verificar_email_reg($email) == 0) {
            /* Confirmar que as passwords são mesmo iguais */
            if($password == $password_re) {
                /* Inserir utilizador na base de dados */
                if($user->inserir_utilizador(new User($email, $password)) == 1) {
                    /* Obter o id do utilizador*/
                    $u_id = $user->obter_ultimo_registo();

                    if($u_id != 0) {
                        if($conf->inserir_codigo(new Conf($u_id)) == 1) {
                            $codigo = $conf->obter_codigo_id($u_id);
                            header("location: ./login.php");

                            /*
                            if($codigo != 0 && $codigo != -1) {
                                $email = new Email($email, $codigo);

                                 Compor esta parte
                                if($email->enviar_email() == 1) {
                                    header("location: ./login.php");
                                }
                            }
                            */
                        }
                    }
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="pt">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href="./css/registo.css" rel="stylesheet">

        <!-- Font para o titulo -->
        <link href="https://fonts.googleapis.com/css?family=Charmonman" rel="stylesheet">

        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
        <script src="./javascript/registoutilizador.js"></script>

        <link rel="shortcut icon" href="imagens/favicon.ico" type="image/x-icon">
        <link rel="icon" href="imagens/favicon.ico" type="image/x-icon">


        <title>Beauty</title>

        <style>
            /* CSS para o link do registo */
            a:link, a:visited {
                font-size: 16px;
                color: grey;
                padding-top: 5px;
                text-decoration: underline;
                display: inline-block;
            }

            a:hover, a:active {
                color: #686868;
            }
        </style>

    </head>

    <body>
        <div class="container centered">
            <h1 class="titulo">Beauty</h1>

            <form id="formlogin" method="POST" action="registo.php">
                <div class="divcenter">
                    <div class="form-group">
                        <label for="inputEmail" id="labelEmail"><strong>Email</strong></label>
                        <input type="email" class="inputs" id="inputEmailRg" name="inputEmailRg" onblur="verificarEmailRegistoAjax(true); ativarBotaoRegisto();" placeholder="Email">
                        <span class="float-right spanErro mb-2" id="spanEmail"></span>
                    </div>

                    <div class="form-group">
                        <label for="inputPassword" id="labelPassword"><strong>Password:</strong></label>
                        <input type="password" class="inputs" id="inputPasswordRg" input="inputPasswordRg" name="inputPasswordRg" onblur="verificarPasswordIgualP(); verificarPassword(); ativarBotaoRegisto();" placeholder="Password">
                        <span class="float-right spanErro mb-2" id="spanPassword"></span>
                    </div>

                    <div class="form-group mb-3" id="formPasswordDiv">
                        <label for="inputPasswordRe" id="labelPasswordRe"><strong>Repetir a password:</strong></label>
                        <input type="password" class="inputs" id="inputPasswordReRg" input="inputPasswordReRg" name="inputPasswordReRg" onblur="verificarPasswordIgual(); verificarPassword(); ativarBotaoRegisto();" placeholder="Password">
                        <span class="float-right spanErro" id="spanPasswordRe"></span>
                    </div>

                    <div class="divButton">
                        <button type="subtmit" class="btn btnRegisto" id="btnRegisto" name="btnRegisto" disabled>Registar</button>
                    </div>

                    <div style="text-align:center">
                        <a href="login.php">Tem conta? Autentique-se agora</a>
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>
