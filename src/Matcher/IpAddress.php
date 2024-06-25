<?php

declare(strict_types=1);

namespace VolkswAIgen\VolkswAIgen\Matcher;

use VolkswAIgen\VolkswAIgen\Matcher;
use VolkswAIgen\VolkswAIgen\Value\IpRange;

final class IpAddress implements Matcher
{

	public function __construct(
		private readonly IpRange $ipRange
	) {
	}

	public function match(string $value): bool
	{
		return $this->ipRange->contains($value);
	}
}
