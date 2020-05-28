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

        $in_array = $this->in_array ?: $this->array;

        if (!$in_array) {
            $in_array = 'array';
        }

        $this->_arguments = [];

        if (is_string($in_php_dir)) {
            $this->_arguments[] = $in_php_dir;
        }

        if (is_string($in_filename)) {
            $this->_arguments[] = $in_filename;
        }

        if (is_string($in_array)) {
            $this->_arguments[] = $in_array;
        }

        parent::onAnalyze();
    }
}
