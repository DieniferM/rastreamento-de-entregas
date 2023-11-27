<?php
    include_once("..\header.php");
    include_once("../view/deliveriesForm.php");
    include_once("../model/Deliveries.php");
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
            <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
        </head>
        <body>
            <?php
                deliveriesForm::formSearchCPF();

                if(isset($_GET['_destinatario_cpf'])){
                    $_cpf = $_GET['_destinatario_cpf'];
                    if($_cpf){
                        deliveriesForm::viewStatus($_cpf);   
                    }
                }
            ?>
            <script>(g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})
            ({key: "AIzaSyBrzcg6YhDgza-UKXnEJBpZ33gGP3cMfF0", v: "beta"});</script>
                </body>
    </html>
    <?php
?>