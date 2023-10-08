<?php

namespace App\Models\Sanctum;

use App\Traits\Uuid;
use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;

//use OwenIt\Auditing\Contracts\Auditable;

class PersonalAccessToken extends SanctumPersonalAccessToken// implements Auditable
{
    use Uuid;

//    use \OwenIt\Auditing\Auditable;

    public $incrementing = false;
    protected $keyType = 'string';
}
