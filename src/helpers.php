<?php

declare(strict_types=1);

//declare(strict_types=1);

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Taka\Domain\Models\User;

if (! function_exists('current_user')) {
    function current_user(string $guard = 'web'): Authenticatable|User
    {
        return Auth::guard($guard)->user();
    }
}

function country_with_currency_and_symbol($state = null): Collection|string
{
    $countries = collect(countries())->mapWithKeys(function ($country) {
        try {
            $currency = currency($country['currency']);

            return [
                $country['currency'] => sprintf('%s - %s - %s (%s)',
                    $country['name'], $currency->getCurrency(),
                    $currency->getName(), $currency->getSymbol()),
            ];
        } catch (\Exception $e) {
            return [null => null];
        }
    })->filter();

    if ($state) {
        return $countries->get($state);
    }

    return $countries;
}

function month_ordinal_numbers(): Collection
{
    return collect(range(1, 31))->map(fn ($day) => sprintf('%s%s', $day,
        match ($day) {
            1 => 'st',
            2 => 'nd',
            3 => 'rd',
            default => 'th'
        }));
}
