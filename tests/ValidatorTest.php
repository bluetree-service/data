<?php
/**
 * test Validator
 *
 * @package     BlueData
 * @subpackage  Test
 * @author      Michał Adamiak    <chajr@bluetree.pl>
 * @copyright   bluetree-service
 */
namespace Test;

use BlueData\Check\Validator;
use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase
{
    public function testRegularExpressions()
    {
        foreach ($this->regularExpressionsProvider() as $type => $data) {
            foreach ($data['correct'] as $correctExpression) {
                $this->assertTrue(Validator::valid($correctExpression, $type), "$type: $correctExpression");
            }

            foreach ($data['incorrect'] as $incorrectExpression) {
                $this->assertFalse(Validator::valid($incorrectExpression, $type), "$type: $incorrectExpression");
            }
        }
    }

    public function regularExpressionsProvider()
    {
        $testData = [
            [
                'correct' => [
                    'asd fgh ąśćź',
                ],
                'incorrect' => [
                    'asd fgh ąśćź 23',
                ]
            ],
            [
                'correct' => [
                    'asd fgh ąśćź _,.-',
                ],
                'incorrect' => [
                    'asd fgh ąśćź 23_,.',
                ]
            ],
            [
                'correct' => [
                    'asd fghfg ążć._,;:-',
                ],
                'incorrect' => [
                    'asd fghfg ążć 23 ._,;:-',
                ]
            ],
            [
                'correct' => [
                    'sdg sar ąśćź 3242 _ ,\\.;:/!@#$%^&*()+=|{}][<>?`~\'"-',
                ],
                'incorrect' => [
                    'sdg sar ąśćź 3242 _ ,\\.;:/!@#$%^&*()+=|{}][<>?`~\'"-' . "\n\t",
                ]
            ],
            [
                'correct' => [
                    23525
                ],
                'incorrect' => [
                    '3234a',
                ]
            ],
            [
                'correct' => [
                    '234-2423/94',
                ],
                'incorrect' => [
                    '4-3234a',
                ]
            ],
            [
                'correct' => [
                    'asdas .,_- 23423',
                ],
                'incorrect' => [
                    '4-asdas .,_- 23423 @',
                ]
            ],
            [
                'correct' => [
                    'asdas .,_- 23423:;',
                ],
                'incorrect' => [
                    '4-asdas .,_- 234:;23 @',
                ]
            ],
            [
                'correct' => [
                    -234234,
                    234234,
                ],
                'incorrect' => [
                    '4-3234a',
                ]
            ],
            [
                'correct' => [
                    -2342.2342,
                    2342.2342,
                    '2342,2342',
                    '-2342,2342',
                ],
                'incorrect' => [
                    234324,
                    '2343.24adsf',
                    -234324,
                ]
            ],
            [
                'correct' => [
                    -2342.2342,
                    2342.2342,
                    '2342,2342',
                    '-2342,2342',
                    234324,
                    -234324,
                ],
                'incorrect' => [
                    '2343.24adsf',
                ]
            ],
            [
                'correct' => [
                    'test@mail.com',
                    '12te-st@ma_il.com',
                ],
                'incorrect' => [
                    'testmail.com',
                    'test@mail',
                    'test@mail.s',
                ]
            ],
            [
                'correct' => [
                    'http://someweb.com',
                    'http://someweb.com/',
                    'http://some-web_.com',
                    'someweb.com',
                ],
                'incorrect' => [
                    'http://someweb.com/subpage',
                    'gesfgsdfg',
                    'https://someweb.com',
                    'http://someweb.com/some-subpage?param1=asdas%d&param2=asdas+-',
                ]
            ],
            [
                'correct' => [
                    'http://someweb.com',
                    'https://someweb.com',
                    'ftp://someweb.com',
                    'ftps://someweb.com',
                    'http://someweb.com/',
                    'http://some-web_.com',
                    'someweb.com',
                ],
                'incorrect' => [
                    'http://someweb.com/subpage',
                    'gesfgsdfg',
                    'http://someweb.com/some-subpage?param1=asdas%d&param2=asdas+-',
                ]
            ],
            [
                'correct' => [
                    'http://someweb.com',
                    'http://someweb.com/some-subpage',
                    'http://someweb.com/some-subpage?param1=asdas%d&param2=asdas+-',
                    'https://someweb.com',
                    'ftp://someweb.com',
                    'ftps://someweb.com',
                    'http://someweb.com/',
                    'http://some-web_.com',
                    'someweb.com',
                ],
                'incorrect' => [
                    'gesfgsdfg',
                    'http://someweb.com/some-subpage?param1=\asda*',
                ]
            ],
            [
                'correct' => [
                    123123,
                    1231.23,
                    '234234,23',
                ],
                'incorrect' => [
                    '2342f',
                    1231.2334,
                    '234234,23324',
                ]
            ],
            [
                'correct' => [
                    '42-400',
                ],
                'incorrect' => [
                    '42400',
                    '42-00',
                    '422-00',
                ]
            ],
            [
                'correct' => [
                    '+48 600 700 800',
                    '600-700-000',
                    '+48600700800',
                ],
                'incorrect' => [
                    '34234234d',
                    '23423/234234/234234',
                ]
            ],
            [
                'correct' => [
                    '12-12-1983',
                ],
                'incorrect' => [
                    '12/12/1983',
                    '2-12-1983',
                    '12-2-1983',
                    '12-12-83',
                    '1983-12-12',
                ]
            ],
            [
                'correct' => [
                    '1983-12-12',
                ],
                'incorrect' => [
                    '1983/12/12',
                    '1983-2-12',
                    '1983-12-2',
                    '12-12-83',
                    '12-12-1983',
                ]
            ],
            [
                'correct' => [
                    '1983-12',
                ],
                'incorrect' => [
                    '1983-1',
                    '83-12',
                ]
            ],
            [
                'correct' => [
                    '2017-06-27 16:42',
                ],
                'incorrect' => [
                    '17-06-27 16:42',
                    '2017-6-27 16:42',
                    '2017-06-27',
                    '2017-06-27 16:2',
                    '2017-06-27 16:42:34',
                ]
            ],
            [
                'correct' => [
                    '12/12/1983',
                ],
                'incorrect' => [
                    '12-12-1983',
                    '1983-12-12',
                    '12/1/1983',
                    '1/12/1983',
                    '12/12/83',
                ]
            ],
            [
                'correct' => [
                    '12/12/1983 07:23',
                ],
                'incorrect' => [
                    '12/12/1983 7:23',
                    '12/12/1983',
                    '12-12-1983',
                    '1983-12-12',
                    '12/1/1983',
                    '1/12/1983',
                    '12/12/83',
                ]
            ],
            [
                'correct' => [
                    '16:45',
                    '16:45:48',
                ],
                'incorrect' => [
                    '6:45',
                    '6:45:48',
                    '16:45:8',
                ]
            ],
            [
                'correct' => [
                    '#ff0000',
                ],
                'incorrect' => [
                    'ff0000',
                    '#fff0000',
                    '#hf0000',
                ]
            ],
            [
                'correct' => [
                    '#fff0000235',
                    '#0000',
                ],
                'incorrect' => [
                    '#fffz0000',
                ]
            ],
            [
                'correct' => [
                    '0x235ad',
                ],
                'incorrect' => [
                    0x235ad,
                    32345,
                    '0235ad',
                    '0x235adz',
                    'x235ad',
                ]
            ],
            [
                'correct' => [
                    '0755',
                    '075512431254213',
                ],
                'incorrect' => [
                    755,
                    0755,
                    '0755a',
                ]
            ],
            [
                'correct' => [
                    'b01010101110110',
                ],
                'incorrect' => [
                    '010101011101102',
                    01010101110110,
                ]
            ],
        ];

        return array_combine(
            array_keys(Validator::$regularExpressions),
            $testData
        );
    }
}
