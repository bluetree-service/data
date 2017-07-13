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
        $this->functionTest(
            function ($expression, $type) {
                return Validator::valid($expression, $type);
            }
        );

        $this->assertNull(Validator::valid('some_expression', 'none_existing_type'));
    }

    public function testMail()
    {
        $this->functionTest(
            function ($expression) {
                return Validator::mail($expression);
            },
            'mail'
        );
    }

    public function testPrice()
    {
        $this->functionTest(
            function ($expression) {
                return Validator::price($expression);
            },
            'price'
        );
    }

    public function testPostcode()
    {
        $this->functionTest(
            function ($expression) {
                return Validator::postcode($expression);
            },
            'postcode'
        );
    }

    public function testNip()
    {
        $values = [[
            'correct' => [
                4878280798,
                '998-993-11-84',
                '998 741 29 94',
            ],
            'incorrect' => [
                4874280798,
                48782807981,
                487828079,
                '998-193-11-84',
                '998/993/11/84',
                '998 341 29 94',
            ],
        ]];

        $this->check(
            function ($expression) {
                return Validator::nip($expression);
            },
            $values
        );
    }

    public function testRange()
    {
        $this->assertTrue(Validator::range(-1, null, 23));
        $this->assertTrue(Validator::range(15, 3, 23));
        $this->assertTrue(Validator::range(23423, 3));
        $this->assertTrue(Validator::range(0xd3a743f2ab, 0xa0));
        $this->assertTrue(Validator::range('#aaffff', '#00ffff'));
        $this->assertTrue(Validator::range('#aaffff', '#00ffff', '#bbffff'));

        $this->assertFalse(Validator::range(23423, null, 23));
        $this->assertFalse(Validator::range(2, 3, 23));
        $this->assertFalse(Validator::range(2, 3));
        $this->assertFalse(Validator::range(0xd3a743f2ab, 0xffffffffff));
        $this->assertFalse(Validator::range('#aaffff', '#ffffff'));
    }

    public function testStringLength()
    {
        $this->assertTrue(Validator::stringLength('asdasdasdśżćł', null, 23));
        $this->assertTrue(Validator::stringLength('asdasdasdśżćł', 3, 23));
        $this->assertTrue(Validator::stringLength('asdasdasdśżćł', 3));

        $this->assertFalse(Validator::stringLength('asdasdasdśżćł', null, 5));
        $this->assertFalse(Validator::stringLength('ćł', 3, 23));
        $this->assertFalse(Validator::stringLength('ćł', 3));
    }

    public function testUnderZero()
    {
        $this->assertTrue(Validator::underZero(-1));
        $this->assertFalse(Validator::underZero(2));
    }

    public function testPesel()
    {
        $this->assertTrue(Validator::pesel(97082402112));
        $this->assertFalse(Validator::pesel(93789452112));
        $this->assertFalse(Validator::pesel(9378945211278));
    }

    public function testRegon()
    {
        $this->assertTrue(Validator::regon(451239418));
        $this->assertTrue(Validator::regon('451-239-418'));
        $this->assertTrue(Validator::regon(81420296650613));

        $this->assertFalse(Validator::regon(4512394181));
        $this->assertFalse(Validator::regon(451239419));
        $this->assertFalse(Validator::regon(45123941));
        $this->assertFalse(Validator::regon(814202966506136));
        $this->assertFalse(Validator::regon(8142029665061));
    }

    public function testNrb()
    {
        $this->assertTrue(Validator::nrb('42249000057255503346698354'));
        $this->assertTrue(Validator::nrb('42 2490 0005 7255 5033 4669 8354'));
        $this->assertTrue(Validator::nrb('42-2490-0005-7255-5033-4669-8354'));

        $this->assertFalse(Validator::nrb(42249000057255503346698354));
        $this->assertFalse(Validator::nrb(4224900005725550334669835));
        $this->assertFalse(Validator::nrb(422490000572555033466983544));
        $this->assertFalse(Validator::nrb('42549000057255503346693354'));
    }

    public function testIban()
    {
        $this->assertTrue(Validator::iban('PL67249076002100555998070117'));
        $this->assertTrue(Validator::iban('PL66249022982522'));
        $this->assertTrue(Validator::iban('PL102490405804037964617707221535'));
        $this->assertTrue(Validator::iban('102490405804037964617707221535'));
        $this->assertTrue(Validator::iban('1024-9040-5804-0379-6461-7707-2215-35'));

        $this->assertFalse(Validator::iban('PB67249076002100555998070117'));
        $this->assertFalse(Validator::iban('PL66249022982527'));
        $this->assertFalse(Validator::iban('102490405804037964617707221539'));
    }

    public function testUrl()
    {
        $urlExtended = $this->regularExpressionsProvider()['url_extend'];
        $urlFull = $this->regularExpressionsProvider()['url_full'];
        $url = $this->regularExpressionsProvider()['url'];

        $this->check(
            function ($expression) {
                return Validator::url($expression, 1);
            },
            ['url_extend' => $urlExtended]
        );

        $this->check(
            function ($expression) {
                return Validator::url($expression, 2);
            },
            ['url_full' => $urlFull]
        );

        $this->check(
            function ($expression) {
                return Validator::url($expression);
            },
            ['url' => $url]
        );
    }

    public function testPhone()
    {
        $this->functionTest(
            function ($expression) {
                return Validator::phone($expression);
            },
            'phone'
        );
    }

    public function testStep()
    {
        $this->assertTrue(Validator::step(15, 5, 5));
        $this->assertFalse(Validator::step(12, 5));
        $this->assertFalse(Validator::step(12, 'a'));
    }

    /**
     * @param \Closure $validFunction
     * @param bool|string $type
     */
    protected function functionTest(\Closure $validFunction, $type = false)
    {
        $testData = [];

        if ($type) {
            $testData[$type] = $this->regularExpressionsProvider()[$type];
        } else {
            $testData = $this->regularExpressionsProvider();
        }

        $this->check($validFunction, $testData);
    }

    /**
     * @param \Closure $validFunction
     * @param array $testData
     */
    protected function check(\Closure $validFunction, array $testData)
    {
        foreach ($testData as $type => $data) {
            foreach ($data['correct'] as $correctExpression) {
                $this->assertTrue($validFunction($correctExpression, $type), "$type: $correctExpression");
            }

            foreach ($data['incorrect'] as $incorrectExpression) {
                $this->assertFalse($validFunction($incorrectExpression, $type), "$type: $incorrectExpression");
            }
        }
    }

    protected function regularExpressionsProvider()
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
                    '+48 ( 052 ) 131 231-2312',
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
