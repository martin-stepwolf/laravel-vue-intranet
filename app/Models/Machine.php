<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    public function machine_state()
    {
        return $this->belongsTo(Machine_state::class);
    }

    protected $casts = [
        'common_failures' => 'array'
    ];

    protected $hidden = [
        'machine_state_id'
    ];
}