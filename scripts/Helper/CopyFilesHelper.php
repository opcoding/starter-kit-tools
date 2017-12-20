<?php
namespace Opcoding\StarterKit\Tools\Helper;

use Exception;
use FilesystemIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

class CopyFilesHelper
{
    /** @var string */
    protected $sourceDirectory;

    /** @var string */
    protected $rootPathProject;

    /**
     * CopyFilesHelper constructor.
     *
     * @param $sourceDirectory
     * @param $rootPathProject
     */
    public function __construct($sourceDirectory, $rootPathProject)
    {
        $this->sourceDirectory = $sourceDirectory;
        $this->rootPathProject = $rootPathProject;
    }

    /**
     * Helper to copy file from Resources folder to project root
     * based on path in Resources
     *
     * @throws Exception
     */
    public function copyFiles()
    {
        $rep = realpath(__DIR__) . '/../Resources/' . $this->sourceDirectory;

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
     * @param $targetDirectory
     *
     * @throws Exception
     */
    private function createDirectories($targetDirectory)
    {
        $shouldExists = pathinfo($targetDirectory, PATHINFO_DIRNAME);
        if (!is_dir($shouldExists)) {
            try {
                mkdir($shouldExists, 0755, true);
            } catch (Exception $e) {
                throw new Exception(sprintf('Cannot create directory `%s` %s', $shouldExists, $e->getMessage()));
            }
        }
    }
}