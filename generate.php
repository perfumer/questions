<?php

use Perfumerlabs\Perfumer\Generator;

require 'vendor/autoload.php';

$generator = new Generator(__DIR__, [
    'generated_annotation_path' => 'generated/annotation',
    'generated_src_path' => 'generated/src',
    'generated_tests_path' => 'generated/tests',
    'src_path' => 'src',
    'tests_path' => 'tests',
    'contract_prefix' => 'Perfumer\\Questions\\Contract',
    'context_prefix' => 'Perfumer\\Questions',
    'class_prefix' => 'Perfumer\\Questions',
    'prettify' => true
]);

$generator->addContext(\Perfumer\Questions\Context\QuestionsContext::class);
$generator->addContract(\Perfumer\Questions\Contract\Questions::class);
$generator->generateAll();
