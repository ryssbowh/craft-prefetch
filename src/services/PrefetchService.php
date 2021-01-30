<?php

namespace Ryssbowh\CraftPrefetch\services;

use craft\base\Component;
use craft\web\View;

class PrefetchService extends Component
{
    protected $registered = [];

    public function dnsPrefetch(string $url, bool $now = false)
    {
    	$this->register($url, 'dns-prefetch', $now);
    }

    public function preconnect(string $url, bool $now = false)
    {
    	$this->register($url, 'preconnect', $now);
    }

    public function prefetch(string $url, bool $now = false)
    {
    	$this->register($url, 'prefetch', $now);
    }

    public function subresource(string $url, bool $now = false)
    {
		$this->register($url, 'subresource', $now);
    }

    public function prerender(string $url, bool $now = false)
    {
    	$this->register($url, 'prerender', $now);
    }

    public function preload(string $url, bool $now = false)
    {
    	$this->register($url, 'preload', $now);
    }

    public function onPrefetchHook()
    {
        foreach ($this->registered as $type => $urls) {
            foreach ($urls as $url) {
                echo '<link rel="'.$type.'" href="'.$url.'">\n';
            }
        }
    }

    protected function register(string $url, string $type, bool $now)
    {
        if ($now) {
    	   \Craft::$app->view->registerHtml('<link rel="'.$type.'" href="'.$url.'">', View::POS_HEAD);
        } else {
            $this->registered[$type][] = $url;
        }
    }
}
