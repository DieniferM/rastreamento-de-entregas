<?php

/*
    Data: 21/11/2023
    Descrição: Conexão com a API Json, que contém informações para serem adicionadas ao banco.
*/
    function api_transportados(){
        $url_transp = "https://run.mocky.io/v3/e8032a9d-7c4b-4044-9d00-57733a2e2637";
        $data = json_decode(file_get_contents($url_transp));

        foreach($data as $dados){
            print '<br>';
            print_r($dados);
            print '<br>';
        }

    }
        $result_transp = api_transportados();
        return $result_transp;

    // function api_entregas(){
    //     $url_entregas = "https://run.mocky.io/v3/6334edd3-ad56-427b-8f71-a3a395c5a0c7";
    //     $data_ent = json_decode(file_get_contents($url_entregas));

    //     foreach($data_ent as $view){
    //         print '<br>';
    //         print_r($view);
    //         print '<br>';
    //     }

    // }
    //     $result = api_entregas();
    //     return $result;
?>
