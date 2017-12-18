<?php

namespace Opcoding\StarterKit\Tools;

use Composer\IO\IOInterface;
use Composer\Json\JsonFile;

/**
 * Class InstallAssets
 *
 * @package Command
 */
class ComposerScript
{

    /** @var IOInterface io */
    protected $io;

    /** @var JsonFile */
    protected $jsonFile;

    /**
     * ComposerScript constructor.
     */
    public function __construct(IOInterface $io, JsonFile $jsonFile)
    {
        $this->io = $io;
        $this->jsonFile = $jsonFile;
    }

    /**
     * @return array
     */
    private function getDataForComposer()
    {
        $io = $this->io;

        $io->write(sprintf('<comment>Set composer.json information (project name, description, namespace psr-4)</comment>'));
        $name = StarterKit::createQuestion("Project name (Example: foo/bar) : ", function($result) use ($io){
            $res = strtolower($result);
            if (preg_match('/^[a-z0-9-]+\/[a-z0-9-]+$/', $res) === 1) {
                return $res;
            }
            $io->writeError("<error>The format must be foo/bar</error>");
            return false;
        }, $io);

        $description = StarterKit::createQuestion("Project description : ", function($result) use ($io){
            $res = trim($result);
            if (!empty($res)) {
                return $res;
            }
            return false;
        }, $io);

        $io->write(sprintf('<comment>Namespace format: My\\\Super\\\Namespace</comment>'));
        $namespace = StarterKit::createQuestion("Default namespace for autoload : ", function($result) use ($io){
            if (preg_match('/^((\w+)|(?:\w+\\\\{2}\w+)+)$/', $result) === 1) {
                return $result;
            }
            $io->writeError("<error>The namespace format must be My\\\\Namespace. Please try again</error>");
            return false;
        }, $io);

        return [
            'name' => $name,
            'description' => $description,
            'autoload' => [
                'psr-4' => [
                    $namespace => 'app/src'
                ]
            ],
            'property-file' => [
                'namespace' => $namespace
            ]
        ];
    }

    private function setGlobalPropertiesFile($data)
    {
        $io = $this->io;

        $projectName = StarterKit::createQuestion("Project name (application name) : ", function($result) use ($io){
            $res = trim($result);
            if (!empty($res)) {
                return $res;
            }
            return false;
        }, $io);

        $namespace = $data['property-file']['namespace'];

        $data = sprintf(
            'namespace.project=%s
             namespace.class.escape=%s
             project.name=%s
            ', $namespace, str_replace("\\\\", '\\', $namespace), $projectName);
        file_put_contents(StarterKit::VENDOR_PATH . 'phing/properties/global.properties', $data);
    }

    /**
     * Update composer.json
     */
    public function updateComposerJson()
    {
        /** @var array $composerJsonData */
        $composerJsonData = $this->jsonFile->read();
        $newData = $this->getDataForComposer();

        $this->setGlobalPropertiesFile($newData['property-file']);
        unset($newData['property-file']);

        array_merge($composerJsonData, $newData);

        $this->jsonFile->write(array_merge($composerJsonData, $newData));
    }
}
