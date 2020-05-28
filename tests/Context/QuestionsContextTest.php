<?php

namespace Tests\Perfumer\Questions\Context;

use Perfumer\Questions\IdGenerator;

class QuestionsContextTest extends \Generated\Tests\Perfumer\Questions\Context\QuestionsContextTest
{
    public function buildQuestionDataProvider()
    {
        $generator = function () {
            $instance = new IdGenerator();
            $instance->setInitialIndex(0);

            return $instance;
        };

        return [
            [
                '',
                [
                    'q' => 'foobar'
                ],
                $generator(),
                [
                    'id' => 1,
                    'text' => 'foobar',
                    'type' => 'text'
                ]
            ],
            [
                '',
                [
                    'q' => 'foobar',
                    'one' => [
                        [
                            'a' => 'baz'
                        ]
                    ]
                ],
                $generator(),
                [
                    'id' => 1,
                    'text' => 'foobar',
                    'type' => 'radio',
                    'answers' => [
                        [
                            'id' => 1,
                            'text' => 'baz'
                        ]
                    ]
                ]
            ],
            [
                '',
                [
                    'q' => 'foo  bar',
                    'many' => [
                        [
                            'a' => 'baz +1',
                            't' => [
                                [
                                    'q' => 'foobar',
                                    'one' => [
                                        [
                                            'a' => 'baz +1 +2 +at_sign'
                                        ]
                                    ]
                                ],
                            ]
                        ],
                        [
                            'a' => 'bar  baz'
                        ],
                        [
                            'a' => ''
                        ],
                    ]
                ],
                $generator(),
                [
                    'id' => 1,
                    'text' => 'foo bar',
                    'type' => 'checkbox',
                    'answers' => [
                        [
                            'id' => 1,
                            'text' => 'baz',
                            'pluses' => ['1'],
                            'then' => [
                                [
                                    'id' => 2,
                                    'text' => 'foobar',
                                    'type' => 'radio',
                                    'answers' => [
                                        [
                                            'id' => 1,
                                            'text' => 'baz',
                                            'pluses' => ['1', '2', 'at_sign'],
                                        ]
                                    ]
                                ]
                            ]
                        ],
                        [
                            'id' => 2,
                            'text' => 'bar baz'
                        ],
                        [
                            'id' => 0,
                            'custom_text' => true,
                        ],
                    ]
                ]
            ],
            [
                __DIR__ . '/../Fixture/',
                [
                    'q' => 'foobar',
                    'one' => [
                        [
                            'a' => 'baz',
                            't' => [
                                [
                                    'include' => '1'
                                ]
                            ]
                        ]
                    ]
                ],
                $generator(),
                [
                    'id' => 1,
                    'text' => 'foobar',
                    'type' => 'radio',
                    'answers' => [
                        [
                            'id' => 1,
                            'text' => 'baz',
                            'then' => [
                                [
                                    'id' => 2,
                                    'text' => 'foo_include',
                                    'type' => 'radio',
                                    'answers' => [
                                        [
                                            'id' => 1,
                                            'text' => 'bar_include',
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ],
        ];
    }
}
