<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registrar extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    protected $dates = ['created_at', 'updated_at'];

    public function domains()
    {
        return $this->hasMany(Domain::class);
    }
}
