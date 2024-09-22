<?php

namespace App\Casts;

use App\Factories\StackResourcesFactory;
use App\Stacks\StackBase;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

class StackResources implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return StackResourcesFactory::create(
            $model->credential->type->value,
            json_decode($attributes['stack_resources'], true)
        );
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if (! $value instanceof StackBase) {
            throw new InvalidArgumentException('The given value is not a stack instance.');
        }

        return json_encode($value->getStack());
    }
}
