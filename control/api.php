<?php

/*
    Data: 21/11/2023
    Descrição: Conexão com a API Json, que contém informações para serem adicionadas ao banco.
*/

// $_cpf = $_GET;

    class API {

        // private $list_deliv;

        // function api_transportados(){
            
        //     $url_transp = "https://run.mocky.io/v3/e8032a9d-7c4b-4044-9d00-57733a2e2637";
        //     $list_transp = json_decode(file_get_contents($url_transp));

        //     /*Retornando um array, percorre associando a chave principal ao campo. */
        //     if(is_array($list_transp)){
        //         foreach($list_transp as $key=>$campo){
        //             $this->$key = $campo;
        //         }            
        //     }
        // }

        //     $result_transp = api_transportados();
        //     return $result_transp;
        // $url_deliveries = "https://run.mocky.io/v3/6334edd3-ad56-427b-8f71-a3a395c5a0c7";
        // $list_deliv['data'] = json_decode(file_get_contents($url_deliveries));


        public static function getDeliveriesCPF($cpf) {

            $url_json       = "https://run.mocky.io/v3/6334edd3-ad56-427b-8f71-a3a395c5a0c7";
            $convert_retorn = file_get_contents($url_json);
            $object_mult  = json_decode($convert_retorn);

            foreach ($object_mult->data as $delivery) {

                    $id                 = $delivery->_id;
                    $id_transportadora  = $delivery->_id_transportadora;
                    $volumes            = $delivery->_volumes;

                    // objeto principal {remetente} 
                    $remetente       = $delivery->_remetente;
                    $nome            = $remetente->_nome;

                    // objeto principal {destinatario} 
                    $destinatario    = $delivery->_destinatario;

                    $cpf             = $destinatario->_cpf;
                    $endereco        = $destinatario->_endereco;
                    $cep             = $destinatario->_cep;
                    $pais            = $destinatario->_pais;
                    $geolocalizacao  = $destinatario->_geolocalizao;
                    
                    // objeto principal {rastreamento} 
                    $rastreamento    = $delivery->_rastreamento;
                    // $message    = $delivery->message;
                    
                    print_r($destinatario);
            }
                // exit;
                // if (isset($object_mult['data']) && is_array($object_mult['data']) && !empty($object_mult['data'])) {
                //     $id                = $object_mult['data'][0]['_id'];
                //     $id_transportadora  = $object_mult['data'][0]['_id_transportadora'];
                //     $volumes            = $object_mult['data'][0]['_volumes'];
                // }
                // // var_dump($object_mult['data']['_remetente']);          

                // if (isset($object_mult['_remetente']) && is_array($object_mult['_remetente']) && !empty($object_mult['_remetente'])) {
                //     $nome            = $object_mult['data']['_remetente'][1]['_nome'];
                //     var_dump($nome);          
                // }          
              
        }
    }
           
?>
