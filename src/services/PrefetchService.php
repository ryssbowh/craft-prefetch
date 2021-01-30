<?php

namespace Ryssbowh\CraftPrefetch\services;

use craft\base\Component;
use craft\web\View;

class PrefetchService extends Component
{
    protected $registered = [];

    public function dnsPrefetch(string $url, array $args = [])
    {
    	$this->register($url, 'dns-prefetch', $args);
    }

    public function preconnect(string $url, array $args = [])
    {
        $url_info = parse_url($url);
        if (\Craft::$app->request->hostName != $url_info['host']) {
            $args[] = 'crossorigin';
        }
    	$this->register($url, 'preconnect', $args);
    }

    public function prefetch(string $url, array $args = [])
    {
    	$this->register($url, 'prefetch', $args);
    }

    public function subresource(string $url, array $args = [])
    {
		$this->register($url, 'subresource', $args);
    }

    public function prerender(string $url, array $args = [])
    {
    	$this->register($url, 'prerender', $args);
    }

    public function preload(string $url, array $args = [])
    {
    	$this->register($url, 'preload', $args);
    }

    public function asynchronousFont(string $url, array $args = [], bool $nojs = true, bool $preload = true)
    {
        $url_info = parse_url($url);
        $this->preconnect($url_info['scheme'].'://'.$url_info['host'], $args);
        if ($preload) {
            $this->preload($url, $args + ['as' => 'style']);
        }
        $this->register($url, 'stylesheet', [
            'media' => 'print',
            'onload' => "this.onload=null;this.removeAttribute('media');"
        ]);
        if ($nojs) {
            $this->registered[] = '<noscript>'.$this->buildHtml($url, 'stylesheet', []).'</noscript>';
        }
    }

    public function onPrefetchHook()
    {
        foreach ($this->registered as $html) {
            echo $html;
        }
    }

    protected function register(string $url, string $type, array $args)
    {
        $this->registered[] = $this->buildHtml($url, $type, $args);
    }

    protected function buildHtml(string $url, string $type, array $args): string
    {
        $args['href'] = $url;
        if (!isset($args['rel'])) {
            $args['rel'] = $type;
        }
        $html = '';
        foreach ($args as $index => $arg) {
            if (is_numeric($index)) {
                $html .= $arg;
            } else {
                $html .= $index . '="' . $arg . '"';
            }
            $html .= ' ';
        }
        return "<link $html>\n";
    }
}
