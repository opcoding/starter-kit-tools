<?php

namespace Opcoding\StarterKit\Tools\Helper;

/**
 * Trait QuestionHelperAwareTrait
 *
 * @package Opcoding\StarterKit\Tools\Helper
 */
trait QuestionHelperAwareTrait
{
    /**
     * @var QuestionsHelper
     */
    protected $questionHelper;

    /**
     * Get QuestionHelper
     *
     * @return QuestionsHelper
     */
    public function getQuestionHelper()
    {
        return $this->questionHelper;
    }

    /**
     * Set QuestionHelper
     *
     * @param mixed $questionHelper
     *
     * @return $this
     */
    public function setQuestionHelper($questionHelper)
    {
        $this->questionHelper = $questionHelper;
        return $this;
    }
}
