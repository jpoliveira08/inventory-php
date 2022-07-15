<?php

declare(strict_types=1);

namespace Inventory\Http;

use Closure;
use Exception;
use ReflectionFunction;

class Router
{
    /** @var string Complete URL */
    private string $url = '';

    /** @var string Prefix of all routes  */
    private $prefix = '';

    /** @var array  Routes indexes */
    private $routes = [];

    /** @var Request Request instance */
    private Request $request;

    public function __construct(string $url)
    {
        $this->request = new Request();
        $this->url = $url;
        $this->setPrefix();
    }

    /**
     * Responsible for define routes prefix
     *
     * @return void
     */
    private function setPrefix()
    {
        // URL information
        $parseUrl = parse_url($this->url);

        $this->prefix = $parseUrl['path'] ?? '';
    }

    /**
     * Responsible for add a route to the class
     *
     * @param string $method
     * @param string $route
     * @param array $params
     * @return void
     */
    private function addRoute(string $method, string $route, array $params = [])
    {
        // Params validation
        foreach ($params as $key => $value) {
            if ($value instanceof Closure) {
                $params['controller'] = $value;
                unset($params[$key]);
                continue;
            }
        }

        // Route vars
        $params['variables'] = [];

        // Pattern for route vars
        $patternVariable = '/{(.*?)}/';
        if (preg_match_all($patternVariable, $route, $matches)) {
            $route = preg_replace($patternVariable, '(.*?)', $route);
            $params['variables'] = $matches[1];
        }

        // Creating a pattern to validate our route
        $patternRoute = '/^' . str_replace('/', '\/', $route) . '$/';
        
        // Adding the route inside the class
        $this->routes[$patternRoute][$method] = $params;
    }

    /**
     * Responsible for define a GET route
     *
     * @param string $route
     * @param array $params
     */
    public function get(string $route, array $params = [])
    {
        return $this->addRoute('GET', $route, $params);
    }

    /**
     * Responsible for define a POST route
     *
     * @param string $route
     * @param array $params
     */
    public function post(string $route, array $params = [])
    {
        return $this->addRoute('POST', $route, $params);
    }

    /**
     * Responsible for define a PUT route
     *
     * @param string $route
     * @param array $params
     */
    public function put(string $route, array $params = [])
    {
        return $this->addRoute('PUT', $route, $params);
    }

    /**
     * Responsible for define a DELETE route
     *
     * @param string $route
     * @param array $params
     */
    public function delete(string $route, array $params = [])
    {
        return $this->addRoute('DELETE', $route, $params);
    }

    /**
     * Responsible for return the uri without prefix
     *
     * @return string
     */
    public function getUri()
    {
        $uri = $this->request->getUri();
        
        $xUri = strlen($this->prefix) ? explode($this->prefix, $uri) : [$uri];

        return end($xUri);
    }

    /**
     * Responsible for return data from current route
     *
     * @return array
     */
    private function getRoute()
    {
        $uri = $this->getUri();

        $httpMethod = $this->request->getHttpMethod();

        // Route validation
        foreach ($this->routes as $patternRoute => $methods) {
            // Check uri matches with default
            if (preg_match($patternRoute, $uri, $matches)) {
                // Check the method
                if ($methods[$httpMethod]) {
                    // Remove the first position that corresponds the entire URL
                    unset($matches[0]);
                    // keys
                    $keys = $methods[$httpMethod]['variables'];
                    $methods[$httpMethod]['variables'] = array_combine($keys, $matches);
                    $methods[$httpMethod]['variables']['request'] = $this->request;

                    return $methods[$httpMethod];
                }
                throw new Exception("Method Not Allowed", 405);
            }
        }

        throw new Exception ("Not Found", 404);
    }

    /**
     * Responsible for execute the current route
     *
     * @return Response
     */
    public function run(): Response
    {
        // Function args
        $args = [];
        try {
            // Get the current route
            $route = $this->getRoute();
            
            // Checking the controller
            if (!isset($route['controller'])) {
                throw new Exception("The URL cannot be processed", 500);
            }

            $reflection = new ReflectionFunction($route['controller']);
            foreach ($reflection->getParameters() as $parameter) {
                $name = $parameter->getName();

                $args[$name] = $route['variables'][$name] ?? '';
            }
            // Returns the function execution
            return call_user_func_array($route['controller'], $args);
        } catch (Exception $e) {
            return new Response($e->getCode(), $e->getMessage());
        }
    }
}
