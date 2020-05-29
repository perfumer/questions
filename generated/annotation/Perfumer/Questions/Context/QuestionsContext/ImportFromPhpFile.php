<?php

namespace Generated\Annotation\Perfumer\Questions\Context\QuestionsContext;

/**
 * @Annotation
 * @Target({"CLASS", "METHOD", "ANNOTATION"})
 */
class ImportFromPhpFile extends \Perfumerlabs\Perfumer\ContractAnnotation\SharedClassCall
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
     * @var mixed
     */
    public $out = null;

    public function onCreate(): void
    {
        $this->_class = 'Perfumer\\Questions\\Context\\QuestionsContext';
        $this->_method = 'importFromPhpFile';
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

        $this->_arguments = [];

        if (is_string($in_php_dir)) {
            $this->_arguments[] = $in_php_dir;
        }

        if (is_string($in_filename)) {
            $this->_arguments[] = $in_filename;
        }

        parent::onAnalyze();
    }
}
