<?php

namespace MultiversX\Http\Api;

use Illuminate\Support\Collection;
use MultiversX\Http\Entities\IEntity;
use MultiversX\Http\Exceptions\RequestException;
use Psr\Http\Message\ResponseInterface;

trait HasApiResponses
{
    public array $rawResponse = [];

    public static function fromApiResponse(ResponseInterface $res, bool $collection = false, bool $unwrapData = false): IEntity|Collection
    {
        static::throwIfError($res);

        $unpacked = json_decode($res->getBody()->getContents(), true);

        if ($unwrapData) {
            $unpacked = $unpacked['data'];
        }

        return $collection
            ? static::fromArrayMultiple($unpacked)
            : static::fromArray($unpacked);
    }

    public static function fromArray(array $data): IEntity
    {
        $entity = new static(...static::filterUnallowedProperties(
            static::transformResponse($data)
        ));

        $entity->rawResponse = $data;

        return $entity;
    }

    public static function fromArrayMultiple(array $data): Collection
    {
        return (new Collection($data))
            ->map(fn ($item) => static::fromArray($item));
    }

    protected static function transformResponse(array $res): array
    {
        return $res;
    }

    protected static function filterUnallowedProperties(array $res): array
    {
        return (new Collection($res))
            ->intersectByKeys(get_class_vars(static::class))
            ->all();
    }

    private static function throwIfError(ResponseInterface $res): void
    {
        $status = (int) $res->getStatusCode();
        $isServerError = $status >= 500;
        $isClientError = $status >= 400 && $status < 500;

        if ($isServerError || $isClientError) {
            throw new RequestException($res);
        }
    }
}
