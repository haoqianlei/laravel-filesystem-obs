<?php

namespace luoyy\HuaweiOBS\Obs\Internal\Common;

interface ITransform
{
    public function transform(string $sign, string $para): ?string;
}
