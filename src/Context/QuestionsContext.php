<?php

namespace Perfumer\Questions\Context;

use Perfumer\Questions\Helper\Arr;
use Perfumer\Questions\IdGenerator;
use Perfumerlabs\Perfumer\ContextAnnotation\Test;
use Symfony\Component\Yaml\Yaml;

class QuestionsContext
{
    public function parseYamlFile(string $yaml_dir, string $file): array
    {
        return Yaml::parse(file_get_contents($yaml_dir. $file . '.yml'), Yaml::PARSE_CUSTOM_TAGS);
    }

    public function exportToPhpFile(string $php_dir, string $filename, array $questions, array $links): void
    {
        $content = [
            'questions' => $questions,
            'links' => $links,
        ];

        $content = var_export($content, true);

        $content = '<?php' . PHP_EOL . PHP_EOL . 'return '. $content . ';';

        file_put_contents($php_dir . $filename . '.php', $content);
    }

    public function importFromPhpFile(string $php_dir, string $filename): ?array
    {
        $array = null;
        $php_file = $php_dir . $filename . '.php';

        if (is_file($php_file)) {
            $array = require $php_file;
        }

        return $array;
    }

    public function buildQuestionsFromYamlFile(string $yaml_dir, string $file, IdGenerator $generator): array
    {
        $questions = $this->parseYamlFile($yaml_dir, $file);

        return $this->buildQuestions($yaml_dir, $questions, $generator);
    }

    public function buildQuestions(string $yaml_dir, array $questions, IdGenerator $generator): array
    {
        $array = [];

        foreach ($questions as $question) {
            if (isset($question['include'])) {
                $array = array_merge($array, $this->buildQuestionsFromYamlFile($yaml_dir, $question['include'], $generator));
            } else {
                $array[] = $this->buildQuestion($yaml_dir, $question, $generator);
            }
        }

        return $array;
    }

    /**
     * @Test
     *
     * @param string $yaml_dir
     * @param array $question
     * @param IdGenerator $generator
     * @return array
     */
    public function buildQuestion(string $yaml_dir, array $question, IdGenerator $generator): array
    {
        $type = 'text';

        if (isset($question['one'])) {
            $type = 'radio';
        }

        if (isset($question['many'])) {
            $type = 'checkbox';
        }

        // Чистим от множественных пробелов и тримим
        $text = $question['q'];
        $text = trim(preg_replace('/ +/u', ' ', $text));

        $row = [
            'id' => $generator->getNextIndex(),
            'type' => $type,
            'text' => $text,
        ];

        $answers = [];

        if (in_array($type, ['radio', 'checkbox'])) {
            $tmp_answers = [];

            if ($type === 'checkbox') {
                $tmp_answers = $question['many'];
            }

            if ($type === 'radio') {
                $tmp_answers = $question['one'];
            }

            $i = 0;

            foreach ($tmp_answers as $tmp_answer) {
                $answer = [];

                $text = $tmp_answer['a'];

                // Парсим знаки @
                $answer_deposit = null;
                $nb_at_signs = preg_match_all('/\+[\S]+/u', $text, $at_signs);

                if ($nb_at_signs > 0) {
                    $at_signs = array_map(function ($v) {
                        return substr($v, 1);
                    }, $at_signs[0]);

                    $answer['pluses'] = $at_signs;
                }

                // Убираем знаки @ из текста
                $text = trim(preg_replace('/\+[\S]+/u', '', $text));

                // Чистим от множественных пробелов и тримим
                $text = trim(preg_replace('/ +/u', ' ', $text));

                if ($text) {
                    $answer['id'] = ++$i;
                    $answer['text'] = $text;
                } else {
                    $answer['id'] = 0;
                    $row['custom_text'] = true;
                }

                if (isset($tmp_answer['t'])) {
                    $answer['then'] = $this->buildQuestions($yaml_dir, $tmp_answer['t'], $generator);
                }

                $answers[] = $answer;
            }
        }

        if ($answers) {
            $row['answers'] = $answers;
        }

        return $row;
    }

    /**
     * @param array $questions
     * @return array
     */
    public function buildQuestionsLinks(array $questions): array
    {
        $links = [];

        foreach ($questions as $question) {
            $links = array_merge($links, $this->buildQuestionLinks($question));
        }

        return $links;
    }

    /**
     * @param array $array
     * @return array
     */
    public function buildQuestionLinks(array $array): array
    {
        $links[$array['id'] . '_'] = null;

        if (isset($array['answers'])) {
            foreach ($array['answers'] as $answer) {
                if (isset($answer['then'])) {
                    $links[$array['id'] . '_' . $answer['id']] = $answer['then'][0]['id'];

                    $prev_links = [];

                    foreach ($answer['then'] as $then) {
                        foreach ($prev_links as $index => $prev_link) {
                            if ($prev_link === null) {
                                $prev_links[$index] = $then['id'];
                            }
                        }

                        $links = array_merge($links, $prev_links);

                        $prev_links = $this->buildQuestionLinks($then);
                    }

                    $links = array_merge($links, $prev_links);
                } else {
                    $links[$array['id'] . '_' . $answer['id']] = null;
                }

                if (!isset($links[$array['id'] . '_0'])) {
                    $links[$array['id'] . '_0'] = null;
                }
            }
        }

        return $links;
    }

    /**
     * @param int $question_id
     * @param $choices
     * @param $custom_answer
     * @return array
     */
    public function getLinks(int $question_id, $choices, $custom_answer): array
    {
        $links[] = $question_id . '_';

        if ($custom_answer) {
            $links[] = $question_id . '_0';
        }

        if (is_array($choices)) {
            $links = array_merge($links, array_map(function ($v) use ($question_id) {
                return $question_id . '_' . (int) $v;
            }, $choices));
        }

        return $links;
    }

    /**
     * @param array $reference
     * @param array $links
     * @param $chain
     * @return array
     */
    public function getOrderedQuestions(array $reference, array $links, $chain): array
    {
        $questions = Arr::fetch($reference['links'], $links);

        if (is_array($chain)) {
            $questions = array_merge($questions, $chain);
        }

        $questions = array_unique($questions);

        sort($questions);

        return $questions;
    }

    /**
     * @param array $questions
     * @return bool
     */
    public function notEmptyQuestions(array $questions): bool
    {
        return count($questions) > 0;
    }

    /**
     * @param array $array
     * @return array
     */
    public function convertQuestions(array $array): array
    {
        $stack = [];
        $questions = [];
        $links = [];

        foreach ($array as $item) {
            foreach ($links as $index => $link) {
                if ($link === null) {
                    $links[$index] = $item['id'];
                }
            }

            $links = array_merge($links, $this->buildQuestionLinks($item));
        }

        foreach ($array as $item) {
            $rows = $this->convertQuestion($item);

            $stack = array_merge($stack, $rows);
        }

        foreach ($stack as $item) {
            $questions[$item['id']] = $item;
        }

        return [
            'questions' => $questions,
            'links' => array_filter($links)
        ];
    }

    /**
     * @param array $array
     * @return array
     */
    public function convertQuestion(array $array): array
    {
        $rows[] = $array;

        if (isset($rows[0]['answers'])) {
            foreach ($rows[0]['answers'] as $i => $answer) {
                if (isset($answer['then'])) {
                    foreach ($answer['then'] as $then) {
                        $rows = array_merge($rows, $this->convertQuestion($then));
                    }

                    unset($rows[0]['answers'][$i]['then']);
                }

                if (!isset($answer['text'])) {
                    unset($rows[0]['answers'][$i]);
                }
            }
        }

        return $rows;
    }
}
