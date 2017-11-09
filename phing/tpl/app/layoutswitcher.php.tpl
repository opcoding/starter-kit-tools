<?php

namespace %%namespace.class.escape%%\Middleware;

use ObjectivePHP\Application\AbstractApplication;
use ObjectivePHP\Application\ApplicationInterface;
use ObjectivePHP\Application\Middleware\AbstractMiddleware;

/**
 * Class LayoutSwitcher
 *
 * @package %%namespace.class.escape%%\Middleware
 */
class LayoutSwitcher extends AbstractMiddleware
{
    /**
     * @param ApplicationInterface $app
     */
    public function run(ApplicationInterface $app)
    {
        /** @var AbstractApplication $app */
        $app->setParam('layout.name', 'layout');
    }
}
