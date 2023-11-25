<?php
  include_once("config/connection.php");
    /*
        Data: 23/11/2023
        Descrição: Classe responsável por manipular dados de entrega.
    */

    class Entregas {

        public $_id;
        public $_id_transportadora;
        public $_volumes;


        // Remodular o banco de dados
        public function getObject($_id){
            global $conn;

            try{
                $sql = "SELECT entregas._id, entregas._id_transportadora, entregas._volumes, transportadoras._cnpj,
                    transportadoras._fantasia FROM entregas 
                    INNER JOIN transportadoras ON entregas._id_transportadora = transportadoras._id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":_id", $_id);
                $stmt->execute();
                $result = $stmt->fetch();

                print_r($result);
                
            }catch(PDOException $e) {
                $error = $e->getMessage();
                echo "Erro de banco de dados: $error";
            }
        }





    }
?>