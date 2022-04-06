<?php

namespace Ryssbowh\CraftPrefetch;

use Craft;
use Ryssbowh\CraftPrefetch\variables\PrefetchVariable;
use craft\base\Plugin;
use craft\web\View;
use craft\web\twig\variables\CraftVariable;
use yii\base\Event;

class Prefetch extends Plugin
{
    /**
     * @var Prefetch
     */
    public static $plugin;

    /**
     * @inheritdoc
     */
    public function init(): void
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
            Event::on(
                View::class,
                View::EVENT_BEGIN_BODY,
                function (Event $event) {
                    Prefetch::$plugin->prefetch->onBeginBody();
                }
            );
        }
    }
}
