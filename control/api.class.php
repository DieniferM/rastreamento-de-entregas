<?php
  include_once("../config/connection.php");

/*
    Data: 21/11/2023
    Descrição: Conexão com a API Json e inserção dos dados da API no banco.
*/

    class API {

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

        public static function getApiDeliveries(){

            try{
                $url_json_deliv       = "https://run.mocky.io/v3/6334edd3-ad56-427b-8f71-a3a395c5a0c7";
                $convert_retorn_deliv = file_get_contents($url_json_deliv);
                $list_deliveries    = json_decode($convert_retorn_deliv, true);
                
                return $list_deliveries['data'];

            }catch(Exception $e){
                $error = $e->getMessage();
                echo "Erro ao conectar a API de listagem de entregas: $error";
                exit;
            }
        
        }

        public function saveDatabaseDeliveries($deliveries){
            global $conn;
            
            try{
                foreach($deliveries as $infoDeliveries){

                    /*cadastro dos dados da tabela ENTREGAS */ 
                    $_id                = $infoDeliveries["_id"];
                    $_id_transportadora = $infoDeliveries["_id_transportadora"];
                    $_volumes           = $infoDeliveries["_volumes"];
                    $sql_entregas = "INSERT INTO entregas (_id, _id_transportadora, _volumes)
                        VALUES ('$_id','$_id_transportadora','$_volumes')";
                    $stmt = $conn->prepare($sql_entregas);
                    $stmt->execute();

                    /*cadastro dos dados da tabela REMETENTE */ 
                    $_nome = $infoDeliveries["_remetente"]['_nome'];
                    $sql_remetente = "INSERT INTO _remetente (_nome) VALUES ('$_nome')";
                    $stmt = $conn->prepare($sql_remetente);
                    $stmt->execute();

                    /*cadastro dos dados da tabela DESTINATARIO */ 
                    $_nome_destinatario     = $infoDeliveries["_destinatario"]["_nome"];
                    $_cpf                   = $infoDeliveries["_destinatario"]["_cpf"];
                    $_endereco              = $infoDeliveries["_destinatario"]["_endereco"];
                    $_estado                = $infoDeliveries["_destinatario"]["_estado"];
                    $_cep                   = $infoDeliveries["_destinatario"]["_cep"];
                    $_pais                  = $infoDeliveries["_destinatario"]["_pais"];
                    $sql_destinatario = "INSERT INTO _destinatario (_nome, _cpf, _endereco, _estado, _cep, _pais)
                        VALUES ('$_nome_destinatario','$_cpf','$_endereco', '$_estado', '$_cep', '$_pais')";
                    $stmt = $conn->prepare($sql_destinatario);
                    $stmt->execute();

                    /*cadastro dos dados da tabela GEOLOCALIZACAO */ 
                    $_lat  = $infoDeliveries["_destinatario"]["_geolocalizao"]["_lat"];
                    $_lng  = $infoDeliveries["_destinatario"]["_geolocalizao"]["_lng"];
                    $sql_geolocalizao = "INSERT INTO _geolocalizao (_lat, _lng) VALUES ('$_lat','$_lng')";
                    $stmt = $conn->prepare($sql_geolocalizao);
                    $stmt->execute();

                    /*cadastro dos dados da tabela RASTREAMENTO */ 
                    $message = $infoDeliveries["_rastreamento"][0]["message"];
                    $date    = $infoDeliveries["_rastreamento"][0]["date"];
                    $format_date = date('Y-m-d H:i:s', strtotime($date));
                    $sql_rastreamento = "INSERT INTO _rastreamento (message, date) VALUES ('$message','$format_date')";
                    $stmt = $conn->prepare($sql_rastreamento);
                    $stmt->execute();

                }
            }catch(PDOException $e) {
                $error = $e->getMessage();
                echo "Erro de banco de dados: $error";
            }
        }

        public function saveDatabaseCarriers($carriers){
            global $conn;
            
            try{
                foreach($carriers as $infoCarriers){

                    /*cadastro dos dados da tabela TRANSPORTADORAS */ 
                    $_id        = $infoCarriers["_id"];
                    $_cnpj      = $infoCarriers["_cnpj"];
                    $_fantasia  = $infoCarriers["_fantasia"];
                    $sql_transp = "INSERT INTO transportadoras (_id, _cnpj, _fantasia)
                        VALUES ('$_id','$_cnpj','$_fantasia')";
                    $stmt = $conn->prepare($sql_transp);
                    $stmt->execute();

                }
            }catch(PDOException $e) {
                $error = $e->getMessage();
                echo "Erro de banco de dados: $error";
            }
        }
    }

    $instance_deliv = new API();
    $deliveries = API::getApiDeliveries();
    $instance_deliv->saveDatabaseDeliveries($deliveries);

    $instance_carriers = new API();
    $carriers = API::getCarriers();
    $instance_carriers->saveDatabaseCarriers($carriers);
           
?>
