<?php

declare(strict_types=1);

namespace Taka\Support;

use ArchTech\Enums\From;
use ArchTech\Enums\InvokableCases;
use ArchTech\Enums\Metadata;
use ArchTech\Enums\Names;
use ArchTech\Enums\Options;
use ArchTech\Enums\Values;

trait EnumTrait
{
    use From;
    use InvokableCases;
    use Metadata;
    use Names;
    use Options;
    use Values;
}
