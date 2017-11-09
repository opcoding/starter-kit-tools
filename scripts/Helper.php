<?php


namespace Opcoding\StarterKit\Tools;

/**
 * Class Helper
 *
 * @package Scripts
 */
class Helper
{

    const VENDOR_PATH = "vendor/opcoding/starter-kit-tools/";

    /**
     * @param $question
     * @param $validator
     * @param $io
     *
     * @return string
     */
    static public function createQuestion($question, $validator, $io)
    {
        $response = false;

        while (empty($response)) {
            $response = $io->askAndValidate($question, $validator);
        }

        return $response;
    }
}
