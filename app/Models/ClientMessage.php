<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property-read int $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $message
 * @property bool $processed
 */
class ClientMessage extends Model
{
    protected $table = 'clients_messages';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'message',
        'processed'
    ];
}
