<?php

// include_once("api.php");
include_once("..\model\Destinatario.php");

    class EntregasForm {
        
        static function cpf() {
            if (isset($_GET['_cpf'])) {

                $cpf = str_replace('.', '', str_replace('-','',$_GET['_cpf']));
                
                $cpf_banco = new Destinatario;
                $cpf_banco->getObject($cpf);
               
            }
        }
    }
    EntregasForm::cpf();

?>