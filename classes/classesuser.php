<?php
    class User {
        private $u_id;
        private $u_email;
        private $u_password;
        private $u_estado;

        /*
            Se for
                a -> ativo
                i -> inativo
        */

        public function __construct($a_u_email, $a_u_password, $u_id = null) {
            $this->u_email = $a_u_email;
            $this->u_password = $a_u_password;
            $this->u_estado = 'i';
        }

        public function get_u_email() {
            return $this->u_email;
        }

        public function get_u_password() {
            return $this->u_password;
        }

        public function get_u_estado() {
            return $this->u_estado;
        }
    }
?>
