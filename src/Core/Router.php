<?php

namespace Core;

/**
 * Class Router
 * @package Core
 */
class Router
{
    /** @var array $routes */
    protected $routes = [];

    /** @var array $params */
    protected $params = [];

    /**
     * Add route to the routing table
     *
     * @param $route
     * @param $params
     */
    public function add(string $route, $params = [])
    {
        // Convert route to regular expression
        $route = preg_replace('/\//','\\/', $route);

        // Convert variables e.g. {controller}
        $route = preg_replace('/\{([a-z]+)\}/','(?P<\1>[a-z-]+)', $route);

        // Convert variables with custom regular expressions e.g. {id:\d+}
        $route = preg_replace('/\{([a-z]+):([^\}]+)\}/','(?P<\1>\2)', $route);

        // Add start and end delimiters, and case sensitive flag
        $route = '/^' . $route . '$/i';

        $this->routes[$route] = $params;
    }

    /**
     * @return array
     */
    public function getRoutes() : array
    {
        return $this->routes;
    }

    /**
     * @param $url
     * @return bool
     */
    public function match($url)
    {
//        $regExp = '/^(?P<controller>[a-z-]+)\/(?P<action>[a-z-]+)$/';

        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                foreach ($matches as $key => $match) {
                    if (is_string($key)) {
                        $params[$key] = $match;
                    }
                }
                /** @var array $params */
                $this->params = $params;
                return true;
            }
        }
        return false;
    }

    /**
     * @return array|null
     */
    public function getParams()
    {
        return $this->params;
    }
}