<?php
  include_once("../config/connection.php");
  include_once("../control/Api.php");
    /*
        Data: 23/11/2023
        Descrição: Classe responsável por manipular dados referente ao CPF selecionado (destinatário) trazendo todos os
        dados de entrega.
    */

    class Deliveries {

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

        /*Descrição: Função que recebe do form o cpf e busca dados da no banco unindo os dados através do innner join*/
        static function getObject($_cpf){

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
        

        /*Descrição: Função que recebe do form o cpf e trás dados da API Entregas*/
        static function deliveries_list_api($_cpf){
                
            $deliveries = Api::getApiDeliveries();
            
            foreach($deliveries as $result_deliveries){
                if(is_array($result_deliveries)){

                    if($_cpf == $result_deliveries["_destinatario"]['_cpf']){
                        return $result_deliveries;
                    }                
                }
            }
        }

        /*Descrição: Função que recebe do form o cpf e trás dados da API Transportadoras*/
        static function carriers_list_api($_id){
                
            $carriers = Api::getCarriers();
            
            foreach($carriers as $result_carriers){
                if(is_array($result_carriers)){

                    if($_id == $result_carriers["_id"]){
                        return $result_carriers;
                    }                
                }
            }
        }
    }
?>