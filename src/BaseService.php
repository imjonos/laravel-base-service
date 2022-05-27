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
    public function update(int $modeId, array $data): bool
    {
        return $this->getRepository()->update($modeId, $data);
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
    public function delete(int $modeId): bool
    {
        return $this->getRepository()->delete($modeId);
    }
}
