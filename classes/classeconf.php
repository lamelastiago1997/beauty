<?php
    class Conf {
        private $c_id;
        private $u_id;
        private $c_codigo;

        public function __construct($a_u_id, $c_id = null) {
            $this->u_id = $a_u_id;
            $this->c_codigo = $this->gerar_codigo();
        }

        /* Metodo para gerar o codigo */
        private function gerar_codigo() {
            $i = 0;
            $codigo = "";

            while($i < 4){
                $codigo .= mt_rand(0, 9);
                $i++;
            }
            return $codigo;
        }

        public function get_u_id() {
            return $this->u_id;
        }

        public function get_c_codigo() {
            return $this->c_codigo;
        }
    }
?>
