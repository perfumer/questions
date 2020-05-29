<?php

namespace Generated\Annotation\Perfumer\Questions\Context\QuestionsContext;

/**
 * @Annotation
 * @Target({"CLASS", "METHOD", "ANNOTATION"})
 */
class GetOrderedQuestions extends \Perfumerlabs\Perfumer\ContractAnnotation\SharedClassCall
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
    public $in_links = null;

    /**
     * @var string
     */
    public $links = null;

    /**
     * @var string
     */
    public $in_chain = null;

    /**
     * @var string
     */
    public $chain = null;

    /**
     * @var mixed
     */
    public $out = null;

    public function onCreate(): void
    {
        $this->_class = 'Perfumer\\Questions\\Context\\QuestionsContext';
        $this->_method = 'getOrderedQuestions';
        $this->_return = $this->out;

        parent::onCreate();
    }

    public function onAnalyze(): void
    {
        $in_reference = $this->in_reference ?: $this->reference;

        if (!$in_reference) {
            $in_reference = 'reference';
        }

        $in_links = $this->in_links ?: $this->links;

        if (!$in_links) {
            $in_links = 'links';
        }

        $in_chain = $this->in_chain ?: $this->chain;

        if (!$in_chain) {
            $in_chain = 'chain';
        }

        $this->_arguments = [];

        if (is_string($in_reference)) {
            $this->_arguments[] = $in_reference;
        }

        if (is_string($in_links)) {
            $this->_arguments[] = $in_links;
        }

        if (is_string($in_chain)) {
            $this->_arguments[] = $in_chain;
        }

        parent::onAnalyze();
    }
}
