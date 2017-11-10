<?php

namespace Opcoding\StarterKit\Tools;

use Composer\Script\Event;

/**
 * Class InstallAssets
 *
 * @package Command
 */
class ComposerScript
{
    /**
     * @param Event $event
     *
     * @throws \Exception
     */
    public static function exec(Event $event)
    {
        $io = $event->getIO();

        $io->write(sprintf('<comment>Start configuration for composer.json information</comment>'));
        $composerProjectName = Helper::createQuestion("Project name (Example:  foo/bar) : ", function($result) use ($io){
            $res = strtolower($result);
            if (preg_match('/^[a-z0-9-]+\/[a-z0-9-]+$/', $res) === 1) {
                return $res;
            }
            $io->writeError("<error>The format must be foo/bar</error>");
            return false;
        }, $io);

        $composerProjectDescription = Helper::createQuestion("Project description : ", function($result) use ($io){
            $res = trim($result);
            if (!empty($res)) {
                return $res;
            }
            return false;
        }, $io);

        $projectName = Helper::createQuestion("Project name (application name) : ", function($result) use ($io){
            $res = trim($result);
            if (!empty($res)) {
                return $res;
            }
            return false;
        }, $io);

        $io->write(sprintf('<comment>Namespace format: My\\\Super\\\Namespace</comment>'));
        $namespace = Helper::createQuestion("Default namespace for autoload : ", function($result) use ($io){
            if (preg_match('/^((\w+)|(?:\w+\\\\{2}\w+)+)$/', $result) === 1) {
                return $result;
            }
            $io->writeError("<error>The namespace format must be My\\\\Namespace. Please try again</error>");
            return false;
        }, $io);

        $data = sprintf(
            'namespace.project=%s
             namespace.class.escape=%s
             project.name=%s
             composer.project.name=%s
             composer.project.description=%s
            ', $namespace, str_replace("\\\\", '\\', $namespace), $projectName, $composerProjectName, $composerProjectDescription);
        file_put_contents(Helper::VENDOR_PATH . 'phing/properties/global.properties', $data);

        shell_exec("vendor/bin/phing -debug -f vendor/opcoding/starter-kit-tools/build.xml main");
        $io->write(sprintf('<info>Default namespace successfully set</info>'));
    }
}
