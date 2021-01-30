<?php

namespace Ryssbowh\CraftPrefetch\services;

use craft\base\Component;
use craft\web\View;

class PrefetchService extends Component
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
