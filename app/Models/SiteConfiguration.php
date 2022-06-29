<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property-read int $id
 * @property string $key
 * @property string $value
 */
class SiteConfiguration extends Model
{
    protected $fillable = [
        'key',
        'value',
    ];
    protected $table = 'site_configurations';
}
