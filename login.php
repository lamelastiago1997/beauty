<?php
    session_start();
    $_SESSION["u_id"] = 0;

    $password_erro = "";
    $email_erro = "";

    /* Includes relativos as classes da base de dados */
    include('./bd/conf.php');
    include('./bd/bd.php');

    /* Includes relativos as classes do utilizador */
    include("./classes/classesuser.php");
    include("./classes/daouser.php");

    /* Includes relativos as classes de confirmação */
    include("./classes/classeconf.php");
    include("./classes/daoconf.php");

    /* Includes relativos as classes de informações adicionais */
    include("./classes/daoinfoadd.php");
    include("./classes/classeinfoadd.php");

    $mydb = new bd();

    $user = new DAOUser($mydb->DBH);
    $conf = new DAOConf($mydb->DBH);
    $info_add = new DAOInfoAdd($mydb->DBH);

    /* Código para verificar o utilizador na base de dados */
    /* Variáveis para verificar o utilizador na base de dados */
    $email = $password = "";

    $id_utilizador = 0;
    $codigo = 0;
    $tipo_utilizador = 0;

    if(isset($_POST["btnLogin"])) {
        if(isset($_POST["inputEmailLg"])) {
            if(!empty($_POST["inputEmailLg"])) {
                $email = $_POST["inputEmailLg"];
            }
        }

        if(isset($_POST["inputPasswordLg"])) {
            if(!empty($_POST["inputPasswordLg"])) {
                $password = $_POST["inputPasswordLg"];
            }
        }


        /* Verificar se as credenciais estão corretas ou incorretas */
        $cred_check = $user->verificar_credenciais($email, $password);

        if($cred_check == 1) { /* Credencias de acesso estão corretas */
            $id_utilizador = $user->obter_id_email($email); /* Id do utilizador */

            if($user->verificar_estado_conta($email) == 1) { /* Conta ativada */
                if($info_add->verificar_existencia_dados($id_utilizador) == 1) { /* Existem dados pessoais */
                    $tipo_utilizador = $info_add->verificar_tipo_utilizador($id_utilizador); /* Obter o tipo de utilizador */

                    if($tipo_utilizador == 1) { /* Utilizador é um gabinete */
                        header("location: ./home/homegabinete.php");
                    } elseif($tipo_utilizador == 2) { /* Utilizador é um cliente */
                        header("location: ./home/homecliente.php");
                    }
                } elseif($info_add->verificar_existencia_dados($id_utilizador) == 0) { /* Não existem dadaos pessoais */
                    $_SESSION["u_id"] = $id_utilizador;
                    header("location: ./dadospessoais/adados.php"); /* Adicionar as informações pessoais */
                }
            } elseif($user->verificar_estado_conta($email) == 2) { /* Conta não ativada */
                $_SESSION["u_id"] = $id_utilizador;
                header("location: ./confirmarconta.php");
            }
        } elseif($cred_check == 2) { /* Password está incorreto */
            echo "<script>window.alert('errou')</script>";
        } elseif($cred_check == 0) { /* Email está incorreto */
            echo "<script>window.alert('errou')</script>";
        }
    }

?>

<!DOCTYPE html>
<html lang="pt">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href="./css/login.css" rel="stylesheet">

        <!-- Font para o titulo -->
        <link href="https://fonts.googleapis.com/css?family=Charmonman" rel="stylesheet">

        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

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
        <script>
            jQuery(document).ready(function() {
                /* Ativar o botão para ver a password */
                $( "#inputPasswordLg" ).focus(function() {
                    if( $("#inputPasswordLg").val()) {
                        $( "#tooglePassword" ).css( "display", "block" );
                    }
                });

                /* Desativar o botão quando o utilizador sai da password*/
                $( "#inputPasswordLg" ).focusout(function() {
                  $( "#tooglePassword" ).css( "display", "none" );
                });
            });

            /* Verificar se o input da email está vazio */
            function verificarEmail() {
                var valor = document.getElementById("inputEmailLg").value;

                if(valor != "") {
                    document.getElementById("inputEmailLg").style.border = "2px solid green";
                    document.getElementById("spanEmail").innerHTML = "";
                } else {
                    document.getElementById("inputEmailLg").style.border = "2px solid red";
                    document.getElementById("spanEmail").innerHTML = "Campo vazio";
                }
            }

            /* Verificar se o input da password está vazio */
            function verificarPassword() {
                var password = document.getElementById("inputPasswordLg").value;

                if(password != "") {
                    document.getElementById("inputPasswordLg").style.border = "2px solid green";
                    document.getElementById("spanPassword").innerHTML = "";
                    document.getElementById("formPasswordDiv").className = "form-group";
                } else {
                    document.getElementById("inputPasswordLg").style.border = "2px solid red";
                    document.getElementById("spanPassword").innerHTML = "Campo vazio";
                    document.getElementById("formPasswordDiv").className = "form-group divPassword";
                }
            }

            /* Ativar o botão no caso dos inputs não estarem vazios */
            function ativarBotaoLogin() {
                if(document.getElementById("inputPasswordLg").value != "" && document.getElementById("inputEmailLg").value != "") {
                    document.getElementById("btnLogin").disabled = false;
                    document.getElementById("formPasswordDiv").className = "form-group";
                } else {
                    document.getElementById("btnLogin").disabled = true;
                }
            }
        </script>

        <div class="container centered">
            <h1 class="titulo">Beauty</h1>

            <form id="formlogin" method="POST" action="./login.php">
                <div class="divcenter">
                    <div class="form-group">
                        <label for="inputEmail" id="labelEmail"><strong>Email</strong></label>
                        <input type="email" class="inputs" id="inputEmailLg" name="inputEmailLg" onblur="verificarEmail(); ativarBotaoLogin();" placeholder="Email" required>
                        <span class="float-right spanErro mb-2" id="spanEmail"><?php echo $email_erro; ?></span>
                    </div>

                    <div class="form-group" id="formPasswordDiv">
                        <label for="inputPassword" id="labelPassword"><strong>Password:</strong></label>
                        <input type="password" class="inputs" id="inputPasswordLg" name="inputPasswordLg" input="inputPasswordLg" onblur="verificarPassword(); ativarBotaoLogin();" placeholder="Password" required>
                        <span class="float-right spanErro mb-2" id="spanPassword"><?php echo $password_erro; ?></span>
                    </div>

                    <div class="divButton">
                        <button type="submit" class="btn btnLogin" id="btnLogin" name="btnLogin" disabled>Login</button>
                    </div>

                    <div class="divcenter link" style="text-align:center">
                        <a href="./registo.php">Sem conta? Registe-se agora</a>
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>
