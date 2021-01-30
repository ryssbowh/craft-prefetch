<?php

namespace Ryssbowh\CraftPrefetch;

use Craft;
use Ryssbowh\CraftPrefetch\variables\PrefetchVariable;
use craft\base\Plugin;
use craft\web\twig\variables\CraftVariable;
use yii\base\Event;

class Prefetch extends Plugin
{
    /**
     * @var Example
     */
    public static $plugin;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        if (\Craft::$app->request->isSiteRequest) {
            Event::on(
                CraftVariable::class,
                CraftVariable::EVENT_INIT,
                function (Event $event) {
                    $variable = $event->sender;
                    $variable->set('prefetch', PrefetchVariable::class);
                }
            );

            \Craft::$app->view->hook('prefetch', [$this::$plugin->prefetch, 'onPrefetchHook']);
        }
    }
}
