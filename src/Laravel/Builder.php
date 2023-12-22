<?php

declare(strict_types=1);

namespace Laravel;

use Illuminate\Database\Eloquent\Builder as LaravelBuilder;

/**
 * @template TModelClass of Model
 *
 * @extends LaravelBuilder<Model>
 */
class Builder extends LaravelBuilder
{
    // WIP
}
