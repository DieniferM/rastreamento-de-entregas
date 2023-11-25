<?php
    include_once("..\header.php");
?>
<!DOCTYPE html>
<html lang="pt">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="..\css\styles.css"> 
        <title>Entregas</title>
    </head>
    <body>
        <div id="top-container" class="container-fluid">
            <form id="search-form" class="form-inline" action="../control/Entregas.class.php" method="GET" name="dados_cpf">
                <div class="form-group col-md-10">
                    <input type="text" class="form-control" id="_cpf" name="_cpf" maxlength="14" placeholder="Digite um CPF para buscar encomendas (ex: 000.000.000-00)" required>
                </div>
                <div class="col-md-2">
                    <button type="button" onclick="search()" class="btn btn-primary">Buscar Encomendas</button>
                </div>
            </form>

            <script>
                    // Verificar este filtro pois os dados salvos estao como "_cpf": "35595606088"
                    // Talvez azer um str_replace para tirar os pontos e traços para procurar

                /* Adiciona ouvinte de eventos ao ID */
                document.getElementById('_cpf').addEventListener('input', function (eventObj){
                    let cpf = eventObj.target.value.replace(/\D/g, ''); // Remove todos os caracteres não numéricos
                    
                    // maior que 3 adiciona ponto
                    if (cpf.length > 3){
                            cpf = cpf.substring(0, 3) + '.' + cpf.substring(3);
                        }
                    if (cpf.length > 7){
                        cpf = cpf.substring(0, 7) + '.' + cpf.substring(7);
                    }
                    if (cpf.length > 11){
                        cpf = cpf.substring(0, 11) + '-' + cpf.substring(11);
                    }
                        eventObj.target.value = cpf;
                    });

                function search(){
                    if(document.getElementById('_cpf').value == ''){
                        alert('Campo CPF n\u00e3o pode estar em branco!');
                        document.getElementById('_cpf').focus();
                        return false;
                    }else{
                        document.dados_cpf.submit();
                    }  
                }
            </script>
        </div>
    </body>
</html>