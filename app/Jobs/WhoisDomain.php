<?php

namespace App\Jobs;

use Iodev\Whois\Factory;
use App\Models\Registrar;
use App\Models\Domain;

class WhoisDomain extends Job
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    private $domain;
    public function __construct(Domain $domain)
    {
        $this->domain = $domain;
    }
    /**
     * The number of seconds after which the job's unique lock will be released.
     *
     * @var int
     */
    public $uniqueFor = 3600;

    /**
     * The unique ID of the job.
     *
     * @return string
     */
    public function uniqueId()
    {
        return $this->domain->id;
    }
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $whois = Factory::get()->createWhois();
        $info = $whois->loadDomainInfo($this->domain->full_domain);
        if ($info) {
            $registrar = Registrar::firstOrCreate([
                'name' => $info->registrar
            ]);
            $this->domain->registrar_id = $registrar->id;
            $this->domain->owner = $info->owner ?? null;
            $this->domain->created_at = date("Y-m-d", $info->creationDate) ?? $this->domain->created_at;
            $this->domain->expiration_at = date("d.m.Y H:i:s", $info->expirationDate) ?? null;
            $this->domain->save();
            foreach ($info->nameServers as $nameserver) {
                $this->domain->nameservers()->create([
                    'nameserver' => $nameserver
                ]);
            }
        }
    }
}
