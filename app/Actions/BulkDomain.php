<?php

namespace App\Actions;

use App\Models\Domain;
use Carbon\Carbon;

class BulkDomain
{
    public function handle(array $data)
    {
        if (count($data) > 0) {
            Domain::insert($data);
            return $data;
        }
        return [];
    }
}
