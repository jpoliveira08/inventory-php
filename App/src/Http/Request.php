<?php

declare(strict_types=1);

namespace Inventory\Http;

class Request
{
    /** @var Router  */
    private Router $router;

    /** @var string Http method of the request */
    private string $httpMethod;

    /** @var string Page URI */
    private string $uri;

    /** @var array Parameters of the URL ($_GET)*/
    private array $queryParams;

    /** @var array Variables received by POST ($_POST) */
    private array $postVars;

    /** @var array Headers of the request */
    private array $headers;

    public function __construct(Router $router)
    {
        $this->router = $router;
        $this->queryParams = $_GET ?? [];
        $this->postVars = $_POST ??[];
        $this->headers = getallheaders();
        $this->httpMethod = $_SERVER['REQUEST_METHOD'] ?? '';
        $this->uri = $_SERVER['REQUEST_URI'] ?? '';
    }

    public function getRouter(): Router
    {
        return $this->router;
    }

    /**
     * Return the http method
     *
     * @return string
     */
    public function getHttpMethod(): string
    {
        return $this->httpMethod;
    }

    /**
     * Return the uri of the request
     *
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * Return the headers of the request
     *
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->header;
    }

    /**
     * Return the parameters of the request
     *
     * @return array
     */
    public function getQueryParams(): array
    {
        return $this->queryParams;
    }

    /**
     * Return the data of post request
     *
     * @return array
     */
    public function getPostVars(): array
    {
        return $this->postVars;
    }
}