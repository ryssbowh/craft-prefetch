<?php

namespace Ryssbowh\CraftPrefetch\variables;

use Ryssbowh\CraftPrefetch\Prefetch;

class PrefetchVariable
{
    public function __call($name, $arguments)
    {
        return Prefetch::$plugin->prefetch->$name(...$arguments);
    }
}
