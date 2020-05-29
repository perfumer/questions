<?php

namespace Generated\Annotation\Perfumer\Questions\Context\QuestionsContext;

/**
 * @Annotation
 * @Target({"CLASS", "METHOD", "ANNOTATION"})
 */
class GetNextQuestion extends \Perfumerlabs\Perfumer\ContractAnnotation\SharedClassCall
{
    /**
     * @var string
     */
    public $in_reference = null;

    /**
     * @var string
     */
    public $reference = null;

    /**
     * @var string
     */
    public $in_questions = null;

    /**
     * @var string
     */
    public $questions = null;

    /**
     * @var mixed
     */
    public $out = null;

    public function onCreate(): void
    {
        $this->_class = 'Perfumer\\Questions\\Context\\QuestionsContext';
        $this->_method = 'getNextQuestion';
        $this->_return = $this->out;

        parent::onCreate();
    }

    public function onAnalyze(): void
    {
        $in_reference = $this->in_reference ?: $this->reference;

        if (!$in_reference) {
            $in_reference = 'reference';
        }

        $in_questions = $this->in_questions ?: $this->questions;

        if (!$in_questions) {
            $in_questions = 'questions';
        }

        $this->_arguments = [];

        if (is_string($in_reference)) {
            $this->_arguments[] = $in_reference;
        }

        if (is_string($in_questions)) {
            $this->_arguments[] = $in_questions;
        }

        parent::onAnalyze();
    }
}
