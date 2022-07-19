<?php

declare(strict_types=1);

namespace Inventory\Services;

class PaginationService
{
    private int $limit;

    private int $results;

    private $pages;

    private int $currentPage;

    public function __construct(int $results, int $currentPage = 1, int $limit = 10)
    {
        $this->results = $results;
        $this->limit = $limit;
        $this->currentPage = (is_numeric($currentPage) and $currentPage > 0) ?
            $currentPage : 1;
        $this->calculate();
    }

    private function calculate(): void
    {
        $this->pages = $this->results > 0 ? ceil($this->results / $this->limit) : 1;

        $this->currentPage = $this->currentPage <= $this->pages ?
            $this->currentPage : $this->pages;
    }

    public function getLimit(): string
    {
        $offset = ($this->limit * ($this->currentPage - 1));
        return $offset. ',' . $this->limit;
    }

    public function getPages()
    {
        if ($this->pages == 1) {
            return [];
        }

        $pages = [];
        
        for ($i = 1; $i <= $this->pages; $i++) {
            $pages[] = [
                'page' => $i,
                'current' => $i == $this->currentPage
            ];
        }

        return $pages;
    }
}
