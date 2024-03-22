<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppConfig extends Model
{
    use HasFactory;

    /**
     * Allow all attributes to be mass assignable.
     *
     * @var array<string>
     */
    protected $guarded = [];

    /**
     * Get the the JSON data as an array.
     *
     * @param  string  $value
     * @return object
     */
    public function getJsondataAttribute($value): object
    {
        return json_decode($value);
    }
}
