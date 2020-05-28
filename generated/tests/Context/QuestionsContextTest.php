<?php

namespace Generated\Tests\Perfumer\Questions\Context;

abstract class QuestionsContextTest extends \PHPUnit\Framework\TestCase
{
    abstract public function buildQuestionDataProvider();

    /**
     * @dataProvider buildQuestionDataProvider
     */
    final public function testBuildQuestion(string $yaml_dir, array $question, \Perfumer\Questions\IdGenerator $generator, $expected)
    {
        $_class_instance = new \Perfumer\Questions\Context\QuestionsContext();

        $this->assertTestBuildQuestion($expected, $_class_instance->buildQuestion($yaml_dir, $question, $generator));
    }

    protected function assertTestBuildQuestion($expected, $result)
    {
        $this->assertEquals($expected, $result);
    }
}
