<?php

namespace VolkswAIgen\VolkswAIgenTest\Value;

use VolkswAIgen\VolkswAIgen\Value\IpRange;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(IpRange::class)]
class IpRangeTest extends TestCase
{
	#[DataProvider('provideContainsWorks')]
	public function testContainsWorks(string $range, string $ip, bool $contained): void
	{
		$range = new IpRange($range);

		self::assertSame($contained, $range->contains($ip));
	}

	public static function provideContainsWorks(): array
	{
		return [
			['123.234.1.2/32', '123.234.1.2', true],
			['123.234.1.2/32', '123.234.1.3', false],
			['123.234.1.2/24', '123.234.1.3', true],
			['123.234.1.2/24', '123.234.1.256', true],
			['123.234.1.2/24', '123.234.2.1', false],
		];
	}
}
