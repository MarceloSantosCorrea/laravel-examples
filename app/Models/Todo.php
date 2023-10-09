<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string id
 * @property string body
 * @property bool checked
 * @property string created_at
 * @property string updated_at
 */
class Todo extends Model
{
    use HasFactory;

    // use Uuid; // com clean architecture o id é gerado na entidade

    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'body',
        'checked',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'checked' => 'boolean',
    ];
}
