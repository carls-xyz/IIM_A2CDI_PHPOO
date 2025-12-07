<?php



/**
 * Routeur pour gérer les routes de l'application
 */
class Router
{
    private array $routes = [];

    /**
     * Enregistre une route GET
     */
    public function get(string $path, string $controller, string $method): void
    {
        $this->routes['GET'][$path] = [$controller, $method];
    }

    /**
     * Enregistre une route POST
     */
    public function post(string $path, string $controller, string $method): void
    {
        $this->routes['POST'][$path] = [$controller, $method];
    }

    /**
     * Distribue la requête vers le bon contrôleur
     */
    public function dispatch(string $uri, string $httpMethod = 'GET'): void
    {
        $path = parse_url($uri, PHP_URL_PATH);
        
        // Gestion des sous-dossiers (si le script n'est pas à la racine)
        $scriptName = $_SERVER['SCRIPT_NAME'];
        $scriptDir = dirname($scriptName);

        // Si on est dans un sous-dossier, on retire ce chemin du path de l'URI
        if ($scriptDir !== '/' && $scriptDir !== '\\' && strpos($path, $scriptDir) === 0) {
            $path = substr($path, strlen($scriptDir));
        }

        // Si le path est vide après nettoyage, c'est la racine
        if ($path === '' || $path === false) {
            $path = '/';
        }

        // Récupérer les paramètres GET (?id=5, etc.)
        parse_str(parse_url($uri, PHP_URL_QUERY) ?? '', $params);

        $httpMethod = strtoupper($httpMethod);
        
        // Vérifier si la route existe
        if (!isset($this->routes[$httpMethod][$path])) {
            http_response_code(404);
            echo '<h1>404 - Page non trouvée</h1>';
            echo '<p>Route demandée (après nettoyage) : ' . htmlspecialchars($path) . '</p>';
            echo '<p>URI brute : ' . htmlspecialchars($uri) . '</p>';
            echo '<p>Méthode : ' . $httpMethod . '</p>';
            echo '<a href="' . $scriptDir . '/">Retour à l\'accueil</a>';
            return;
        }

        [$controllerClass, $method] = $this->routes[$httpMethod][$path];

        // Vérifier que la classe du contrôleur existe
        if (!class_exists($controllerClass)) {
            http_response_code(500);
            echo "Erreur : Contrôleur $controllerClass introuvable";
            return;
        }

        $controller = new $controllerClass();

        // Vérifier que la méthode existe
        if (!method_exists($controller, $method)) {
            http_response_code(500);
            echo "Erreur : Méthode $method introuvable dans $controllerClass";
            return;
        }

        // Appeler la méthode avec le paramètre id si présent
        if (!empty($params['id'])) {
            $controller->$method((int)$params['id']);
        } else {
            $controller->$method();
        }
    }
}