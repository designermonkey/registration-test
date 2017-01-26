<?php

namespace Example\Application\Controller;

trait CanCapitalizeString
{
    /**
     * @param  string $string
     * @return string
     */
    private function capitalizeString(string $string): string
    {
        $words = preg_split('/[ _-]+/', $string);

        array_walk($words, function (&$word) {
            $word = strtoupper(substr($word, 0, 1)) . substr($word, 1);
        });

        return implode('', $words);
    }
}
