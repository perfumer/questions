<?php

namespace Perfumer\Questions\Context;

use Perfumer\Questions\IdGenerator;
use Perfumerlabs\Perfumer\ContextAnnotation\Test;
use Symfony\Component\Yaml\Yaml;

class QuestionsContext
{
    public function parseYamlFile(string $yaml_dir, string $file): array
    {
        return Yaml::parse(file_get_contents($yaml_dir. $file . '.yml'), Yaml::PARSE_CUSTOM_TAGS);
    }

    public function exportToPhpFile(string $php_dir, string $filename, array $array): void
    {
        $content = var_export($array, true);

        $content = '<?php' . PHP_EOL . PHP_EOL . 'return '. $content . ';';

        file_put_contents($php_dir . $filename . '.php', $content);
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
                    $answer['custom_text'] = true;
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
}
