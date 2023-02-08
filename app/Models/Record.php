<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'ext_name',
        'gender',
        'bdate',
        'num_street',
        'barangay_id',
        'municipality',
    ];

    public function scopeSearch($query, $searchTerm)
    {
        $searchTerm = "%$searchTerm%";

        $query->where(function($query) use ($searchTerm){

            $query->where('first_name','like', $searchTerm)
            ->orWhere('last_name','like', $searchTerm);
        });

    }
}
