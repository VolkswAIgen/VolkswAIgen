<?php

declare(strict_types=1);

namespace VolkswAIgen\VolkswAIgen\Value;

final class IpRange
{
	private int $cidr = 32;

	/**
	 * @var int[]
	 */
	private array $ip;

	public function __construct(string $ip_address)
	{
		if (str_contains($ip_address, '/')) {
			$this->cidr = (int) substr($ip_address, strpos($ip_address, '/') + 1);
			$ip_address = substr($ip_address, 0, strpos($ip_address, '/'));
		}

		$this->ip = array_map(function(string $part): int {
			return (int) $part;
		}, explode('.', $ip_address));
	}

	public function contains(string $ip): bool
	{
		$ip = array_map(function(string $part): int {
			return (int) $part;
		}, explode('.', $ip));

		$mask = '';
		foreach ($ip as $key => $part) {
			$mask .= str_pad(decbin($part ^ $this->ip[$key]), 8, '0', STR_PAD_LEFT);
		}

		$zero = strpos($mask, '1');
		if ($zero === false) {
			$zero = 32;
		}

		return $zero >=$this->cidr;
	}
}
