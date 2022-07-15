<?php

declare(strict_types=1);

namespace Inventory\Http;

class Response
{
    /** @var int The response status code */
    private int $httpCode = 200;

    /** @var array The response headers */
    private array $headers;

    /** @var string The response return content type */
    private string $contentType = 'text/html';

    /** @var mixed The content of content type */
    private mixed $content;

    public function __construct(
        int $httpCode, 
        mixed $content ,
        string $contentType = 'text/html'
    ) {
        $this->httpCode = $httpCode;
        $this->content = $content;
        $this->handleContentType($contentType);
    }
    
    /**
     * Responsible for change the response content type
     *
     * @param string $contentType
     * @return void
     */
    public function handleContentType(string $contentType): void
    {
        $this->contentType = $contentType;
        $this->addHeader('Content-Type', $contentType);
    }

    /**
     * Responsible for add a register into response header
     *
     * @param string $key
     * @param string $value
     * @return void
     */
    public function addHeader(string $key, string $value)
    {
        $this->headers[$key] = $value;
    }

    /**
     * Responsible for send the headers to the client
     *
     * @return void
     */
    private function sendHeaders(): void
    {
        // Set Status
        http_response_code($this->httpCode);

        // Send headers
        foreach ($this->headers as $key => $value) {
            header($key . ': ' . $value);
        }
    }

    /**
     * Responsible for send the response to the client
     *
     * @return void
     */
    public function sendResponse(): void
    {
        // Send the headers
        $this->sendHeaders();

        // Print the content
        switch ($this->contentType) {
            case 'text/html':
                echo $this->content;
                exit;
        }
    }
}
