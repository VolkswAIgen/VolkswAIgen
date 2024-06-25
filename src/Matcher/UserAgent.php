<?php

declare(strict_types=1);

namespace VolkswAIgen\VolkswAIgen\Matcher;

use VolkswAIgen\VolkswAIgen\Matcher;
use VolkswAIgen\VolkswAIgen\Value\RegEx;

final class UserAgent implements Matcher
{
	public function __construct(private RegEx $userAgent) {}

	public function match($value): bool
	{
		return $this->userAgent->matches($value);
	}
}
