<?php
namespace Opcoding\StarterKit\Tools\Helper;

use Composer\IO\IOInterface;

class QuestionsHelper
{
    /** @var string */
    private $questionKey;

    /** @var array */
    private $questions;

    /** @var IOInterface */
    private $io;

    /**
     * QuestionsHelper constructor.
     *
     * @param $questionKey
     */
    public function __construct($questionKey, IOInterface $io)
    {
        $this->questionKey = $questionKey;
        $this->questions = require __DIR__ . '/../questions.php';
        $this->io = $io;
    }

    /**
     * @param $key
     * @param $validator
     *
     * @return bool|string
     */
    public function askQuestion($key, $validator)
    {
        $data = $this->getQuestions($this->questionKey);

        $obj = $data[$key];

        $question =  $obj['question'] ?? null;
        $default = $obj['default'] ?? null;
        $example = $obj['example'] ?? null;
        $choices = $obj['choices'] ?? null;

        $ask = [
            sprintf("<question>%s</question>\n", $question)
        ];

        if (!empty($example)) {
            $ask[] = sprintf("Example : %s\n", $example);
        }

        if (!empty($choices)) {
            foreach ($choices as $key => $value) {
                $ask[] = sprintf("[<comment>%s</comment>] %s\n", $key, $value);
            }
        }

        if (!empty($default)) {
            $ask[] = sprintf("Default value (<comment>%s</comment>) : ", $default);
        }

        return self::createQuestion($ask, $validator, $default);
    }

    /**
     * Helper to create a question easily with validation
     *
     * @param             $question
     * @param             $validator
     * @param null        $default The default answer if none is given by the user
     * @param null        $attempts Max number of times to ask before giving up (default of null means infinite)
     *
     * @return bool|string
     */
    private function createQuestion($question, $validator, $default = null, $attempts = null)
    {
        $response = false;
        while (empty($response)) {
            $response = $this->io->askAndValidate($question, $validator, $attempts, $default);
        }
        return $response;
    }

    /**
     * @return array
     */
    private function getQuestions($key)
    {
        return $this->questions[$key];
    }
}
