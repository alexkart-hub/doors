<?php

namespace app;

class Request
{
    private array $queryParams;
    private array $postParams;
    private array $serverParams;

    public function __construct(array $queryParams, array $postParams, array $serverParams)
    {
        $this->queryParams = $queryParams;
        $this->postParams = $postParams;
        $this->serverParams = $serverParams;
    }

    public function getQueryParams(): array
    {
        return $this->queryParams;
    }

    public function getPostParams(): array
    {
        return $this->postParams;
    }

    public function getServerParams($key = ''): array|string
    {
        if (empty($key)) {
            return $this->serverParams;
        } else {
            return $this->serverParams[$key];
        }
    }
}