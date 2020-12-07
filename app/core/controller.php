<?php

namespace app\core;

class Controller
{
    protected function load(string $view, $params = [])
    {
        if(
            (
                $view != "auth/main" 
                && $view != "usuario/main" 
                && $view != "usuario/esqueci"
            ) 
            && !isset($_SESSION["Usuario"])){
            header("Location: " . BASE . "auth");
        }

        // Caminho onde estão nossos templates
        $twig = new \Twig\Environment((new \Twig\Loader\FilesystemLoader("../app/site/view/")),
            ["debug" => false]
        );

        $twig->addFunction(
            new \Twig\TwigFunction('getenv', function ($key) {
                return getenv($key);
            })
        );

        // Constante que poderá ser usada nas views com {{BASE}}
        $twig->addGlobal("BASE", BASE);
        $twig->addGlobal('session', $_SESSION);

        echo $twig->render($view . ".twig.php", $params);
    }
}
