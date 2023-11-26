<?php
  include_once("../config/connection.php");
    /*
        Data: 23/11/2023
        Descrição: Classe responsável por manipular dados do usuário (destinatário) trazendo todos os dados de entrega referente ao CPF.
    */

    class Destinatario {

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
                echo "Erro na consulta dos dados no banco: $error";
            }
        }
        
    }
?>