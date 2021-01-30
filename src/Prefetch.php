<?php

namespace Ryssbowh\CraftPrefetch;

use Craft;
use Ryssbowh\CraftPrefetch\variables\PrefetchVariable;
use craft\base\Plugin;
use craft\web\twig\variables\CraftVariable;
use yii\base\Event;

class Example extends Plugin
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

        // Register our variables
        Event::on(
            CraftVariable::class,
            CraftVariable::EVENT_INIT,
            function (Event $event) {
                $variable = $event->sender;
                $variable->set('prefetch', PrefetchVariable::class);
            }
        );
    }
}
