<?php

namespace Perfumer\Questions\Contract;

interface Questions
{
    public function addYamlFile(string $yaml_file): void;

    public function importFromYamlFilesToPhpFiles(array $yaml_files = []): void;

    public function importFromYamlFile(string $file): array;

    public function getNextQuestion(string $file, ?int $question_id, array $answer = [], array $chain = []);
}
