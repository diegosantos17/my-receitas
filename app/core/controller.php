<?php

namespace app\core;

abstract class Controller
{
    protected function load(string $view, $params = [])
    {
        if(
            (
                $view != "auth/main" 
                && $view != "usuario/create" 
                && $view != "usuario/forgot"
                && $view != "usuario/resetPassword"
            ) 
            && !isset($_SESSION["Usuario"])){
            header("Location: " . BASE . "auth");
        }

        // Caminho onde estão nossos templates
        $twig = new \Twig\Environment((new \Twig\Loader\FilesystemLoader("../app/site/view/")),
            ["debug" => false]
        );

        // Constante que poderá ser usada nas views com {{BASE}}
        $twig->addGlobal("BASE", BASE);
        $twig->addGlobal('session', $_SESSION);

        echo $twig->render($view . ".twig.php", $params);
    }
}
