<?php

namespace Ryssbowh\CraftPrefetch\services;

use craft\base\Component;
use craft\web\View;

class PrefetchService extends Component
{
    /**
     * @var array
     */
    protected $registered = [];

    /**
     * Registers a dns prefetch
     * 
     * @param  string $url
     * @param  array  $args
     * @return PrefetchService
     */
    public function dnsPrefetch(string $url, array $args = []): PrefetchService
    {
    	$this->register($url, 'dns-prefetch', $args);
        return $this;
    }

    /**
     * Registers a preconnect
     * 
     * @param  string $url
     * @param  array  $args
     * @return PrefetchService
     */
    public function preconnect(string $url, array $args = []): PrefetchService
    {
        $url_info = parse_url($url);
        if (\Craft::$app->request->hostName != $url_info['host']) {
            $args[] = 'crossorigin';
        }
    	$this->register($url, 'preconnect', $args);
        return $this;
    }

    /**
     * Registers a prefetch
     * 
     * @param  string $url
     * @param  array  $args
     * @return PrefetchService
     */
    public function prefetch(string $url, array $args = []): PrefetchService
    {
    	$this->register($url, 'prefetch', $args);
        return $this;
    }

    /**
     * Registers a subresource
     * 
     * @param  string $url
     * @param  array  $args
     * @return PrefetchService
     */
    public function subresource(string $url, array $args = []): PrefetchService
    {
		$this->register($url, 'subresource', $args);
        return $this;
    }

    /**
     * Registers a prerender
     * 
     * @param  string $url
     * @param  array  $args
     * @return PrefetchService
     */
    public function prerender(string $url, array $args = []): PrefetchService
    {
    	$this->register($url, 'prerender', $args);
        return $this;
    }

    /**
     * Registers a preload
     * 
     * @param  string $url
     * @param  array  $args
     * @return PrefetchService
     */
    public function preload(string $url, array $args = []): PrefetchService
    {
    	$this->register($url, 'preload', $args);
        return $this;
    }

    /**
     * Registers asynchronous font
     * 
     * @param  string       $url
     * @param  array        $args
     * @param  bool         $nojs     Add the nojs html
     * @param  bool         $preload  Preload the font
     * @return PrefetchService
     */
    public function asynchronousFont(string $url, array $args = [], bool $nojs = true, bool $preload = true): PrefetchService
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
        return $this;
    }

    /**
     * Hook callback, prints out the html
     */
    public function onPrefetchHook()
    {
        foreach ($this->registered as $html) {
            echo $html;
        }
    }

    /**
     * Registers a link tag
     * 
     * @param  string $url
     * @param  string $type
     * @param  array  $args
     * @return PrefetchService
     */
    public function register(string $url, string $type, array $args): PrefetchService
    {
        $html = $this->buildHtml($url, $type, $args);
        if (!in_array($html, $this->registered)) {
            $this->registered[] = $html;
        }
        return $this;
    }

    /**
     * Builds a link tag html
     * 
     * @param  string $url
     * @param  string $type
     * @param  array  $args
     * @return string
     */
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
        return "<link $html/>\n";
    }
}
