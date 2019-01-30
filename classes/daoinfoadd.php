<?php
    class DAOInfoAdd {
        private $DBH;

        public function __construct($a_DBH) {
            $this->DBH = $a_DBH;
        }

        /* Método para verificar se já existem os dados adicionais */
        public function verificar_existencia_dados($a_u_id) {
            /*
                1 -> Se existir
                0 -> Não existe
                -1 -> Variavel undifined
            */

            if($a_u_id != 0) {
                try {
                    $STH = $this->DBH->prepare("SELECT * FROM info_adicionais WHERE u_id = ?");

                    $STH->bindParam(1, $u_id);
                    $u_id = $a_u_id;

                    $STH->execute();
                    $STH->setFetchMode(PDO::FETCH_ASSOC);

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

        /* Método para verificar qual o tipo de utilizador */
        public function verificar_tipo_utilizador($a_u_id) {
            /*
                1 -> Se for gabinte
                2 -> Se for cliente
                0 -> Não existe
                -1 -> Variavel undifined
            */
            if($a_u_id != 0) {
                try {
                    $STH = $this->DBH->prepare("SELECT ia_tipo FROM info_adicionais WHERE u_id = ?");

                    $STH->bindParam(1, $u_id);
                    $u_id = $a_u_id;

                    $STH->execute();
                    $STH->setFetchMode(PDO::FETCH_ASSOC);

                    if($dados = $STH->fetch()) {
                        if($dados["ia_tipo"] == 'g') {
                            return 1;
                        } elseif($dados["ia_tipo"] == 'c'){
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
    }

?>
