<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**\
 * @property-read int $id
 * @property string $title
 * @property string $description
 * @property string $category
 * @property int $file_id
 * @property-read File $file
 *
 */
class Project extends Model
{
    protected $table = 'projects';

    protected $fillable = [
        'title',
        'description',
        'category',
    ];

    public function file(): HasOne
    {
        return $this->hasOne(File::class, 'file_id');
    }
}
