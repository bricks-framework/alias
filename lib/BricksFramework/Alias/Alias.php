<?php

/** @copyright Sven Ullmann <kontakt@sumedia-webdesign.de> **/

declare(strict_types=1);

namespace BricksFramework\Alias;

class Alias implements AliasInterface
{
    protected $aliases = [];

    /**
     * @param  string $alias
     * @param  string $value
     * @throws Exception\AliasRecursionDetection
     */
    public function set(string $alias, string $value): void
    {
        $this->aliases[$alias] = $value;
        $this->checkAndThrowRecursionDetection($alias);
    }

    /**
     * @param  string $alias
     * @return string
     * @throws Exception\AliasRecursionDetection
     */
    public function get(string $alias): string
    {
        $this->checkAndThrowRecursionDetection($alias);
        return $this->getRecursive($alias);
    }

    protected function getRecursive(string $alias): string
    {
        while(($value = ($this->aliases[$alias] ?? $alias)) !== $alias) {
            $alias = $value;
        }
        return $value;
    }

    /**
     * @param  string $alias
     * @throws Exception\AliasRecursionDetection
     */
    protected function checkAndThrowRecursionDetection(string $alias) : void
    {
        $seenAliases = [];
        while(($value = ($this->aliases[$alias] ?? $alias)) !== $alias) {
            if (isset($seenAliases[$alias])) {
                throw new Exception\AliasRecursionDetection('recursion detected on alias ' . $alias);
            }
            $seenAliases[$alias] = $value;
            $alias = $value;
        }
    }
}
