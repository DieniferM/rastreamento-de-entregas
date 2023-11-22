<?php
    /*
        Data: 21/11/2023
        Descrição: Observer, responsável por notificar quando o evento é chamado.
    */

    interface Observer {
        public function getUpdateInfo($pedido);
    }

    class Subject {
        private $observers = array();

        public function addObserver(Observer $observer) {
            $this->observers[] = $observer;
        }

        public function notifyStatus($pedido) {
            foreach ($this->observers as $observer) {
                $observer->getUpdateInfo($pedido);
            }
        }
    }

    // Classe Concreta que implementa a interface Observer
    class ConcreteObserver implements Observer {
        public function getUpdateInfo($pedido) {
            echo "Status do pedido: {$pedido}\n";
        }
    }

    // Uso do Observer Pattern
    $subject = new Subject();

    //quantidade que é notificado
    $observer1 = new ConcreteObserver();
    // $observer2 = new ConcreteObserver();

    //quantidade que é notificado
    $subject->addObserver($observer1);
    // $subject->addObserver($observer2);

    // Notifica os observadores
    $subject->notifyStatus("Saiu para entrega!");

    
    
    //Simulador de ações -> getUpdateInfo (informação atualizadas, como status de entrega)
    
    
    //destinatário
    // sempre que muda o status da encomenda, o destinatário precisa ser notificado
    
    
    
    //remente
?>
