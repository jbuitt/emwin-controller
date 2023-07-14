<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SysLog extends Model
{
    use HasFactory;

    /**
     * The database table that should be used by the model.
     *
     * @var string
     */
    protected $connection = 'syslog';

    /**
     * The database table that should be used by the model.
     *
     * @var string
     */
    protected $table = 'SystemEvents';

}
