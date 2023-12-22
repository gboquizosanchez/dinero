<?php

declare(strict_types=1);

namespace Laravel;

use Illuminate\Foundation\Application as LaravelApplication;
use Override;

final class Application extends LaravelApplication
{
    protected $namespace = 'Taka\\';

    #[Override]
    public function path($path = ''): string
    {
        return sprintf(
            '%s%ssrc%s',
            $this->basePath,
            DIRECTORY_SEPARATOR,
            $path ? DIRECTORY_SEPARATOR . $path : $path
        );
    }
}
