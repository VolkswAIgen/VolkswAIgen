<?php

declare(strict_types=1);

namespace VolkswAIgen\VolkswAIgen\Value;

final class RegEx
{
	public function __construct(private string $pattern)
	{
	}

	public function matches(string $match): bool
	{

		$result = preg_match(
			'/' . preg_quote($this->pattern, '/') . '/i',
			$match
		);

		return (bool)$result;
	}
}
