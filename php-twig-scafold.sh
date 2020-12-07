echo "PSR Naming Convetions https://www.php-fig.org/bylaws/psr-naming-conventions/" > README.MD
mkdir app
cd app
mkdir core
cd core

echo '<?php' > router.php
echo '' >> router.php
echo 'namespace app\core;' >> router.php
echo '' >> router.php
echo 'class Router' >> router.php
echo '{' >> router.php
echo '    private $uriEx;' >> router.php
echo '' >> router.php
echo '    public function __construct()' >> router.php
echo '    {' >> router.php
echo '        $this->init();' >> router.php
echo '        $this->execute();' >> router.php
echo '    }' >> router.php
echo '' >> router.php
echo '    private function init()' >> router.php
echo '    {' >> router.php
echo '        $uri = $_SERVER["REQUEST_URI"];' >> router.php
echo '' >> router.php
echo '        $uri = str_replace("?", "/", $uri);' >> router.php
echo '' >> router.php
echo '        $ex = explode("/", $uri);' >> router.php
echo '' >> router.php
echo '        $ex = array_values(array_filter($ex));' >> router.php
echo '' >> router.php
echo '        for ($i = 0; $i < UNSET_COUNT; $i++)' >> router.php
echo '            unset($ex[$i]);' >> router.php
echo '' >> router.php
echo '        $this->uriEx = $ex = array_values(array_filter($ex));' >> router.php
echo '    }' >> router.php
echo '' >> router.php
echo '    private function execute()' >> router.php
echo '    {' >> router.php
echo '        $class  = "HomeController";' >> router.php
echo '        $method = "index";' >> router.php
echo '' >> router.php
echo '        if (isset($this->uriEx[0])) {' >> router.php
echo '            $c = "app\\site\\controller\\" . ucfirst($this->uriEx[0]) . "Controller";' >> router.php
echo '            if (class_exists($c)) {' >> router.php
echo '                $class = ucfirst($this->uriEx[0]) . "Controller";' >> router.php
echo '            }' >> router.php
echo '        }' >> router.php
echo '' >> router.php
echo '        $controller = "app\\site\\controller\\" . $class;' >> router.php
echo '' >> router.php
echo '        if (isset($this->uriEx[1])) {' >> router.php
echo '            if (method_exists($controller, $this->uriEx[1])) {' >> router.php
echo '                $method = $this->uriEx[1];' >> router.php
echo '            }' >> router.php
echo '        }' >> router.php
echo '' >> router.php
echo '        call_user_func_array(' >> router.php
echo '            [' >> router.php
echo '                new $controller(),' >> router.php
echo '                $method' >> router.php
echo '            ],' >> router.php
echo '            $this->getParams()' >> router.php
echo '        );' >> router.php
echo '    }' >> router.php
echo '' >> router.php
echo '    private function getParams()' >> router.php
echo '    {' >> router.php
echo '        $p = [];' >> router.php
echo '' >> router.php
echo '        if (count($this->uriEx) > 2) {' >> router.php
echo '            for ($i = 2; $i < count($this->uriEx); $i++)' >> router.php
echo '                $p[] = $this->uriEx[$i];' >> router.php
echo '        }' >> router.php
echo '' >> router.php
echo '        return $p;' >> router.php
echo '    }' >> router.php
echo '}' >> router.php

touch model.php
echo "Criando Controller Base" 

echo '<?php' > controller.php
echo '' >> controller.php
echo 'namespace app\core;' >> controller.php
echo '' >> controller.php
echo 'class Controller' >> controller.php
echo '{' >> controller.php
echo '    protected function load(string $view, $params = [])' >> controller.php
echo '    {' >> controller.php
echo '        // Caminho onde estão nossos templates' >> controller.php
echo '        $twig = new \Twig\Environment((new \Twig\Loader\FilesystemLoader("../app/site/view/")),' >> controller.php
echo '            ["debug" => false]' >> controller.php
echo '        );' >> controller.php
echo '' >> controller.php
echo '        // Constante que poderá ser usada nas views com {{BASE}}' >> controller.php
echo '        $twig->addGlobal("BASE", BASE);' >> controller.php
echo '' >> controller.php
echo '        echo $twig->render($view . ".twig.php", $params);' >> controller.php
echo '    }' >> controller.php
echo '}' >> controller.php

