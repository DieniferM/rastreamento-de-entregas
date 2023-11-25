<?php
    include_once("..\header.php");
    include_once("entregasForm.php");
    include_once("..\model\Destinatario.php");
?>

<?php
// print_r($_GET);
// exit;
$acessa_destinatario = new Destinatario;
// print_r($acessa_destinatario);
// exit;
    // if($acessa_destinatario != ""){
?>
    <body>
        <div class="timeline">
            <div class="status">
                <h6><?=$acessa_destinatario->_nome;?></h6>
                <p>Descrição do evento 1.</p>
                <div class="status-date">2023-11-16 10:00:00</div>
            </div>

            <div class="status">
                <h6>EM TRÂNSITO</h6>
                <p>Descrição do evento 2.</p>
                <div class="status-date">2023-11-16 10:00:00</div>
            </div>

            <div class="status">
                <h6>SAIU PARA ENTREGA</h6>
                <p>Descrição do evento 2.</p>
                <div class="status-date">2023-11-16 10:00:00</div>
            </div>
        </div>
    </body>
</html>

