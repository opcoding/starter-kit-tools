<?php
namespace Opcoding\StarterKit\Tools;

use Composer\IO\IOInterface;
use Opcoding\StarterKit\Tools\Helper\CopyFilesHelper;
use Opcoding\StarterKit\Tools\Helper\QuestionHelperAwareTrait;

class AssetsScript
{
    use QuestionHelperAwareTrait;

    /** @var string */
    protected $rootPathProject;

    /** @var IOInterface */
    protected $io;

    /**
     * AssetsScript constructor.
     *
     * @param                 $rootPathProject
     * @param IOInterface     $io
     */
    public function __construct($rootPathProject, IOInterface $io)
    {
        $this->rootPathProject = $rootPathProject;
        $this->io = $io;
    }

    /**
     * @return string
     */
    private function askAssetsYouWant()
    {
        $this->io->write(sprintf('<comment>[Start assets configuration]</comment>'));
        return $this->getQuestionHelper()->askQuestion(1, function($result){
            return ($result == "mdb") ? "bootstrap-mdb" : "bootstrap";
        });
    }

    /**
     * @throws \Exception
     */
    public function init()
    {
        (new CopyFilesHelper($this->askAssetsYouWant(), $this->rootPathProject))
            ->copyFiles();
    }
}
