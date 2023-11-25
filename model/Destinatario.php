<?php
  include_once("../config/connection.php");
    /*
        Data: 23/11/2023
        Descrição: Classe responsável por manipular dados do usuário (destinatário).
    */

    class Destinatario {

        public $_nome;
        public $_cpf;
        public $_endereco;
        public $_estado;
        public $_cep;
        public $_pais;

        public function getObject($_cpf){
            global $conn;
           
            try{
                $sql = "SELECT * FROM _destinatario WHERE _cpf = '".$_cpf."'";
                $stmt = $conn->prepare($sql);
                // print 'select teste -- '.$sql;
                // exit;
                $stmt->execute();
                $result = $stmt->fetch();
                // PDO::FETCH_ASSOC

                if($result){
                    foreach ($result as $data){
                        $destinatario = new Destinatario;
                        
                        foreach ($data as $key => $campo){
                            $destinatario->$key = $campo;
                        }
                        
                        $lista_destinatario[] = $destinatario;
                    }
                    
                    return $lista_destinatario;
                }

                // print_r($result);
                
            }catch(PDOException $e) {
                $error = $e->getMessage();
                echo "Erro de banco de dados: $error";
            }
        }
    }
?>