<?php

namespace VolkswAIgen\VolkswAIgen;

interface Matcher
{
    public function match(string $value): bool;
}
