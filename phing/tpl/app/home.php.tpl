<?php

namespace %%namespace.class.escape%%\Action;

use ObjectivePHP\Application\Action\RenderableAction;
use ObjectivePHP\Application\ApplicationInterface;
use ObjectivePHP\Application\View\Helper\Vars;

/**
 * Class Home
 *
 * @package %%namespace.class.escape%%\Action
 */
class Home extends RenderableAction
{
    /**
     * @inheritdoc
     */
    public function run(ApplicationInterface $app)
    {
        Vars::set('page.title', 'Objective PHP Project Template');
    }
}
