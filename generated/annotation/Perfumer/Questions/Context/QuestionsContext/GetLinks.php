<?php

namespace Generated\Annotation\Perfumer\Questions\Context\QuestionsContext;

/**
 * @Annotation
 * @Target({"CLASS", "METHOD", "ANNOTATION"})
 */
class GetLinks extends \Perfumerlabs\Perfumer\ContractAnnotation\SharedClassCall
{
    /**
     * @var string
     */
    public $in_question_id = null;

    /**
     * @var string
     */
    public $question_id = null;

    /**
     * @var string
     */
    public $in_choices = null;

    /**
     * @var string
     */
    public $choices = null;

    /**
     * @var string
     */
    public $in_custom_answer = null;

    /**
     * @var string
     */
    public $custom_answer = null;

    /**
     * @var mixed
     */
    public $out = null;

    public function onCreate(): void
    {
        $this->_class = 'Perfumer\\Questions\\Context\\QuestionsContext';
        $this->_method = 'getLinks';
        $this->_return = $this->out;

        parent::onCreate();
    }

    public function onAnalyze(): void
    {
        $in_question_id = $this->in_question_id ?: $this->question_id;

        if (!$in_question_id) {
            $in_question_id = 'question_id';
        }

        $in_choices = $this->in_choices ?: $this->choices;

        if (!$in_choices) {
            $in_choices = 'choices';
        }

        $in_custom_answer = $this->in_custom_answer ?: $this->custom_answer;

        if (!$in_custom_answer) {
            $in_custom_answer = 'custom_answer';
        }

        $this->_arguments = [];

        if (is_string($in_question_id)) {
            $this->_arguments[] = $in_question_id;
        }

        if (is_string($in_choices)) {
            $this->_arguments[] = $in_choices;
        }

        if (is_string($in_custom_answer)) {
            $this->_arguments[] = $in_custom_answer;
        }

        parent::onAnalyze();
    }
}
