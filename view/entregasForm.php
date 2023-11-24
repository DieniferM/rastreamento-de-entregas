<?php
    include_once("..\header.php");
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="..\css\styles.css"> 
        <title>Entregas</title>
    </head>
    <body>
        <div id="top-container" class="container-fluid">
            <form id="search-form" class="form-inline" action="../control/Entregas.class.php" method="GET">
                <div class="form-group col-md-10">
                    <input type="text" class="form-control" id="_cpf" name="_cpf" placeholder="Digite o CPF para buscar encomendas...">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">Procurar</button>
                </div>
            </form>
        </div>
    </body>
</html>