<?php

declare(strict_types=1);

namespace Taka\Domain\Models;

use Laravel\Model;
use Shipu\Watchable\Traits\WatchableTrait;

/**
 * @mixin IdeHelperRecurring
 */
final class Recurring extends Model
{
    use WatchableTrait;
}
