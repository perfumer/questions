<?php

namespace Generated\Annotation\Perfumer\Questions\Context\QuestionsContext;

/**
 * @Annotation
 * @Target({"CLASS", "METHOD", "ANNOTATION"})
 */
class BuildQuestionLinks extends \Perfumerlabs\Perfumer\ContractAnnotation\SharedClassCall
{
    /**
     * @var string
     */
    public $in_array = null;

    /**
     * @var string
     */
    public $array = null;

    /**
     * @var mixed
     */
    public $out = null;

    public function onCreate(): void
    {
        $this->_class = 'Perfumer\\Questions\\Context\\QuestionsContext';
        $this->_method = 'buildQuestionLinks';
        $this->_return = $this->out;

        parent::onCreate();
    }

    public function onAnalyze(): void
    {
        $in_array = $this->in_array ?: $this->array;

        if (!$in_array) {
            $in_array = 'array';
        }

        $this->_arguments = [];

        if (is_string($in_array)) {
            $this->_arguments[] = $in_array;
        }

        parent::onAnalyze();
    }
}
