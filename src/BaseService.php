<?php

namespace Nos\BaseService;

use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Model;
use Nos\BaseRepository\EloquentRepository as BaseRepository;

abstract class BaseService
{
    protected string $repositoryClass = BaseRepository::class;
    private ?BaseRepository $repository = null;

    
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
