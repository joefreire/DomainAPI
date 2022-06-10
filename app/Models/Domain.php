<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Observers\DomainObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Domain extends Model
{
    use DomainObserver,HasFactory;

    protected $fillable = [
        'domain_name', 'tld','created_at', 'expiration_at', 'owner'
    ];
    protected $with = [
        'nameservers', 'registrar'
    ];

    protected $dates = ['created_at', 'updated_at', 'expiration_at'];
    public function nameservers()
    {
        return $this->hasMany(Nameserver::class);
    }
    public function getFullDomainAttribute()
    {
        return $this->domain_name.$this->tld;
    }
    public function registrar()
    {
        return $this->belongsTo(Registrar::class);
    }
}
