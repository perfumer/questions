<?php

namespace Generated\Annotation\Perfumer\Questions\Context\QuestionsContext;

/**
 * @Annotation
 * @Target({"CLASS", "METHOD", "ANNOTATION"})
 */
class ExportToPhpFile extends \Perfumerlabs\Perfumer\ContractAnnotation\SharedClassCall
{
    /**
     * @var string
     */
    public $in_php_dir = null;

    /**
     * @var string
     */
    public $php_dir = null;

    /**
     * @var string
     */
    public $in_filename = null;

    /**
     * @var string
     */
    public $filename = null;

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
    public $in_links = null;

    /**
     * @var string
     */
    public $links = null;

    /**
     * @var mixed
     */
    public $out = null;

    public function onCreate(): void
    {
        $this->_class = 'Perfumer\\Questions\\Context\\QuestionsContext';
        $this->_method = 'exportToPhpFile';
        $this->_return = $this->out;

        parent::onCreate();
    }

    public function onAnalyze(): void
    {
        $in_php_dir = $this->in_php_dir ?: $this->php_dir;

        if (!$in_php_dir) {
            $in_php_dir = 'php_dir';
        }

        $in_filename = $this->in_filename ?: $this->filename;

        if (!$in_filename) {
            $in_filename = 'filename';
        }

        $in_questions = $this->in_questions ?: $this->questions;

        if (!$in_questions) {
            $in_questions = 'questions';
        }

        $in_links = $this->in_links ?: $this->links;

        if (!$in_links) {
            $in_links = 'links';
        }

        $this->_arguments = [];

        if (is_string($in_php_dir)) {
            $this->_arguments[] = $in_php_dir;
        }

        if (is_string($in_filename)) {
            $this->_arguments[] = $in_filename;
        }

        if (is_string($in_questions)) {
            $this->_arguments[] = $in_questions;
        }

        if (is_string($in_links)) {
            $this->_arguments[] = $in_links;
        }

        parent::onAnalyze();
    }
}
