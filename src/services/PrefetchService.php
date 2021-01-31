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
     */
    public function dnsPrefetch(string $url, array $args = [])
    {
    	$this->register($url, 'dns-prefetch', $args);
    }

    /**
     * Registers a preconnect
     * 
     * @param  string $url
     * @param  array  $args
     */
    public function preconnect(string $url, array $args = [])
    {
        $url_info = parse_url($url);
        if (\Craft::$app->request->hostName != $url_info['host']) {
            $args[] = 'crossorigin';
        }
    	$this->register($url, 'preconnect', $args);
    }

    /**
     * Registers a prefetch
     * 
     * @param  string $url
     * @param  array  $args
     */
    public function prefetch(string $url, array $args = [])
    {
    	$this->register($url, 'prefetch', $args);
    }

    /**
     * Registers a subresource
     * 
     * @param  string $url
     * @param  array  $args
     */
    public function subresource(string $url, array $args = [])
    {
		$this->register($url, 'subresource', $args);
    }

    /**
     * Registers a prerender
     * 
     * @param  string $url
     * @param  array  $args
     */
    public function prerender(string $url, array $args = [])
    {
    	$this->register($url, 'prerender', $args);
    }

    /**
     * Registers a preload
     * 
     * @param  string $url
     * @param  array  $args
     */
    public function preload(string $url, array $args = [])
    {
    	$this->register($url, 'preload', $args);
    }

    /**
     * Registers asynchronous font
     * 
     * @param  string       $url
     * @param  array        $args
     * @param  bool         $nojs     Add the nojs html
     * @param  bool         $preload  Preload the font
     */
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
     */
    public function register(string $url, string $type, array $args)
    {
        $this->registered[] = $this->buildHtml($url, $type, $args);
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
        return "<link $html>\n";
    }
}
