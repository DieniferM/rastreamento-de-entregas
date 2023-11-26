<?php
    include_once("..\header.php");

    class entregasForm {

        static function formSearchCPF(){
            ?>
            <div id="top-container" class="container-fluid">
                <form id="search-form" class="form-inline" action="..\view\index.php" method="GET" name="dados_cpf">
                    <div class="form-group col-md-10">
                        <input type="text" class="form-control" id="_destinatario_cpf" name="_destinatario_cpf" maxlength="14" placeholder="Digite um CPF para buscar encomendas (ex: 000.000.000-00)" required>
                    </div>
                    <div class="col-md-2">
                        <button type="button" onclick="search()" class="btn btn-primary">Buscar Encomendas</button>
                    </div>
                </form>
                <script>
                    /* Adiciona ouvinte de eventos ao ID */
                    document.getElementById('_destinatario_cpf').addEventListener('input', function (eventObj){
                        let cpf = eventObj.target.value.replace(/\D/g, ''); // Remove todos os caracteres não numéricos
                        
                        // maior que 3 adiciona ponto
                        if(cpf.length > 3){
                                cpf = cpf.substring(0, 3) + '.' + cpf.substring(3);
                            }
                        if(cpf.length > 7){
                            cpf = cpf.substring(0, 7) + '.' + cpf.substring(7);
                        }
                        if(cpf.length > 11){
                            cpf = cpf.substring(0, 11) + '-' + cpf.substring(11);
                        }
                            eventObj.target.value = cpf;
                        });

                    function search(){
                        if(document.getElementById('_destinatario_cpf').value == ''){
                            alert('Campo CPF n\u00e3o pode estar em branco!');
                            document.getElementById('_destinatario_cpf').focus();
                            return false;
                        }else{
                            document.dados_cpf.submit();
                        }  
                    }
                </script>
            </div>
            <?php
        }

        static function viewStatus($cpf){
           
            $cpf_format = str_replace('.', '', str_replace('-','',$cpf));

            $list = Entregas::getObject($cpf_format);
            if($list){
                foreach($list as $dados){
                    $messages[] = $dados['message'];
                    
                    $date_format            = new DateTime($dados['date']);
                    $dateHoraFormat         = $date_format->format('d/m/Y H:i:s');
                    $_destinatario_nome     = $dados['_destinatario_nome'];
                    $_destinatario_cpf      = $dados['_destinatario_cpf'];
                    $_remetente_nome        = $dados['_remetente_nome'];
                    $_volumes               = $dados['_volumes'];
                    $_fantasia              = $dados['_fantasia'];
                    $_destinatario_endereco = $dados['_destinatario_endereco'];
                    $_destinatario_estado   = $dados['_destinatario_estado'];
                    $_destinatario_cep      = $dados['_destinatario_cep'];
                    $_destinatario_pais     = $dados['_destinatario_pais'];
                    $_geolocalizacao_lat    = floatval($dados['_geolocalizacao_lat']);
                    $_geolocalizacao_lng    = floatval($dados['_geolocalizacao_lng']);
                    // o CNPJ são 14 numeros, nos dados fornecidos da API tem 13
                    $cnpj_format            = substr($dados['_cnpj'], 0, 2).'.'.substr($dados['_cnpj'], 2, 3).'.'.
                    substr($dados['_cnpj'], 5, 3).'/'. substr($dados['_cnpj'], 8, 4).'-'.substr($dados['_cnpj'], 12);
                    //CHAVE API MAPS // AIzaSyBrzcg6YhDgza-UKXnEJBpZ33gGP3cMfF0
                }
                ?>
                <div class="timeline">
                    <script defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBrzcg6YhDgza-UKXnEJBpZ33gGP3cMfF0"></script>
                    <!-- <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBrzcg6YhDgza-UKXnEJBpZ33gGP3cMfF0&callback=initMap"></script> -->

                    <?php
                    foreach ($messages as $message){
                        ?>
                        <div class="status">
                            <h6><?= $message;?></h6>
                            <button class="view-details-btn">Ver Detalhes</button>
                            <div class="details">
                                <h6 class="inline">Data:&nbsp;</h6><?= $dateHoraFormat;?><br>
                                <h6 class="inline">Destinatário:&nbsp;</h6><?= $_destinatario_nome;?><br>
                                <h6 class="inline">CPF:&nbsp;</h6><?= $_destinatario_cpf;?><br>
                                <h6 class="inline">Endereço:&nbsp;</h6><?= $_destinatario_endereco;?><br>
                                <h6 class="inline">Estado:&nbsp;</h6><?= $_destinatario_estado;?><br>
                                <h6 class="inline">CEP:&nbsp;</h6><?= $_destinatario_cep;?><br>
                                <h6 class="inline">País:&nbsp;</h6><?= $_destinatario_pais;?><br>
                                <h6 class="inline">Volumes:&nbsp;</h6><?= $_volumes;?><br>
                                <h6 class="inline">Remetente:&nbsp;</h6><?= $_remetente_nome;?><br>
                                <h6 class="inline">Nome Transportadora:&nbsp;</h6><?= $_fantasia;?><br>
                                <h6 class="inline">CNPJ Transportadora:&nbsp;</h6><?= $cnpj_format;?><br>
                                <input type="hidden" name="lat" id="lat" value="<?= $_geolocalizacao_lat; ?>"/>
                                <input type="hidden" name="lng" id="lng" value="<?= $_geolocalizacao_lng; ?>"/>
                                <br>
                                <div id="map"></div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <?php

            }else if(empty($list)){

                $cpf_format = str_replace('.', '', str_replace('-','',$cpf));
                $consult_api = Entregas::getObjectApi($cpf_format);

                var_dump($consult_api);
                exit;
               
                
            }else{
                ?>
                 <div class="timeline">
                    <div class="form-group col-md-10">
                        <div class="alert alert-danger" role="alert">
                            <b>CPF não cadastrado!</b>
                        </div>
                    </div>
                </div>
                <?php
            }
                ?>
                <!-- </div> -->
            <script>
                // let lat = document.getElementById('lat').value;
                // let lng = document.getElementById('lng').value;
                // [_geolocalizacao_lng] => -56.094900
                // [_geolocalizacao_lat] => -15.598900

                // -6.542190, -37.713501

                document.addEventListener('DOMContentLoaded', function(){
                    var detailsBtns = document.querySelectorAll('.view-details-btn');

                    detailsBtns.forEach(function (detailsBtn){
                        detailsBtn.addEventListener('click', function(){
                            // próximo elemento irmão fazendo .details vir logo após .view-details-btn
                            var detailsDiv = this.nextElementSibling; 

                            if(detailsDiv.style.display === 'none' || detailsDiv.style.display === ''){
                                detailsDiv.style.display = 'block';
                            }else{
                                detailsDiv.style.display = 'none';
                            }
                        });
                    });
                });
                
                
                let map;
              
                let lat = document.getElementById('lat').value;
                let lng = document.getElementById('lng').value;
                async function initMap(lat, lng) {
                const position = { lat, lng };
                const { Map } = await google.maps.importLibrary("maps");
                
                const { AdvancedMarkerView } = await google.maps.importLibrary("marker");

                const map = new google.maps.Map(document.getElementById("map"), {
                    zoom: 10,
                    center: { lat, lng },
                });

                const marker = new AdvancedMarkerView({
                    map: map,
                    position: position,
                    title: "Rastreio",
                });
                }

              
                
                
            </script>
            <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBrzcg6YhDgza-UKXnEJBpZ33gGP3cMfF0&callback=initMap"></script>
            <?php
        }
    }
?>