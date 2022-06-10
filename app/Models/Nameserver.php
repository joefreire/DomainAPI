<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nameserver extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nameserver'
    ];

    protected $dates = ['created_at', 'updated_at'];

    public function domains()
    {
        return $this->hasOne(Domain::class);
    }
}
