<?php

namespace App\Observers;

use App\Jobs\WhoisDomain;

/**
 * Lumen doesn't register observers like laravel, so I created this trait to make it simpler
 */
trait DomainObserver
{
    protected static function boot()
    {
        parent::boot();
        static::deleted(function ($domain) {
            $domain->nameservers()->delete();
        });
        static::created(function ($domain) {
            dispatch(new WhoisDomain($domain));
        });
        static::updated(function ($domain) {
            dispatch(new WhoisDomain($domain));
        });
    }
}
