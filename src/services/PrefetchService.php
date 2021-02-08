<?php

namespace Ryssbowh\CraftPrefetch\services;

use craft\base\Component;
use craft\web\View;
use yii\helpers\BaseHtml;

class PrefetchService extends Component
{
    /**
     * No script tags to be printed after the body tag
     * @var array
     */
    protected $noscripts = [];

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
            $args['crossorigin'] = true;
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
     * @see https://pagespeedchecklist.com/asynchronous-google-fonts
     */
    public function asynchronousFont(string $url, array $args = [], bool $nojs = true, bool $preload = true): PrefetchService
    {
        $url_info = parse_url($url);
        $this->preconnect($url_info['scheme'].'://'.$url_info['host'], $args);
        if ($preload) {
            $this->preload($url, ['href' => $url, 'as' => 'style']);
        }
        $this->register($url, 'stylesheet', [
            'media' => 'print',
            'onload' => "this.onload=null;this.removeAttribute('media');"
        ]);
        if ($nojs) {
            $this->noscript([
                'rel' => 'stylesheet',
                'href' => $url
            ]);
        }
        return $this;
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
        $args['href'] = $url;
        $args['rel'] = $type;
        \Craft::$app->view->registerLinkTag($args, $this->buildKey($args));
        return $this;
    }

    /**
     * On begin body callback, prints the registered noscript tags
     */
    public function onBeginBody()
    {
        echo implode("\n", $this->noscripts);
    }

    /**
     * Registers a noscript tag
     * 
     * @param  array  $args
     */
    protected function noscript(array $args)
    {
        $link = BaseHtml::tag('link', '', $args);
        $this->noscripts[$link] = BaseHtml::tag('noscript', $link);
    }

    /**
     * Builds a unique key
     * 
     * @param  array  $args
     * @return string
     */
    protected function buildKey(array $args): string
    {
        $key = '';
        foreach ($args as $index => $arg) {
            if (is_numeric($index)) {
                $key .= $arg;
            } else {
                $key .= $index . $arg;
            }
        }
        return $key;
    }
}
