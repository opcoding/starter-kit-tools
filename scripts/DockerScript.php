<?php

namespace Opcoding\StarterKit\Tools;

use Composer\IO\IOInterface;
use Opcoding\StarterKit\Tools\Helper\CopyFilesHelper;
use Opcoding\StarterKit\Tools\Helper\QuestionHelperAwareTrait;

/**
 * Class DockerScript
 *
 * @package Scripts
 */
class DockerScript
{
    use QuestionHelperAwareTrait;

    /** @var IOInterface */
    protected $io;

    /** @var string */
    protected $rootPathProject;

    /**
     * DockerScript constructor.
     *
     * @param IOInterface $io
     * @param             $rootPathProject
     */
    public function __construct(IOInterface $io, $rootPathProject)
    {
        $this->io = $io;
        $this->rootPathProject = $rootPathProject;
    }

    /**
     * @throws \Exception
     */
    public function init()
    {
        if ($this->wantDocker()) {
            $this->setDockerParameters();
            $this->copyFiles();
        }
    }

    /**
     * If true, starts setting docker
     *
     * @return bool
     */
    private function wantDocker()
    {
        $io = $this->io;

        $validate = function($result) use ($io) {
            if (empty(trim($result)) || (!in_array($result, ['y', 'n']))) {
                $io->writeError("<error>Possible choice 'y' or 'n'</error>");
                return false;
            }
            return $result;
        };

        $wantDocker = $this->getQuestionHelper()->askQuestion(1, $validate);

        return $wantDocker == 'y' ? true : false;
    }

    /**
     * Sets the parameters for docker compose
     */
    private function setDockerParameters()
    {
        $io = $this->io;

        $this->io->write(sprintf('<comment>[Start docker configuration]</comment>'));

        $validateContainerName = function($result) use ($io) {
            if (empty(trim($result))) {
                $io->writeError("<error>Please, enter your container name</error>");
                return false;
            }
            return $result;
        };
        $containerName = $this->getQuestionHelper()->askQuestion(2, $validateContainerName);

        $validateApachePort = function($result) use ($io) {
            if (!is_numeric($result) || is_float($result)) {
                $io->writeError("<error>The apache port must be an integer</error>");
                return false;
            }
            return $result;
        };
        $apachePort = $this->getQuestionHelper()->askQuestion(3, $validateApachePort);

        $data = sprintf(
            'container.name=%s
             apache.port=%s',
            strtolower($containerName), $apachePort
        );

        file_put_contents(StarterKit::VENDOR_PATH . 'phing/properties/docker.properties', $data);
        shell_exec("vendor/bin/phing -debug -f vendor/opcoding/starter-kit-tools/build.xml docker");
    }

    /**
     * copy files from Resources/docker to project root
     *
     * @throws \Exception
     */
    private function copyFiles()
    {
        (new CopyFilesHelper('docker', $this->rootPathProject))->copyFiles();
    }
}
