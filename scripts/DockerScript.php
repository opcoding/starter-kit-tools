<?php

namespace Opcoding\StarterKit\Tools;

use Composer\Script\Event;

/**
 * Class DockerScript
 *
 * @package Scripts
 */
class DockerScript
{
    /**
     * @param Event $event
     *
     * @throws \Exception
     */
    static public function exec(Event $event)
    {
        /*$io = $event->getIO();


        $io->write("<comment>Start docker configuration</comment>");
        $containerName = Helper::createQuestion("Container name (example: Project which become project-api_db) : ", function($result) use ($io) {
            if (empty(trim($result))) {
                $io->writeError("<error>Please, enter your container name</error>");
                return false;
            }
            return $result;
        }, $io);

        // Apache part
        $apachePort = Helper::createQuestion("Apache port : ", function($result) use ($io) {
            if (!is_numeric($result) || is_float($result)) {
                $io->writeError("<error>The apache port must be an integer</error>");
                return false;
            }
            return $result;
        }, $io);

        // MySQL PART
        $io->write("<comment>MySQL configuration for Docker</comment>");
        $mysqlPort = Helper::createQuestion("MySQL port : ", function($result) use ($io) {
            if (!is_numeric($result) || is_float($result)) {
                $io->writeError("<error>The MySQL port must be an integer</error>");
                return false;
            }
            return $result;
        }, $io);
        $mysqlUser = $io->ask("MySQL username (default: root) : ", 'root');
        $mysqlPassword = $io->ask("MySQL password (default: toor) :  ", 'toor');
        $defaultDbName = strtolower(trim(str_replace(' ', '_', $containerName)));
        $mysqlDbName = $io->ask(sprintf("MySQL database name (default: %s) : ", $defaultDbName), $defaultDbName);

        $data = sprintf(
            'container.name=%s
             apache.port=%s
             mysql.port=%s
             mysql.user=%s
             mysql.password=%s
             mysql.db.name=%s',
            strtolower($containerName), $apachePort, $mysqlPort, $mysqlUser, $mysqlPassword, $mysqlDbName
        );

        file_put_contents(Helper::VENDOR_PATH . 'phing/properties/docker.properties', $data);
        shell_exec("vendor/bin/phing -debug -f vendor/opcoding/starter-kit-tools/build.xml docker");
        $io->write(sprintf('<info>Docker set successfully</info>'));
        */
    }
}
