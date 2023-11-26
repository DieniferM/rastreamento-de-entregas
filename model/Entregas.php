<?php
  include_once("../config/connection.php");
  include_once("../control/Api.php");
    /*
        Data: 23/11/2023
        Descrição: Classe responsável por manipular dados do usuário (destinatário) trazendo todos os dados de entrega referente ao CPF.
    */

    class Entregas {

        public $_id;
        public $_id_transportadora;
        public $_volumes;
        public $_remetente_nome;
        public $_destinatario_nome;
        public $_destinatario_cpf;
        public $_destinatario_endereco;
        public $_destinatario_estado;
        public $_destinatario_cep;
        public $_destinatario_pais;
        public $_geolocalizacao_lat;
        public $_geolocalizacao_lng;
        public $message;
        public $date;
        public $_cnpj;
        public $_fantasia;

        static function getObject($_cpf){

            // SE NÃO TIVER NO BANCO, CONSULTAR NA API

            global $conn;
            try{

                $sql = "SELECT * FROM entregas
                    INNER JOIN _rastreamento ON entregas._id = _rastreamento._id_entrega
                    INNER JOIN transportadoras ON entregas._id_transportadora = transportadoras._id
                    WHERE _destinatario_cpf = '".$_cpf."'";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $result;

            }catch(PDOException $e) {
                $error = $e->getMessage();
                echo '<div class="timeline">
                        <div class="form-group col-md-10">
                            <div class="alert alert-warning" role="alert">
                                <b>Erro na consulta dos dados no banco!</b>
                            </div>
                        </div>
                    </div>';
                exit;
            }
        }

        static function getObjectApi($_cpf){
            
            $deliveries = Api::getApiDeliveries();

                // print_r($deliveries["_destinatario"]['_cpf']);
                // print_r($deliveries);

            foreach($deliveries as $result_deliveries){
                if($_cpf == $deliveries){
                $_destinatario_cpf = $result_deliveries["_destinatario"]["_cpf"];
                
                print_r($_destinatario_cpf);
                
                        print 'entrou na funcao';
                    // print 'entrou no if';
                    // exit;
                        //tem na API mas nao tem no banco
                        // Data: 16/11/2023 10:00:00
                        // Destinatário: Ricardo Oliveira
                        // CPF: 81175778010
                        // Endereço: Rua Principal, 7829
                        // Estado: São Paulo
                        // CEP: 07890-345
                        // País: Brasil
                        // Volumes: 2
                        // Remetente: Peças Auto - TTR
                        // Nome Transportadora: EXPRESS WINGS
                        // CNPJ Transportadora: 56.789.012/3000-1


                        /*LISTA dos dados da tabela ENTREGAS */ 
                        // $_id                        = $result_deliveries["_id"];
                        // $_id_transportadora         = $result_deliveries["_id_transportadora"];
                        // $_volumes                   = $result_deliveries["_volumes"];

                        // $_destinatario_nome         = $result_deliveries["_destinatario"]["_nome"];
                        // $_destinatario_cpf          = $result_deliveries["_destinatario"]["_cpf"];
                        // $_destinatario_endereco     = $result_deliveries["_destinatario"]["_endereco"];
                        // $_destinatario_estado       = $result_deliveries["_destinatario"]["_estado"];
                        // $_destinatario_cep          = $result_deliveries["_destinatario"]["_cep"];
                        // $_destinatario_pais         = $result_deliveries["_destinatario"]["_pais"];
                        // $_geolocalizacao_lat        = $result_deliveries["_destinatario"]["_geolocalizao"]["_lat"];
                        // $_geolocalizacao_lng        = $result_deliveries["_destinatario"]["_geolocalizao"]["_lng"];

                        // foreach($result_deliveries["_rastreamento"] as $runMessege){

                        //     $message        = $runMessege["message"];
                        //     $date           = $result_deliveries["_rastreamento"][0]["date"];

                        // }
                    }
                    

            }
        }
    }
?>