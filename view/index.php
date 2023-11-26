<?php
    include_once("..\header.php");
    include_once("../view/entregasForm.php");
    include_once("../model\Entregas.php");
    // include_once("../control\Api.php");

    ?>
    <!DOCTYPE html>
    <html lang="pt">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <!-- BOOTSTRAP -->
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap.min.css" integrity="sha512-oc9+XSs1H243/FRN9Rw62Fn8EtxjEYWHXRvjS43YtueEewbS6ObfXcJNyohjHqVKFPoXXUxwc+q1K7Dee6vv9g==" crossorigin="anonymous" />
            <!-- FONT AWESOME -->
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
            <!-- CSS -->
            <link rel="stylesheet" href="..\css\styles.css">
        </head>
        <body>
            <?php
                entregasForm::formSearchCPF();

                if(isset($_GET['_destinatario_cpf'])){
                    $_cpf = $_GET['_destinatario_cpf'];
                    if($_cpf){
                        entregasForm::viewStatus($_cpf);   
                    }
                }
            ?>
            <!-- jQuery 2.0.2 -->
            <!-- <script src="js/jquery-min.js"></script> -->
            <!-- Bootstrap -->
            <!-- <script src="js/bootstrap.min.js" type="text/javascript"></script>         -->

        </body>
    </html>
    <?php
?>