<?php


namespace Opcoding\StarterKit\Tools;


use Composer\IO\IOInterface;
use FilesystemIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

class AssetsScript
{
    /** @var string */
    protected $rootPathProject;

    /** @var IOInterface */
    protected $io;

    /**
     * AssetsScript constructor.
     *
     * @param string      $rootPathProject
     * @param IOInterface $io
     */
    public function __construct($rootPathProject, IOInterface $io)
    {
        $this->rootPathProject = $rootPathProject;
        $this->io = $io;
    }

    private function askQuestion()
    {
        $response = StarterKit::createQuestion("Which bootstrap would you want ? (mdb / bt) : ",
            function($result){
                return ($result == "mdb") ? "bootstrap-mdb" : "bootstrap";
            }, $this->io);

        return $response;
    }

    public function copyFiles()
    {
        $rep = realpath(__DIR__) . '/Resources/' . $this->askQuestion();

        $rdi = new RecursiveDirectoryIterator($rep, FilesystemIterator::SKIP_DOTS);
        $rii = new RecursiveIteratorIterator($rdi);
        /**
         * @var  $key
         * @var SplFileInfo $item
         */
        foreach ($rii as $key => $item) {
            $fullDest = $this->rootPathProject . str_replace($rep, '', $item->getPathname());
            $this->createDirectories($fullDest);
            copy($item->getPathname(), $fullDest);
        }
    }

    /**
     * @param $dest
     *
     * @throws \Exception
     */
    private function createDirectories($dest)
    {
        $shouldExists = pathinfo($dest, PATHINFO_DIRNAME);
        if (!is_dir($shouldExists)) {
            try {
                mkdir($shouldExists, 0755, true);
            } catch (\ErrorException $e) {
                throw new \Exception(sprintf('Cannot create directory `%s` %s', $shouldExists, $e->getMessage()));
            }
        }
    }
}