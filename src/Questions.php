<?php

namespace Perfumer\Questions;

use Perfumer\Questions\Context\QuestionsContext;

class Questions extends \Generated\Perfumer\Questions\Questions
{
    private $yaml_files = [];

    private $php_dir;

    private $yaml_dir;

    public function setYmlDir(string $yaml_dir): void
    {
        $this->yaml_dir = rtrim($yaml_dir, '/') . '/';
    }

    public function setPhpDir(string $php_dir): void
    {
        $this->php_dir = rtrim($php_dir, '/') . '/';
    }

    public function addYamlFile(string $yaml_file): void
    {
        $this->yaml_files[] = $yaml_file;
    }

    public function importFromYamlFilesToPhpFiles(array $yaml_files = []): void
    {
        $context = new QuestionsContext();
        $files = $yaml_files ?: $this->yaml_files;

        foreach ($files as $file) {
            $questions = $this->importFromYamlFile($file);

            $context->exportToPhpFile($this->php_dir, $file, $questions);
        }
    }

    public function importFromYamlFile(string $file): array
    {
        $context = new QuestionsContext();
        $id_generator = new IdGenerator();
        $id_generator->generateInitialIndex();

        return $context->buildQuestionsFromYamlFile($this->yaml_dir, $file, $id_generator);
    }
}
