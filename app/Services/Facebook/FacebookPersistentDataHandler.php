<?php

namespace App\Services\Facebook;

use Facebook\PersistentData\PersistentDataInterface;

class FacebookPersistentDataHandler implements PersistentDataInterface
{
    public function get($key)
    {
        return cache()->get($key);
    }

    public function set($key, $value): void
    {
        cache()->put($key, $value);
    }
}
