<?php

/*
    Data: 21/11/2023
    Descrição: Conexão com a API Json, que contém informações para serem adicionadas ao banco.
*/
    function api_transportados(){
        $url_transp = "https://run.mocky.io/v3/e8032a9d-7c4b-4044-9d00-57733a2e2637";
        $list_transp = json_decode(file_get_contents($url_transp));

        /*Retornando um array, percorre associando a chave principal ao campo. */
        if(is_array($list_transp)){
            foreach($list_transp as $key=>$campo){
                $this->$key = $campo;
            }            
        }

        $cpf = Entregas::cpfForm();
        print_r($cpf);
        // print_r($list_transp->status);
    }

        $result_transp = api_transportados();
        return $result_transp;

    function api_entregas(){
        $url_deliveries = "https://run.mocky.io/v3/6334edd3-ad56-427b-8f71-a3a395c5a0c7";
        $list_deliv = json_decode(file_get_contents($url_deliveries));

        /*Retornando um array, percorre associando a chave principal ao campo. */
        if(is_array($list_deliv)){
            foreach($list_deliv as $key=>$campo){
                $this->$key = $campo;
            }            
        }
        // print_r($list_deliv->status);

    }

    $result_deliv = api_entregas();
    return $result_deliv;
?>
