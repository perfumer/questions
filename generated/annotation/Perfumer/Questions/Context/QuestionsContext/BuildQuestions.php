<?php

namespace Generated\Annotation\Perfumer\Questions\Context\QuestionsContext;

/**
 * @Annotation
 * @Target({"CLASS", "METHOD", "ANNOTATION"})
 */
class BuildQuestions extends \Perfumerlabs\Perfumer\ContractAnnotation\SharedClassCall
{
    /**
     * @var string
     */
    public $in_yaml_dir = null;

    /**
     * @var string
     */
    public $yaml_dir = null;

    /**
     * @var string
     */
    public $in_questions = null;

    /**
     * @var string
     */
    public $questions = null;

    /**
     * @var string
     */
    public $in_generator = null;

    /**
     * @var string
     */
    public $generator = null;

    /**
     * @var mixed
     */
    public $out = null;

    public function onCreate(): void
    {
        $this->_class = 'Perfumer\\Questions\\Context\\QuestionsContext';
        $this->_method = 'buildQuestions';
        $this->_return = $this->out;

        parent::onCreate();
    }

    public function onAnalyze(): void
    {
        $in_yaml_dir = $this->in_yaml_dir ?: $this->yaml_dir;

        if (!$in_yaml_dir) {
            $in_yaml_dir = 'yaml_dir';
        }

        $in_questions = $this->in_questions ?: $this->questions;

        if (!$in_questions) {
            $in_questions = 'questions';
        }

        $in_generator = $this->in_generator ?: $this->generator;

        if (!$in_generator) {
            $in_generator = 'generator';
        }

        $this->_arguments = [];

        if (is_string($in_yaml_dir)) {
            $this->_arguments[] = $in_yaml_dir;
        }

        if (is_string($in_questions)) {
            $this->_arguments[] = $in_questions;
        }

        if (is_string($in_generator)) {
            $this->_arguments[] = $in_generator;
        }

        parent::onAnalyze();
    }
}
