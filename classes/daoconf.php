<?php
    class DAOConf {
        private $DBH;

        public function __construct($a_DBH) {
            $this->DBH = $a_DBH;
        }

        /* Método para inserir o codigo na base de dados */
        public function inserir_codigo(Conf $codigo) {
            /*
                1 -> Inserido
                0 -> Não inserido
                -1 -> Variavel undifined
            */
            if(!is_null($codigo)) {
                try {
                    $STH = $this->DBH->prepare("INSERT INTO conf_conta (u_id, cc_codigo) VALUES (?,?)");

                    $STH->bindParam(1, $u_id);
                    $STH->bindParam(2, $cc_codigo);

                    $u_id = $codigo->get_u_id();
                    $cc_codigo = $codigo->get_c_codigo();

                    /* Signfica que foi introduzido */
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

        /* Método para obter o código do utilizador a partir do seu ID */
        public function obter_codigo_id($a_u_id) {
            /*
                0 -> Não existe
                -1 -> Variavel undifined
            */
            if($a_u_id != 0) {
                try {
                    $STH = $this->DBH->prepare("SELECT cc_codigo FROM conf_conta WHERE u_id = ?");

                    $STH->bindParam(1, $u_id);

                    $u_id = $a_u_id;

                    $STH->execute();
                    $STH->setFetchMode(PDO::FETCH_ASSOC);

                    if($dados = $STH->fetch()) {
                        return $dados["cc_codigo"];
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
    }

?>
