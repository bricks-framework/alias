<?php

/** @copyright Sven Ullmann <kontakt@sumedia-webdesign.de> **/

namespace BricksFramework\Alias;

interface AliasInterface
{
    public function set(string $alias, string $value) : void;

    public function get(string $alias) : string;
}
