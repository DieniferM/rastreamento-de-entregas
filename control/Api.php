<?php
  include_once("../config/connection.php");

/*
    Data: 21/11/2023
    Descrição: Conexão com a API Json e inserção dos dados da API no banco de dados.
*/

    class Api {


        public static function getApiDeliveries(){

            try{
                $url_json_deliv         = "https://run.mocky.io/v3/6334edd3-ad56-427b-8f71-a3a395c5a0c7";
                $convert_retorn_deliv   = file_get_contents($url_json_deliv);
                $list_deliveries        = json_decode($convert_retorn_deliv, true);
                
                return $list_deliveries['data'];

            }catch(Exception $e){
                $error = $e->getMessage();
                echo "Erro ao conectar a API de listagem de entregas: $error";
                exit;
            }
        }

        public function saveDatabaseDeliveries($consult_api_deliv){

            $deliveries = Deliveries::getObject($consult_api_deliv['_destinatario']['_cpf']);

            /* verifica duplicidade */
            if($deliveries != $consult_api_deliv){
                
                global $conn;
                
                try{
                            
                    /*cadastro dos dados da tabela ENTREGAS */ 
                    $_id                        = $consult_api_deliv["_id"];
                    $_id_transportadora         = $consult_api_deliv["_id_transportadora"];
                    $_volumes                   = $consult_api_deliv["_volumes"];
                    $_remetente_nome            = $consult_api_deliv["_remetente"]['_nome'];
                    $_destinatario_nome         = $consult_api_deliv["_destinatario"]["_nome"];
                    $_destinatario_cpf          = $consult_api_deliv["_destinatario"]["_cpf"];
                    $_destinatario_endereco     = $consult_api_deliv["_destinatario"]["_endereco"];
                    $_destinatario_estado       = $consult_api_deliv["_destinatario"]["_estado"];
                    $_destinatario_cep          = $consult_api_deliv["_destinatario"]["_cep"];
                    $_destinatario_pais         = $consult_api_deliv["_destinatario"]["_pais"];
                    $_geolocalizacao_lat        = $consult_api_deliv["_destinatario"]["_geolocalizao"]["_lat"];
                    $_geolocalizacao_lng        = $consult_api_deliv["_destinatario"]["_geolocalizao"]["_lng"];

                    $sql_entregas = "INSERT INTO entregas (_id, _id_transportadora, _volumes, _remetente_nome, 
                        _destinatario_nome, _destinatario_cpf, _destinatario_endereco, _destinatario_estado, _destinatario_cep, _destinatario_pais,
                        _geolocalizacao_lat, _geolocalizacao_lng)
                        VALUES ('$_id','$_id_transportadora','$_volumes','$_remetente_nome',
                        '$_destinatario_nome','$_destinatario_cpf','$_destinatario_endereco','$_destinatario_estado','$_destinatario_cep',
                        '$_destinatario_pais','$_geolocalizacao_lat','$_geolocalizacao_lng')";

                    $stmt = $conn->prepare($sql_entregas);
                    $stmt->execute();
                
                    // /*cadastro dos dados da tabela REMETENTE */ 
                    $_id_entrega    = $consult_api_deliv['_id'];
                    $_nome          = $consult_api_deliv["_remetente"]['_nome'];
                    $sql_remetente  = "INSERT INTO _remetente (_id_entrega, _nome) VALUES ('$_id_entrega','$_nome')";
                    $stmt = $conn->prepare($sql_remetente);
                    $stmt->execute();

                    /*cadastro dos dados da tabela RASTREAMENTO */ 
                    $_id_entrega    = $consult_api_deliv["_id"];
                    foreach($consult_api_deliv["_rastreamento"] as $runMessege){
                        $message        = $runMessege["message"];
                        $date           = $runMessege["date"];
                        $format_date    = date('Y-m-d H:i:s', strtotime($date));
                        
                        $sql_rastreamento = "INSERT INTO _rastreamento (_id_entrega, message, date) VALUES ('$_id_entrega','$message','$format_date')";
                        $stmt = $conn->prepare($sql_rastreamento);
                        $stmt->execute();
                    }
                
                }catch(PDOException $e) {
                    $error = $e->getMessage();
                    echo "Erro ao inserir API Entregas no banco de dados: $error";
                }
            }
        }

        public static function getCarriers(){
            try{
                $url_carriers = "https://run.mocky.io/v3/e8032a9d-7c4b-4044-9d00-57733a2e2637";
                $convert_retorn_transp = file_get_contents($url_carriers);
                $list_carriers = json_decode($convert_retorn_transp, true);

                return $list_carriers['data'];

            }catch(Exception $e){
                $error = $e->getMessage();
                echo "Erro ao conectar a API de listagem de transportadoras: $error";
            }
        }

        public function saveDatabaseCarriers($consult_api_carriers){
                
            global $conn;
            try{

                /*cadastro dos dados da tabela TRANSPORTADORAS */ 
                $_id        = $consult_api_carriers["_id"];
                $_cnpj      = $consult_api_carriers["_cnpj"];
                $_fantasia  = $consult_api_carriers["_fantasia"];
                $sql_transp = "INSERT INTO transportadoras (_id, _cnpj, _fantasia)
                    VALUES ('$_id','$_cnpj','$_fantasia')";
                $stmt = $conn->prepare($sql_transp);
                $stmt->execute();

            }catch(PDOException $e) {
                $error = $e->getMessage();
                echo "Erro ao inserir API Transportadoras no banco de dados:: $error";
            }
        }
    }
?>
