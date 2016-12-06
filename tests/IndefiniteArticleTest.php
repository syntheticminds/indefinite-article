<?php

namespace Thaumatic\IndefiniteArticle\Tests;

use Thaumatic\IndefiniteArticle;

class IndefiniteArticleTest extends \PHPUnit_Framework_TestCase
{

    public function testExpectedPluralizations()
    {
        $expected = [
            'umbrella' => 'an umbrella',
            'hour' => 'an hour',
            'American' => 'an American',
            'German' => 'a German',
            'Ukrainian' => 'an Ukrainian',
            'Uzbekistani' => 'an Uzbekistani',
            'euphemism' => 'a euphemism',
            'Euler number' => 'an Euler number',
            'unicorn' => 'a unicorn',
            '11th' => 'an 11th',
            'eleventh' => 'an eleventh',
            '18th' => 'an 18th',
            'eighteenth' => 'an eighteenth',
            '118th' => 'a 118th',
            'one hundred eighteenth' => 'a one hundred eighteenth',
            '180th' => 'a 180th',
            'one hundred eightieth' => 'a one hundred eightieth',
            '11018th' => 'an 11018th',
            'eleven thousand eighteenth' => 'an eleven thousand eighteenth',
            '15th' => 'a 15th',
            'fifteenth' => 'a fifteenth',
            '115th' => 'a 115th',
            'one hundred fifteenth' => 'a one hundred fifteenth',
            '5th' => 'a 5th',
            'fifth' => 'a fifth',
        ];
        foreach ($expected as $word => $expect) {
            $this->assertSame($expect, IndefiniteArticle::a($word));
        }
    }

}
