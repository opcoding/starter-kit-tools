<?php

namespace Opcoding\StarterKit\Tools;

use Composer\Script\Event;

/**
 * Class DefaultFileScript
 *
 * @package Scripts
 */
class DefaultFileScript
{
    /**
     * @param Event $event
     *
     * @throws \Exception
     */
    public static function exec(Event $event)
    {

        if (!file_exists(Helper::VENDOR_PATH . 'phing/properties/global.properties')) {
            throw new \Exception("The file global.properties doesn't exists");
        }

        $io = $event->getIO();

        shell_exec("vendor/bin/phing -debug -f vendor/opcoding/starter-kit-tools/build.xml defaultFile");
        $io->write(sprintf('<info>Namespaces updated</info>'));
    }
}
