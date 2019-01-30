<?php
    class Email {
        private $to_email;
        private $subject;
        private $content;
        private $mail_header;

        public function __construct($a_to_email, $a_codigo) {
            $this->to_email = $a_to_email;
            $this->subject = "Ativação da conta";
            $this->content = "Inserir o seguinte código no momento do primeiro login: " .$a_codigo;
            $this->mail_header = "From: Beauty creators\r\n";;
        }

        public function enviar_email() {
            if(mail($this->to_email, $this->subject, $this->content, $this->mail_header)) {
                return 1;
            } else {
                return 0;
            }
        }
    }
?>
