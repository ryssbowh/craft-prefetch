<?php

namespace Ryssbowh\CraftPrefetch\variables;

use Ryssbowh\CraftPrefetch\Prefetch;

class PrefetchVariable
{
	/**
	 * Forward all calls to the service
	 * 
	 * @param  string $name
	 * @param  array $arguments
	 */
    public function __call($name, $arguments)
    {
        return Prefetch::$plugin->prefetch->$name(...$arguments);
    }
}
