<?php

namespace Ryssbowh\CraftPrefetch\variables;

use Ryssbowh\CraftPrefetch\Prefetch;

class PrefetchVariable
{
    public function dnsPrefetch(string $url, bool $now = false)
    {
    	Prefetch::$plugin->prefetch->dnsPrefetch($url, $now);
    }

    public function preconnect(string $url, bool $now = false)
    {
    	Prefetch::$plugin->prefetch->preconnect($url, $now);
    }

    public function prefetch(string $url, bool $now = false)
    {
    	Prefetch::$plugin->prefetch->prefetch($url, $now);
    }

    public function subresource(string $url, bool $now = false)
    {
		Prefetch::$plugin->prefetch->subresource($url, $now);
    }

    public function prerender(string $url, bool $now = false)
    {
    	Prefetch::$plugin->prefetch->prerender($url, $now);
    }

    public function preload(string $url, bool $now = false)
    {
    	Prefetch::$plugin->prefetch->preload($url, $now);
    }
}
