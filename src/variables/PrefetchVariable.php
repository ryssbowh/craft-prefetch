<?php

namespace Ryssbowh\CraftPrefetch\variables;

use Ryssbowh\CraftPrefetch\Prefetch;

class PrefetchVariable
{
    public function dnsPrefetch(string $url)
    {
    	Prefetch::$plugin->prefetch->dnsPrefetch($url);
    }

    public function preconnect(string $url)
    {
    	Prefetch::$plugin->prefetch->preconnect($url);
    }

    public function prefetch(string $url)
    {
    	Prefetch::$plugin->prefetch->prefetch($url);
    }

    public function subresource(string $url)
    {
		Prefetch::$plugin->prefetch->subresource($url);
    }

    public function prerender(string $url)
    {
    	Prefetch::$plugin->prefetch->prerender($url);
    }

    public function preload(string $url)
    {
    	Prefetch::$plugin->prefetch->preload($url);
    }
}
