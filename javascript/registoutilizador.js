/* Parte do código que não tem a ver com AJAX */
/* Verificar se o input da email está vazio */
function verificarEmail() {
    var valor = document.getElementById("inputEmailRg").value;

    if(valor != "") {
        return 1;
    } else {
        return 0;
    }
}

/* Verificar se o input da password está vazio */
function verificarPassword() {
    var password = document.getElementById("inputPasswordRg").value;
    var passwordRe = document.getElementById("inputPasswordReRg").value;

    if(password != "") {
        document.getElementById("inputPasswordRg").style.border = "2px solid green";
        document.getElementById("spanPassword").innerHTML = "";
    } else {
        document.getElementById("inputPasswordRg").style.border = "2px solid red";
        document.getElementById("spanPassword").innerHTML = "Campo vazio";
    }
}

function verificarPasswordIgualP() {
    var password = document.getElementById("inputPasswordRg").value;
    var passwordRe = document.getElementById("inputPasswordReRg").value;

    if(passwordRe != "") {
        if(passwordRe == password) {
            document.getElementById("inputPasswordRg").style.border = "2px solid green";
            document.getElementById("spanPassword").innerHTML = "";

            document.getElementById("inputPasswordReRg").style.border = "2px solid green";
            document.getElementById("spanPasswordRe").innerHTML = "";
            document.getElementById("formPasswordDiv").className = "form-group";
        } else {
            document.getElementById("inputPasswordReRg").style.border = "2px solid red";
            document.getElementById("spanPasswordRe").innerHTML = "Passwords diferentes";
            document.getElementById("formPasswordDiv").className = "form-group mb-5";
        }
    }
}

/* Verificar se as passwords são iguais */
function verificarPasswordIgual() {
    var password = document.getElementById("inputPasswordRg").value;
    var passwordRe = document.getElementById("inputPasswordReRg").value;

    if(passwordRe != "") {
        if(password == passwordRe) {
            document.getElementById("inputPasswordReRg").style.border = "2px solid green";
            document.getElementById("spanPasswordRe").innerHTML = "";
            document.getElementById("formPasswordDiv").className = "form-group";
        } else {
            document.getElementById("inputPasswordReRg").style.border = "2px solid red";
            document.getElementById("spanPasswordRe").innerHTML = "Passwords diferentes";
            document.getElementById("formPasswordDiv").className = "form-group mb-5";
        }
    } else {
        document.getElementById("inputPasswordReRg").style.border = "2px solid red";
        document.getElementById("spanPasswordRe").innerHTML = "Campo vazio";
        document.getElementById("formPasswordDiv").className = "form-group mb-5";
    }
}

/* Ativar o botão no caso dos inputs não estarem vazios */
function ativarBotaoRegisto() {
    if(dadosEmailRegistoBtn(false) == 1) {
        if(document.getElementById("inputPasswordRg").value != "" && document.getElementById("inputEmailRg").value != "" && document.getElementById("inputPasswordReRg").value != "") {
            if(document.getElementById("inputPasswordRg").value == document.getElementById("inputPasswordReRg").value) {
                document.getElementById("btnRegisto").disabled = false;
                document.getElementById("formPasswordDiv").className = "form-group";
            } else {
                document.getElementById("btnRegisto").disabled = true;
            }
        } else {
            document.getElementById("btnRegisto").disabled = true;
        }
    } else {
        document.getElementById("btnRegisto").disabled = true;
    }
}

/* Parte do código relativo ao AJAX */
var http = getHTTPObject();

/*Inicio do codigo para fazer a ligação*/
function getHTTPObject() {
    http_request = false;
    if (window.XMLHttpRequest) { // Mozilla, Safari,...
        http_request = new XMLHttpRequest();

        if (http_request.overrideMimeType) {

            http_request.overrideMimeType('text/xml');
        }

    } else if (window.ActiveXObject) { // IE
        try {
            http_request = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            try {
                http_request = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (e) {}

        }
    }

    if (!http_request) {
        alert('Cannot create XMLHTTP instance');
        return false;
    } else{
        return http_request;
    }
}
/*Fim do codigo para fazer a ligação*/

/* Função para verificar se o email já existe na base de dados */
function verificarEmailRegistoAjax(flag) {
    /*
        flag = true --> para ser utilizada quando o utilizador passar para o outro input
        flag = false --> para ser utilizada quando o utilizador poder desbloquear o botão
    */

    var url = './ajax/verificarregisto.php';

    var poststr = "email=" + encodeURI(document.getElementById('inputEmailRg').value);

    http.open('POST', url, true);
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    if(flag) {
        http.onreadystatechange = dadosEmailRegisto;
    } else {
        http.onreadystatechange = dadosEmailRegistoBtn;
    }

    http.send(poststr);
}

function dadosEmailRegisto() {
    if (http.readyState == 4) {
        if (http.responseText.indexOf('invalid') == -1) {

            var resposta = JSON.parse(http.responseText);

            var existe = resposta.existe;

            if(verificarEmail() == 1) {
                /* Caso o email exista */
                if(existe == 1) {
                    document.getElementById("inputEmailRg").style.border = "2px solid red";
                    document.getElementById("spanEmail").innerHTML = "Email já registado";
                    document.getElementById("inputEmailRg").value = "";
                } else {
                    document.getElementById("inputEmailRg").style.border = "2px solid green";
                    document.getElementById("spanEmail").innerHTML = "";
                }
            } else {
                document.getElementById("inputEmailRg").style.border = "2px solid red";
                document.getElementById("spanEmail").innerHTML = "Campo vazio";
            }
        }
    }
}

function dadosEmailRegistoBtn() {
    if (http.readyState == 4) {
        if (http.responseText.indexOf('invalid') == -1) {

            var resposta = JSON.parse(http.responseText);

            var existe = resposta.existe;

            /* Caso o email exista (não pode utilizar) */
            if(existe == 1) {
                return 0;
            /* Caso o email não exista (pode utilizar) */
            } else {
                return 1;
            }
        }
    }
}
