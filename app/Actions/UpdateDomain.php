<?php

namespace App\Actions;

use App\Models\Domain;
use Carbon\Carbon;

class UpdateDomain
{
    public function handle(Domain $domain, array $data)
    {
        $domain->nameservers()->delete();
        $domain->domain_name = $data['domain_name'];
        $domain->tld = $data['tld'];
        $domain->created_at = Carbon::now();
        $domain->expiration_at = null;
        $domain->owner = null;
        $domain->registrar_id = null;
        $domain->save();
        return $domain;
    }
}
