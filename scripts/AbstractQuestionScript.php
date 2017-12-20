<?php

namespace Opcoding\StarterKit\Tools;

use Opcoding\StarterKit\Tools\Helper\QuestionsHelper;

abstract class AbstractQuestionScript
{
    protected $questionHelper;

    /**
     * AbstractQuestionScript constructor.
     *
     * @param $questionHelper
     */
    public function __construct($questionHelper)
    {
        $this->questionHelper = $questionHelper;
    }

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
