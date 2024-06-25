<?php

namespace VolkswAIgen\VolkswAIgenTest\Value;

use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;
use RuntimeException;
use VolkswAIgen\VolkswAIgen\ListFetcher;
use VolkswAIgen\VolkswAIgen\Main;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use VolkswAIgen\VolkswAIgen\Matcher\IpAddress;
use VolkswAIgen\VolkswAIgen\Matcher\UserAgent;
use VolkswAIgen\VolkswAIgen\Value\IpRange;
use VolkswAIgen\VolkswAIgen\Value\RegEx;

#[CoversClass(Main::class)]
#[CoversClass(ListFetcher::class)]
#[CoversClass(IpAddress::class)]
#[CoversClass(UserAgent::class)]
#[CoversClass(IpRange::class)]
#[CoversClass(RegEx::class)]
class MainTest extends TestCase
{

	#[DataProvider('mainProvider')]
	public function testMain(string $userAgent, string $ipAddress, bool $result): void
	{
		$pool = new class implements CacheItemPoolInterface {

			public function getItem(string $key): CacheItemInterface
			{
				return new class implements CacheItemInterface {

					public function getKey(): string
					{
						throw new RuntimeException('not implemented');
					}

					public function get(): mixed
					{
						return [[
							'value' => 'ChatGPT-User',
							'type' => 'user-agent'
						], [
							'value' => '23.98.142.176/28',
							'type' => 'ip-address'
						]];
					}

					public function isHit(): bool
					{
						throw new RuntimeException('not implemented');
					}

					public function set(mixed $value): static
					{
						throw new RuntimeException('not implemented');
					}

					public function expiresAt(?\DateTimeInterface $expiration): static
					{
						throw new RuntimeException('not implemented');
					}

					public function expiresAfter(\DateInterval|int|null $time): static
					{
						throw new RuntimeException('not implemented');
					}
				};
			}

			/**
			 * @return CacheItemInterface[] $keys
			 */
			public function getItems(array $keys = []): iterable
			{
				throw new RuntimeException('not implemented');
			}

			public function hasItem(string $key): bool
			{
				throw new RuntimeException('not implemented');
			}

			public function clear(): bool
			{
				throw new RuntimeException('not implemented');
			}

			public function deleteItem(string $key): bool
			{
				throw new RuntimeException('not implemented');
			}

			public function deleteItems(array $keys): bool
			{
				throw new RuntimeException('not implemented');
			}

			public function save(CacheItemInterface $item): bool
			{
				throw new RuntimeException('not implemented');
			}

			public function saveDeferred(CacheItemInterface $item): bool
			{
				throw new RuntimeException('not implemented');
			}

			public function commit(): bool
			{
				throw new RuntimeException('not implemented');
			}
		};

		$fetcher = new ListFetcher($pool);

		$main = new Main($fetcher);
		self::assertSame($result, $main->isAiBot($userAgent, $ipAddress));
	}

	/**
	 * @return array{string, string, bool}[]
	 */
	public static function mainProvider(): array
	{
		return [
			['Google', '132.230.200.200', false],
			['ChatGPT-User', '132.230.200.200', true],
			['Something else entirely', '23.98.142.190', true],
		];
	}
}
