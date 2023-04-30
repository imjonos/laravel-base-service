<?php

namespace Nos\BaseService;

use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Nos\BaseRepository\EloquentRepository as BaseRepository;

abstract class BaseService
{
    protected string $repositoryClass = BaseRepository::class;
    private ?BaseRepository $repository = null;

    /**
     * @throws BindingResolutionException
     */
    public function paginate(
        int $pageNumber = 1,
        int $pageSize = 10,
        callable $builderCallback = null
    ): LengthAwarePaginator {
        Paginator::currentPageResolver(function () use ($pageNumber) {
            return $pageNumber;
        });
        $query = $this->getRepository()->query();

        if ($builderCallback) {
            $query = $builderCallback($query);
        }

        return $query->paginate($pageSize);
    }

    /**
     * @throws BindingResolutionException
     */
    public function getRepository(): BaseRepository
    {
        if (!$this->repository) {
            $this->repository = app()->make($this->repositoryClass);
        }

        return $this->repository;
    }

    /**
     * @throws BindingResolutionException
     */
    public function all(): Collection
    {
        return $this->getRepository()->all();
    }

    /**
     * @throws BindingResolutionException
     */
    public function count(): int
    {
        return $this->getRepository()->count();
    }

    /**
     * @throws BindingResolutionException
     */
    public function updateOrCreate(array $attributes, array $data): Model
    {
        return $this->getRepository()->query()->updateOrCreate($attributes, $data);
    }

    /**
     * @throws BindingResolutionException
     */
    public function find(int $modelId): Model
    {
        return $this->getRepository()->find($modelId);
    }

    /**
     * @throws BindingResolutionException
     */
    public function update(int $modelId, array $data): bool
    {
        return $this->getRepository()->update($modelId, $data);
    }

    /**
     * @throws BindingResolutionException
     */
    public function exists(int $modelId): bool
    {
        return $this->getRepository()->exists($modelId);
    }

    /**
     * @throws Exception
     */
    public function create(array $data): Model
    {
        $model = $this->getRepository()->create($data);

        if (!$model) {
            throw new Exception(trans('exceptions.not_created'));
        }

        return $model;
    }

    /**
     * @throws BindingResolutionException
     */
    public function delete(int $modelId): bool
    {
        return $this->getRepository()->delete($modelId);
    }
}
