<?php

namespace Opcoding\StarterKit\Tools;

use Composer\IO\IOInterface;
use Composer\Json\JsonFile;

/**
 * Class InstallAssets
 *
 * @package Command
 */
class ComposerScript extends AbstractQuestionScript
{

    /** @var IOInterface io */
    protected $io;

    /** @var JsonFile */
    protected $jsonFile;

    /**
     * ComposerScript constructor.
     *
     * @param IOInterface     $io
     * @param JsonFile        $jsonFile
     */
    public function __construct(IOInterface $io, JsonFile $jsonFile)
    {
        $this->io = $io;
        $this->jsonFile = $jsonFile;
    }

    /**
     * @throws \Exception
     */
    public function init()
    {
        $this->updateComposerJson();
    }

    /**
     * Update composer.json
     *
     * @throws \Exception
     */
    private function updateComposerJson()
    {
        /** @var array $composerJsonData */
        $composerJsonData = $this->jsonFile->read();
        $newData = $this->getDataForComposer();
        $this->setGlobalPropertiesFile($newData['property-file']);

        unset($newData['property-file']);

        $this->jsonFile->write(array_merge($composerJsonData, $newData));
    }

    /**
     * @return array
     */
    private function getDataForComposer()
    {
        $io = $this->io;

        $io->write(sprintf('<comment>[Start configuration composer.json (project name, description, namespace psr-4)]</comment>'));

        $validateName = function($result) use ($io){
            $res = strtolower($result);
            if (preg_match('/^[a-z0-9-]+\/[a-z0-9-]+$/', $res) === 1) {
                return $res;
            }
            $io->writeError("<error>The format must be foo/bar</error>");
            return false;
        };
        $name = $this->getQuestionHelper()
            ->askQuestion(1, $validateName);

        $validateDescription = function($result) use ($io){
            $res = trim($result);
            return (!empty($res)) ? $res : false;
        };
        $description = $this->getQuestionHelper()
            ->askQuestion(2, $validateDescription);

        $validateNamespace = function($result) use ($io){
            if (preg_match('/^((\w+)|(?:\w+\\\\{2}\w+)+)$/', $result) === 1) {
                return $result;
            }
            $io->writeError("<error>The namespace format must be My\\\\Namespace. Please try again</error>");
            return false;
        };
        $namespace = $this->getQuestionHelper()
            ->askQuestion(3,$validateNamespace);

        return [
            'name' => $name,
            'description' => $description,
            'autoload' => [
                'psr-4' => [
                    str_replace('\\\\','\\', $namespace) . '\\' => 'app/src'
                ]
            ],
            'property-file' => [
                'namespace' => $namespace
            ]
        ];
    }

    /**
     * @param array $data
     */
    private function setGlobalPropertiesFile($data)
    {
        $io = $this->io;

        $validateProjectName = function($result) use ($io){
            $res = trim($result);
            return (!empty($res)) ? $res : false;
        };

        $projectName = $this->getQuestionHelper()->askQuestion(4, $validateProjectName);
        $namespace = $data['namespace'];

        $data = sprintf(
            'namespace.project=%s
             namespace.class.escape=%s
             project.name=%s
            ', $namespace, str_replace("\\\\", '\\', $namespace), $projectName);

        file_put_contents(StarterKit::VENDOR_PATH . 'phing/properties/global.properties', $data);
    }
}
