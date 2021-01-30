<?php

namespace Ryssbowh\CraftPrefetch\variables;

class PrefetchVariable
{
    public function dnsPrefetch(string $url)
    {
    	$this->register($url, 'dns-prefetch');
    }

    public function preconnect(string $url)
    {
    	$this->register($url, 'preconnect');
    }

    public function prefetch(string $url)
    {
    	$this->register($url, 'prefetch');
    }

    public function subresource(string $url)
    {
		$this->register($url, 'subresource');
    }

    public function prerender(string $url)
    {
    	$this->register($url, 'prerender');
    }

    public function preload(string $url)
    {
    	$this->register($url, 'preload');
    }

    protected function register(string $url, string $type)
    {
    	\Craft::$app->view->registerHtml('<link rel="'.$type.'" href="'.$url.'">', View::POS_HEAD);
    }
}
