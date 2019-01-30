<?php
    session_start();

    include('./bd/conf.php');
    include('./bd/bd.php');

    /* Includes relativos as classes do utilizador */
    include("./classes/classesuser.php");
    include("./classes/daouser.php");

    /* Includes relativos as classes de confirmação */
    include("./classes/classeconf.php");
    include("./classes/daoconf.php");

    $mydb = new bd();

    $user = new DAOUser($mydb->DBH);
    $conf = new DAOConf($mydb->DBH);

    /* Código para confirmar o utilizador na base de dados */
    /* Variáveis para confirmar o utilizador na base de dados */
    $codigo = 0;

    if(isset($_POST["btnConfirmar"])) {
        if(isset($_POST["inputCodigo"])) {
            if(!empty($_POST["inputCodigo"])) {
                $codigo = $_POST["inputCodigo"];
            }
        }

        $codigo_bd = $conf->obter_codigo_id($_SESSION["u_id"]);

        /* Se o código for igual ao código introduzido */
        if($codigo_bd > 0 && $codigo_bd == $codigo) {
            header("location: ./informacaoes/adicionarinformacaoes.php");
        } else {
            header("location: ./login.php");
        }

    }
?>

<!DOCTYPE html>
<html lang="pt">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href="./css/confirmarconta.css" rel="stylesheet">

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
            /* Verificar se o input se encontra vazio */
            function verificarCodigo() {
                var codigo = document.getElementById("inputCodigo").value;

                if(codigo != "") {
                    document.getElementById("inputCodigo").style.border = "2px solid green";
                    document.getElementById("spanCodigo").innerHTML = "";
                } else {
                    document.getElementById("inputCodigo").style.border = "2px solid red";
                    document.getElementById("spanCodigo").innerHTML = "Campo vazio";
                }
            }

            /* Verificar se o input possui o tamanho correto */
            function verificarCodigoTamanho() {
                var codigo = document.getElementById("inputCodigo").value;

                if(codigo.length == 4) {
                    document.getElementById("inputCodigo").style.border = "2px solid green";
                    document.getElementById("spanCodigo").innerHTML = "";
                } else {
                    document.getElementById("inputCodigo").style.border = "2px solid red";
                    document.getElementById("spanCodigo").innerHTML = "Código inválido";
                }
            }

            /* Ativar o botão de confirmação */
            function ativarBotão() {
                var codigo = document.getElementById("inputCodigo").value;

                if(codigo.length == 4 && codigo != "") {
                    document.getElementById("btnConfirmar").disabled = false;
                } else {
                    document.getElementById("btnConfirmar").disabled = true;
                }
            }
        </script>

        <div class="container centered">
            <h3 class="titulo">Confirmar conta</h3>

            <form id="formconfirmarconta" method="POST" action="confirmarconta.php">
                <div class="divcenter">
                    <div class="form-group">
                        <label for="inputCodigo" id="labelCodigo"><strong>Código:</strong></label>
                        <input type="text" class="inputs" id="inputCodigo" name="inputCodigo" onblur="verificarCodigo(); verificarCodigoTamanho(); ativarBotão();" placeholder="Código" required>
                        <span class="float-right spanErro mb-2" id="spanCodigo"></span>
                    </div>

                    <div class="divButton">
                        <button type="submit" class="btn btnConfirmar" id="btnConfirmar" name="btnConfirmar" disabled>Confirmar</button>
                    </div>

                    <div style="text-align:center">
                        <a href="login.php">Tem conta? Autentique-se agora</a>
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>
