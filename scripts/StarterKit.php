<?php

namespace Opcoding\StarterKit\Tools;

use Composer\Composer;
use Composer\Factory;
use Composer\IO\IOInterface;
use Composer\Json\JsonFile;
use Composer\Script\Event;
use Exception;
use FilesystemIterator;
use Opcoding\StarterKit\Tools\Helper\QuestionsHelper;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

/**
 * Class StarterKit
 *
 * @package Opcoding\StarterKit\Tools
 */
class StarterKit
{
    const VENDOR_PATH = "vendor/opcoding/starter-kit-tools/";

    const KEY_QUESTION_DOCKER = 'docker';
    const KEY_QUESTION_COMPOSER = 'composer';
    const KEY_QUESTION_ASSETS = 'assets';

    /** @var string */
    protected $projectRoot;

    /** @var IOInterface */
    protected $io;

    /** @var Composer */
    protected $composer;

    /** @var JsonFile */
    protected $composerJson;

    /**
     * StarterKit constructor.
     *
     * @param IOInterface $io
     * @param Composer    $composer
     */
    public function __construct(IOInterface $io, Composer $composer)
    {
        $this->projectRoot = realpath(dirname(Factory::getComposerFile()));
        $this->io = $io;
        $this->composer = $composer;
        $this->composerJson = new JsonFile($this->projectRoot . '/composer.json');
    }

    /**
     * Function call by composer after post-create-project install
     *
     * @param Event $event
     *
     * @throws Exception
     */
    static public function init(Event $event)
    {
        $starterKit = new self($event->getIO(), $event->getComposer());

        $starterKit->setComposer($starterKit->io, $starterKit->composerJson);
        $starterKit->setPhpConfig();
        $starterKit->addAssets($starterKit->projectRoot, $starterKit->io);
        $starterKit->addDocker($starterKit->projectRoot, $starterKit->io);
        //end
        $starterKit->cleanComposerJson();
    }

    /**
     * @param IOInterface $io
     * @param JsonFile    $composerJson
     *
     * @throws Exception
     */
    private function setComposer(IOInterface $io, JsonFile $composerJson)
    {
        (new ComposerScript($io, $composerJson))
            ->setQuestionHelper(new QuestionsHelper(self::KEY_QUESTION_COMPOSER, $io))
            ->init();
    }

    /**
     * @throws Exception
     */
    private function setPhpConfig()
    {
        if (!file_exists(self::VENDOR_PATH . 'phing/properties/global.properties')) {
            throw new Exception("The file global.properties doesn't exists");
        }

        shell_exec("vendor/bin/phing -debug -f vendor/opcoding/starter-kit-tools/build.xml defaultFile");
    }

    /**
     * @param             $projectRoot
     * @param IOInterface $io
     *
     * @throws Exception
     */
    private function addAssets($projectRoot, IOInterface $io)
    {
        (new AssetsScript($projectRoot, $io))
            ->setQuestionHelper(new QuestionsHelper(self::KEY_QUESTION_ASSETS, $io))
            ->init();
    }

    /**
     * @param             $projectRoot
     * @param IOInterface $io
     *
     * @throws Exception
     */
    private function addDocker($projectRoot, IOInterface $io)
    {
        (new DockerScript($io, $projectRoot))
            ->setQuestionHelper(new QuestionsHelper(self::KEY_QUESTION_DOCKER, $io))
            ->init();
    }

    /**
     * Remove post-create-project-cmd
     *
     * @throws Exception
     */
    private function cleanComposerJson()
    {
        $data = $this->composerJson->read();

        if (isset($data['scripts']['post-create-project-cmd'])) {
            unset($data['scripts']['post-create-project-cmd']);
        }

        $this->composerJson->write($data);
    }
}
