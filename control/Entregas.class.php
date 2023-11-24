<?php

include_once("api.php");

    class Entregas {
        
        static function cpfForm() {
            if (isset($_GET['_cpf'])) {
                $cpf = $_GET['_cpf'];
                
                $dados_entrega = API::getDeliveriesCPF($cpf);

                // print_r($dados_entrega['_cep']);
                // $cep = $delivery->_destinatario->_cep;
            }
        }
    }

    Entregas::cpfForm();



?>