cd ..
mkdir config
cd config
echo '<?php ' > global.php
echo 'define("BASE", "/'$1'/");' >> global.php
echo 'define("UNSET_COUNT", 1);' >> global.php
echo '' >> global.php
echo 'define("DB_HOST", "localhost");' >> global.php
echo 'define("DB_USER", "root");' >> global.php
echo 'define("DB_PASS", "");' >> global.php
echo 'define("DB_NAME", "myreceitas");' >> global.php

cd ..
mkdir site
cd site 
mkdir controller
cd controller

echo "Criando HomeController.php"

echo '<?php' > HomeController.php
echo '' >> HomeController.php
echo 'namespace app\site\controller;' >> HomeController.php
echo '' >> HomeController.php
echo 'use app\core\Controller;' >> HomeController.php
echo '' >> HomeController.php
echo 'class HomeController extends Controller' >> HomeController.php
echo '{' >> HomeController.php
echo '    public function index()' >> HomeController.php
echo '    {' >> HomeController.php
echo '		$bemVindo = "Bem vindo"' >> HomeController.php
echo '        $this->load("home/main", $bemVindo);' >> HomeController.php
echo '    }' >> HomeController.php
echo '}' >> HomeController.php

cd ..

mkdir model
mkdir view
cd view 
touch main.twig.php
mkdir partials
mkdir home
cd home
echo '{% extends "main.twig.php" %}' > main.twig.php
echo '' >> main.twig.php
echo '{% block title %} Minhas Receitas {% endblock %}' >> main.twig.php
echo '' >> main.twig.php
echo '{% block body %}' >> main.twig.php
echo '<h1>Homepage</h1>' >> main.twig.php
echo '<hr>' >> main.twig.php
echo '' >> main.twig.php
echo '{% endblock %}' >> main.twig.php
cd ../..
mkdir crosscuting	
mkdir infraestrutura
cd infraestrutura
mkdir contracts
cd ..
mkdir repository		
cd ../..
mkdir public
cd public

echo "Criando .htaccess"
echo ".htaccess (SUCESSO)"
echo 'RewriteEngine on' > .htaccess
echo 'RewriteCond %{REQUEST_FILENAME} !-f' >> .htaccess
echo 'RewriteCond %{REQUEST_FILENAME} !-d' >> .htaccess
echo 'RewriteRule ^(.*)$ index.php [NC,L]' >> .htaccess
echo '' >> .htaccess
echo 'Options -Indexes' >> .htaccess
echo "Criando (SUCESSO)"

mkdir uploads

echo '<?php' > index.php
echo 'require_once("..\vendor\autoload.php");' >> index.php
echo 'require_once("..\app\config\global.php");' >> index.php
echo '' >> index.php
echo 'use app\core\Router;' >> index.php
echo '(new Router());' >> index.php

cd ..
echo "Criando .htaccess"
echo 'RewriteEngine On' > .htaccess
echo 'RewriteBase /' >> .htaccess
echo '' >> .htaccess
echo 'RewriteCond %{THE_REQUEST} public/([^\s?]*) [NC]' >> .htaccess
echo 'RewriteRule ^ %1 [L,NE,R=302]' >> .htaccess
echo 'RewriteRule ^((?!public/).*)$ '$1'/public/$1 [L,NC]' >> .htaccess
echo ".htaccess (SUCESSO)"

echo "Criando composer.json"
echo '{' > composer.json
echo '	"name":"app/'$1'",' >> composer.json
echo '	"description": "'$2'",' >> composer.json
echo '	"require":' >> composer.json
echo '	{' >> composer.json
echo '		"twig/twig": "^3.0"' >> composer.json
echo '	},' >> composer.json
echo '	"autoload": ' >> composer.json
echo '	{' >> composer.json
echo '		"psr-4": {' >> composer.json
echo '			"app\\": "app/"' >> composer.json
echo '		}' >> composer.json
echo '	}' >> composer.json
echo '}' >> composer.json
echo "composer.json (SUCESSO)"
echo "Executando Composer"
composer dump
composer install
echo "Composer (SUCESSO)"

echo "Configurando Admin2" 

git clone https://github.com/StartBootstrap/startbootstrap-sb-admin-2.git
cd startbootstrap-sb-admin-2
cp -r css ../public/css
cp -r img ../public/img
cp -r js ../public/js
cp -r scss ../public/scss
cp -r vendor ../public/vendor

cd ..
rm -rf startbootstrap-sb-admin-2

echo "Template Admin configurado"