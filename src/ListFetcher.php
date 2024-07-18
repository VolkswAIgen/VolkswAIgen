<?php
/*
 * VolkswAIgen - Adapt your responses when under AI training
 *
 * Copyright (C) 2024 VolkswAIgen-Team
 *
 * This program is free software: you can redistribute it and/or modify it under
 * the terms of the GNU General Public License as published by the Free Software
 * Foundation, either version 3 of the License, or (at your option) any later
 * version. This program is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 * FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more
 * details.
 *
 * You should have received a copy of the GNU General Public License along with
 * this program. If not, see <http://www.gnu.org/licenses/>.
 */
declare(strict_types=1);

namespace VolkswAIgen\VolkswAIgen;

use DateInterval;
use Psr\Cache\CacheItemPoolInterface;

final class ListFetcher
{
	public function __construct(
		private readonly CacheItemPoolInterface $cache,
		private readonly string $listUrl = 'https://api.volkswaigen.org/list',
	) {
	}

	/**
	 * @return array{
	 *     type: 'ip-address'|'user-agent',
	 *     value: string
	 * }[] $cachedList
	 *
	 * @throws \Psr\Cache\InvalidArgumentException
	 */
	public function fetch(): array
	{
		$cache = $this->cache->getItem('volkswAIgen.list');
		/** @var array{
		 *      type: 'ip-address'|'user-agent',
		 *      value: string
		 * }[]|null $cachedList
		 */
		$cachedList = $cache->get();
		if ($cachedList === null) {
			/** @var array{
			 *      type: 'ip-address'|'user-agent',
			 *      value: string
			 * }[] $cachedList
			 */
			$cachedList = json_decode((string) file_get_contents($this->listUrl), true);
			$cache->set($cachedList);
			$cache->expiresAfter(new DateInterval('P1D'));
			$this->cache->save($cache);
		}

		return $cachedList;
	}
}
