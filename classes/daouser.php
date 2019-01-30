<?php
    class DAOUser {
        private $DBH;

        public function __construct($a_DBH) {
            $this->DBH = $a_DBH;
        }

        /* Método para verificar se o email já existe registado na base de dados */
        public function verificar_email_reg($a_u_email) {
            /*
                1 -> Se existe
                0 -> Não existe
                -1 -> Variavel undifined
            */
            if(!empty($a_u_email) && $a_u_email != "" && !is_null($a_u_email)) {
                try {
                    $STH = $this->DBH->prepare("SELECT * FROM utilizadores WHERE u_email= ?");

                    $STH->bindParam(1, $u_email);

                    $u_email = $a_u_email;

                    $STH->execute();
                    $STH->setFetchMode(PDO::FETCH_ASSOC);

                    /* Signfica que encontrou um email */
                    if($dados = $STH->fetch()) {
                        return 1;
                    } else {
                        return 0;
                    }
                } catch(Exception $e) {
                    echo "Ups: " .$e->getMessage();
                }
            } else {
                return -1;
            }
        }

        /* Método para inserir o registo na base de dados */
        public function inserir_utilizador($user) {
            /*
                1 -> Foi inserido
                0 -> Não foi inserido
                -1 -> Variavel undifined
            */
            if(!is_null($user)) {
                try {
                    $STH = $this->DBH->prepare("INSERT INTO utilizadores (u_email, u_password, u_estado) VALUES (?,?,?)");

                    $STH->bindParam(1, $u_email);
                    $STH->bindParam(2, $u_password);
                    $STH->bindParam(3, $u_estado);

                    $u_email = $user->get_u_email();
                    $u_password = password_hash($user->get_u_password(), PASSWORD_DEFAULT);
                    $u_estado = $user->get_u_estado();

                    if($STH->execute()) {
                        return 1;
                    } else {
                        return 0;
                    }
                } catch (Exception $e) {
                    echo "Ups: " .$e->getMessage();
                }
            } else {
                return -1;
            }
        }

        /* Método para obter o ultimo utilizador registado */
        public function obter_ultimo_registo() {
            /*
                0 -> não existe
            */
            try {
                $STH = $this->DBH->prepare("SELECT MAX(u_id) FROM utilizadores");

                $STH->execute();
                $STH->setFetchMode(PDO::FETCH_ASSOC);

                if($dados = $STH->fetch()) {
                    return $dados["MAX(u_id)"];
                } else {
                    return 0;
                }
            } catch (Exception $e) {
                echo "Ups: " .$e->getMessage();
            }
        }

        /* Método para verificar se a conta está ativa */
        public function verificar_estado_conta($a_u_email) {
            /*
                1 -> Se estiver ativo
                2 -> Se estiver inativo
                0 -> Não existe
                -1 -> Variavel undifined
            */
            if(!empty($a_u_email) && $a_u_email != "" && !is_null($a_u_email)) {
                try {
                    $STH = $this->DBH->prepare("SELECT u_estado FROM utilizadores WHERE u_email= ?");

                    $STH->bindParam(1, $u_email);

                    $u_email = $a_u_email;

                    $STH->execute();
                    $STH->setFetchMode(PDO::FETCH_ASSOC);

                    /* Signfica que encontrou um email */
                    if($dados = $STH->fetch()) {
                        if($dados["u_estado"] == 'a') {
                            return 1;
                        } elseif($dados["u_estado"] == 'i') {
                            return 2;
                        }
                    } else {
                        return 0;
                    }
                } catch(Exception $e) {
                    echo "Ups: " .$e->getMessage();
                }
            } else {
                return -1;
            }
        }

        /* Método para obter o id do utilizador a partir do email */
        public function obter_id_email($a_u_email) {
            /*
                0 -> Não existe
                -1 -> Variavel undifined
            */
            if(!empty($a_u_email) && $a_u_email != "" && !is_null($a_u_email)) {
                try {
                    $STH = $this->DBH->prepare("SELECT u_id FROM utilizadores WHERE u_email = ?");

                    $STH->bindParam(1, $u_email);

                    $u_email = $a_u_email;

                    $STH->execute();
                    $STH->setFetchMode(PDO::FETCH_ASSOC);

                    /* Signfica que encontrou um email */
                    if($dados = $STH->fetch()) {
                        return $dados["u_id"];
                    } else {
                        return 0;
                    }
                } catch(Exception $e) {
                    echo "Ups: " .$e->getMessage();
                }
            } else {
                return -1;
            }
        }

        /* Método para verificar se o email e a password estão corretos ou incorretos */
        public function verificar_credenciais($a_email, $a_password) {
            /*
                0 -> Se o email não existir
                1 -> Se o email e a password forem iguais
                2 -> Se a password for diferente mas o email for igual
                -1 -> Dados undifined
            */

            if($a_email != "" && $a_password != "") {
                try {
                    $STH = $this->DBH->prepare("SELECT u_password FROM utilizadores WHERE u_email = ?");

                    $STH->bindParam(1, $u_email);
                    $u_email = $a_email;

                    $STH->execute();
                    $STH->setFetchMode(PDO::FETCH_ASSOC);

                    /* Significa que existe o utilizador */
                    if($dados = $STH->fetch()) {
                        /* Verificar se a password são iguais */
                        if(password_verify($a_password, $dados['u_password'])) {
                            return 1;
                        } else {
                        /* Se a password for diferente */
                            return 2;
                        }

                    } else {
                        /* Caso o email não seja igual */
                        return 0;
                    }

                } catch(Exception $e) {
                    echo "Ups: " .$e->getMessage();
                }
            }
        }
    }
?>
