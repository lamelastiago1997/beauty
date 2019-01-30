<?php
    class InfoAdd {
        private $ia_id;
        private $ia_tipo;
        private $ia_nome;
        private $ia_contato;
        private $ia_localidade;

        private $ia_genero;
        private $ia_morada;

        private $u_id;

        /*
            Tipo:
                g --> gabinete;
                c --> cliente;

            Genero:
                m --> masculino;
                f --> feminino;
        */

        public function __construct($a_ia_tipo, $a_ia_nome, $a_ia_contato, $a_ia_localidade, $a_ia_genero, $a_ia_morada, $a_u_id, $ia_id = null) {
            $this->ia_tipo = $a_ia_tipo;
            $this->ia_nome = $a_ia_nome;
            $this->ia_contato = $a_ia_contato;
            $this->ia_localidade = $a_ia_localidade;
            $this->ia_genero = $a_ia_genero;
            $this->ia_morada = $a_ia_morada;
            $this->u_id = $a_u_id;
        }

        public function get_ia_tipo() {
            return $this->ia_tipo;
        }

        public function get_ia_nome() {
            return $this->ia_nome;
        }

        public function get_ia_contato() {
            return $this->ia_contato;
        }

        public function get_ia_localidade() {
            return $this->ia_localidade;
        }

        public function get_ia_genero() {
            return $this->ia_genero;
        }

        public function get_ia_morada() {
            return $this->ia_morada;
        }

        public function get_u_id() {
            return $this->u_id;
        }
    }

?>
