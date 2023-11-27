<?php
    include_once("..\header.php");

    class deliveriesForm {

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

            $list = Deliveries::getObject($cpf_format);
            if($list){
                foreach($list as $data){
                    $messages[] = $data['message'];
                    
                    $date_format            = new DateTime($data['date']);
                    $dateHoraFormat         = $date_format->format('d/m/Y H:i:s');
                    $_destinatario_nome     = $data['_destinatario_nome'];
                    $_destinatario_cpf      = $data['_destinatario_cpf'];
                    $cpf_format             = substr($_destinatario_cpf, 0, 3).'.'.substr($_destinatario_cpf, 3, 3).'.'.substr($_destinatario_cpf, 6, 3).'-'.substr($_destinatario_cpf, 9, 2);
                    $_remetente_nome        = $data['_remetente_nome'];
                    $_volumes               = $data['_volumes'];
                    $_fantasia              = $data['_fantasia'];
                    $_destinatario_endereco = $data['_destinatario_endereco'];
                    $_destinatario_estado   = $data['_destinatario_estado'];
                    $_destinatario_cep      = $data['_destinatario_cep'];
                    $_destinatario_pais     = $data['_destinatario_pais'];
                    $_geolocalizacao_lat    = floatval($data['_geolocalizacao_lat']);
                    $_geolocalizacao_lng    = floatval($data['_geolocalizacao_lng']);
                    // o CNPJ são 14 numeros, nos dados fornecidos da API tem 13
                    $cnpj_format            = substr($data['_cnpj'], 0, 2).'.'.substr($data['_cnpj'], 2, 3).'.'.
                    substr($data['_cnpj'], 5, 3).'/'. substr($data['_cnpj'], 8, 4).'-'.substr($data['_cnpj'], 12);
                }
                ?>
                <div class="timeline">
                    <div id="map"></div>
                    <br>
                    <?php
                    foreach ($messages as $message){
                        ?>
                        <div class="status">

                            <h6><?= $message;?></h6>
                            <button class="view-details-btn">Ver Detalhes</button>
                            <div class="details">
                                <!-- <h6 class="inline">-------- ENTROU NA BANCO-------</h6><br> -->
                                <h6 class="inline">Data:&nbsp;</h6><?= $dateHoraFormat;?><br>
                                <h6 class="inline">Destinatário:&nbsp;</h6><?= $_destinatario_nome;?><br>
                                <h6 class="inline">CPF:&nbsp;</h6><?= $cpf_format;?><br>
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
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <?php

            }else{
                /* Consultando a API caso não encontre o CPF no banco*/
                if(empty($list)){

                    $cpf_format              = str_replace('.', '', str_replace('-','',$cpf));
                    $consult_api_deliv       = Deliveries::deliveries_list($cpf_format);

                    if($consult_api_deliv){

                        $_id_transportadora      = $consult_api_deliv['_id_transportadora'];
                        $consult_api_carriers    = Deliveries::carriers_list($_id_transportadora);
                        $_cnpj                   = $consult_api_carriers['_cnpj'];
                        $_fantasia               = $consult_api_carriers['_fantasia'];
                        $_remetente_nome         = $consult_api_deliv['_remetente']['_nome'];
                        $_volumes                = $consult_api_deliv['_volumes'];
                        $date_status             = $consult_api_deliv['_rastreamento'];
                        $_destinatario_nome      = $consult_api_deliv['_destinatario']['_nome'];
                        $_destinatario_cpf       = $consult_api_deliv['_destinatario']['_cpf'];
                        $_destinatario_endereco  = $consult_api_deliv['_destinatario']['_endereco'];
                        $_destinatario_estado    = $consult_api_deliv['_destinatario']['_estado'];
                        $_destinatario_cep       = $consult_api_deliv['_destinatario']['_cep'];
                        $_destinatario_pais      = $consult_api_deliv['_destinatario']['_pais'];
                        $_lat                    = $consult_api_deliv['_destinatario']['_geolocalizao']['_lat'];
                        $_lng                    = $consult_api_deliv['_destinatario']['_geolocalizao']['_lng'];
                    
                        /* foi preciso guardar num array pois nao conseguia acessar 
                            consult_api_deliv num foreach, dava erro de ErrorException : Illegal string offset */
                        $myArry = array(['_cnpj'                    => $_cnpj, 
                                        '_fantasia'                 => $_fantasia, 
                                        '_remetente_nome'           => $_remetente_nome, 
                                        '_volumes'                  => $_volumes, 
                                        '_destinatario_nome'        => $_destinatario_nome, 
                                        '_destinatario_cpf'         => $_destinatario_cpf,
                                        '_destinatario_endereco'    => $_destinatario_endereco,
                                        '_destinatario_estado'      => $_destinatario_estado,
                                        '_destinatario_cep'         => $_destinatario_cep,
                                        '_destinatario_pais'        => $_destinatario_pais,
                                        '_lat'                      => $_lat,
                                        '_lng'                      => $_lng,
                                    ]);
                        foreach($myArry as $runArray){

                            $_remetente_nome        = $runArray['_remetente_nome'];
                            $_volumes               = $runArray['_volumes'];
                            /*Dados Destinatario */
                            $_destinatario_nome     = $runArray['_destinatario_nome'];
                            $_destinatario_cpf      = $runArray['_destinatario_cpf'];
                            $cpf_format             = substr($_destinatario_cpf, 0, 3).'.'.substr($_destinatario_cpf, 3, 3).'.'.substr($_destinatario_cpf, 6, 3).'-'.substr($_destinatario_cpf, 9, 2);
                            $_destinatario_endereco = $runArray['_destinatario_endereco'];
                            $_destinatario_estado   = $runArray['_destinatario_estado'];
                            $_destinatario_cep      = $runArray['_destinatario_cep'];
                            $_destinatario_pais     = $runArray['_destinatario_pais'];
                            /*Dados da Entrega */
                            $_geolocalizacao_lat    = floatval($runArray['_lat']);
                            $_geolocalizacao_lng    = floatval($runArray['_lng']);
                            /*Dados da Transportadora */
                            $_cnpj                  = $runArray['_cnpj'];
                            $_fantasia              = $runArray['_fantasia'];
                            // o CNPJ são 14 numeros, nos dados fornecidos da API tem 13
                            $cnpj_format            = substr($runArray['_cnpj'], 0, 2).'.'.substr($runArray['_cnpj'], 2, 3).'.'.
                            substr($runArray['_cnpj'], 5, 3).'/'. substr($runArray['_cnpj'], 8, 4).'-'.substr($runArray['_cnpj'], 12);
                        }
                        ?>
                        <div class="timeline">
                        <div id="map"></div>
                        <br>
                        <?php
                            foreach ($date_status as $runStatus){
                                $message = $runStatus['message'];
                                $date_format            = new DateTime($runStatus['date']);
                                $dateHorFormat         = $date_format->format('d/m/Y H:i:s');
                                ?>
                                <div class="status">
                                    <h6><?= $message;?></h6>
                                    <button class="view-details-btn">Ver Detalhes</button>
                                    <div class="details">
                                        <!-- <h6 class="inline">-------- ENTROU NA API-------</h6><br> -->
                                        <h6 class="inline">Data:&nbsp;</h6><?= $dateHorFormat;?><br>
                                        <h6 class="inline">Destinatário:&nbsp;</h6><?= $_destinatario_nome;?><br>
                                        <h6 class="inline">CPF:&nbsp;</h6><?= $cpf_format;?><br>
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
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            </div>
                        <?php
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
                }
            }
                ?>
            <script>

                document.addEventListener('DOMContentLoaded', function(){
                    var detailsBtns = document.querySelectorAll('.view-details-btn');
                    var detailsDiv = document.querySelector('.details');

                    detailsBtns.forEach(function (detailsBtn){
                        detailsBtn.addEventListener('click', function(){
                            // próximo elemento irmão fazendo .details vir logo após .view-details-btn
                            var detailsDiv = this.nextElementSibling; 

                            if(detailsDiv.style.display === 'none' || detailsDiv.style.display === ''){
                                detailsDiv.style.display = 'block';
                                detailsBtn.textContent = 'Voltar';
                            }else{
                                detailsDiv.style.display = 'none';
                                detailsBtn.textContent = 'Ver Detalhes';
                            }
                        });
                    });
                });
               
                let map;

                async function initMap() {
                    const position = { lat: <?php echo $_geolocalizacao_lat; ?>, lng: <?php echo $_geolocalizacao_lng; ?> };
                    const { Map } = await google.maps.importLibrary("maps");
                    const { AdvancedMarkerView } = await google.maps.importLibrary("marker");

                    map = new Map(document.getElementById("map"), {
                        zoom: 10,
                        center: position,
                        mapId: "DEMO_MAP_ID",
                    });

                    const marker = new AdvancedMarkerView({
                        map: map,
                        position: position,
                        title: "Encomenda",
                    });
                }

                initMap();
            </script>
            <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBrzcg6YhDgza-UKXnEJBpZ33gGP3cMfF0&callback=initMap"></script>
            <?php
        }
    }
?>