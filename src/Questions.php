<?php

namespace Perfumer\Questions;

use Perfumer\Questions\Context\QuestionsContext;
use Perfumer\Questions\Helper\Arr;

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
            $array = $context->convertQuestions($questions);

            $context->exportToPhpFile($this->php_dir, $file, $array['questions'], $array['links']);
        }
    }

    public function importFromYamlFile(string $file): array
    {
        $context = new QuestionsContext();
        $id_generator = new IdGenerator();
        $id_generator->generateInitialIndex();

        return $context->buildQuestionsFromYamlFile($this->yaml_dir, $file, $id_generator);
    }

    public function getNextQuestion(string $file, ?int $question_id, array $answer = [], array $chain = []): NextQuestion
    {
        $context = new QuestionsContext();
        $response = new NextQuestion();

        $reference = $context->importFromPhpFile($this->php_dir, $file);

        if (!$reference || !is_array($reference['questions']) || !isset($reference['questions'])) {
            return $response;
        }

        if (!is_int($question_id) || $question_id <= 0) {
            $response->question = reset($reference['questions']);

            return $response;
        }

        $choices = $answer['choices'] ?? [];
        $custom = $answer['custom'] ?? false;

        $links = $context->getLinks($question_id, $choices, $custom);

        $ordered_questions = $context->getOrderedQuestions($reference, $links, $chain);

        if (!$ordered_questions) {
            return $response;
        }

        $next_question = $reference['questions'][$ordered_questions[0]];

        if (isset($next_question['answers']) && is_array($next_question['answers'])) {
            foreach ($next_question['answers'] as $i => $next_question_answer) {
                if (!isset($next_question_answer['text'])) {
                    unset($next_question['answers'][$i]);
                }
            }
        }

        $response->question = $next_question;
        $response->chain = array_slice($ordered_questions, 1);

        return $response;
    }

    public function getQuestionsById(string $file, array $ids): array
    {
        $context = new QuestionsContext();

        $reference = $context->importFromPhpFile($this->php_dir, $file);

        if (!$reference || !is_array($reference['questions']) || !isset($reference['questions'])) {
            return [];
        }

        return Arr::fetch($reference['questions'], $ids);
    }
}
