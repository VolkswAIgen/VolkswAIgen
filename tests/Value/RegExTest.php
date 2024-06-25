<?php

namespace VolkswAIgen\VolkswAIgenTest\Value;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use VolkswAIgen\VolkswAIgen\Value\RegEx;

#[CoversClass(RegEx::class)]
class RegExTest extends TestCase
{
	#[DataProvider('provideContainsWorks')]
	public function testContainsWorks(string $regex, string $match, bool $contained): void
	{
		$regEx = new RegEx($regex);

		self::assertSame($contained, $regEx->matches($match));
	}

	public static function provideContainsWorks(): array
	{
		return [
			['Chat-GPT', 'Something containind Chat-GPT or not', true],
			['Chat-GPT', 'WTF', false],
		];
	}
}
