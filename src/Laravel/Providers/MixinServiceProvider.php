<?php

declare(strict_types=1);

namespace Laravel\Providers;

use Illuminate\Support\ServiceProvider;
use Override;

final class MixinServiceProvider extends ServiceProvider
{
    /** @var array<string|class-string, string|class-string> */
    protected array $mixins = [
        // Silence is golden.
    ];

    /**
     * @throws \ReflectionException
     */
    #[Override]
    public function register(): void
    {
        foreach ($this->mixins as $class => $mixin) {
            $class::mixin(new $mixin());
        }
    }
}
