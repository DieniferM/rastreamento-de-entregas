<?php

spl_autoload_register(
    function($class){
        require "class.php";
    }
);

// spl_autoload_register(function ($class) {
//     // Converte as barras invertidas para barras normais no nome da classe (compatibilidade com namespaces)
//     $classPath = str_replace("\\", DIRECTORY_SEPARATOR, $class);

//     // Caminho do diretório onde as classes estão localizadas
//     $classFile = "class" . DIRECTORY_SEPARATOR . $classPath . ".php";

//     if (file_exists($classFile)) {
//         require $classFile;
//     }
// });

?>