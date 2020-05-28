<?php

namespace Generated\Annotation\Perfumer\Questions\Context\QuestionsContext;

/**
 * @Annotation
 * @Target({"CLASS", "METHOD", "ANNOTATION"})
 */
class BuildQuestion extends \Perfumerlabs\Perfumer\ContractAnnotation\SharedClassCall
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
    public $in_question = null;

    /**
     * @var string
     */
    public $question = null;

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
        $this->_method = 'buildQuestion';
        $this->_return = $this->out;

        parent::onCreate();
    }

    public function onAnalyze(): void
    {
        $in_yaml_dir = $this->in_yaml_dir ?: $this->yaml_dir;

        if (!$in_yaml_dir) {
            $in_yaml_dir = 'yaml_dir';
        }

        $in_question = $this->in_question ?: $this->question;

        if (!$in_question) {
            $in_question = 'question';
        }

        $in_generator = $this->in_generator ?: $this->generator;

        if (!$in_generator) {
            $in_generator = 'generator';
        }

        $this->_arguments = [];

        if (is_string($in_yaml_dir)) {
            $this->_arguments[] = $in_yaml_dir;
        }

        if (is_string($in_question)) {
            $this->_arguments[] = $in_question;
        }

        if (is_string($in_generator)) {
            $this->_arguments[] = $in_generator;
        }

        parent::onAnalyze();
    }
}
