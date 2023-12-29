<?php

namespace FocusSportsLabs\FslDataCenter\DataObjects;

use FocusSportsLabs\FslDataCenter\DataObjects\Contracts\DataObjectContract;

class Collection
{
    protected bool $paginated = false;

    /** @var array<int, DataObjectContract> */
    protected array $data = [];

    protected int $currentPage = 0;

    protected int|false $nextPage = false;

    protected int|false $previousPage = false;

    protected array $paginationInfo = [];

    protected array $meta = [];

    /**
     * @param  class-string<DataObjectContract>  $class
     */
    public function __construct(array $response, string $class)
    {
        $this->data = $this->transformCollection($response['data'] ?? [], $class);

        if (isset($response['meta'], $response['meta']['pagination'])) {
            $this->paginated = true;

            $this->paginationInfo = (array) $response['meta']['pagination'];

            $this->currentPage = (int) $this->paginationInfo['current_page'];
            $this->nextPage = isset($this->paginationInfo['links']['next']) ? $this->currentPage + 1 : false;
            $this->previousPage = isset($this->paginationInfo['links']['previous']) ? $this->currentPage - 1 : false;
        }

        unset($response['meta']['pagination']);

        $this->meta = $response['meta'] ?? [];
    }

    public function isPaginated(): bool
    {
        return $this->paginated;
    }

    /** @return array<int, DataObjectContract> */
    public function getData(): array
    {
        return $this->data;
    }

    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    public function getNextPage(): int|false
    {
        return $this->nextPage;
    }

    public function getPreviousPage(): int|false
    {
        return $this->previousPage;
    }

    public function getPaginationInfo(): array
    {
        return $this->paginationInfo;
    }

    /**
     * @param  array<int, array>  $collection
     * @param  class-string<DataObjectContract>  $class
     * @return array<int, DataObjectContract>
     */
    protected function transformCollection(array $collection, string $class): array
    {
        return array_map(fn($data) => $class::fromArray($data), $collection);
    }
}
