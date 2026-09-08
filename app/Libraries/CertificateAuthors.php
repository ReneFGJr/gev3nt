<?php

namespace App\Libraries;

final class CertificateAuthors
{
    public static function key(string $name): string
    {
        $name = \Normalizer::normalize($name, \Normalizer::FORM_D);
        $name = preg_replace('/\p{Mn}+/u', '', $name);

        return mb_strtolower(trim(preg_replace('/\s+/u', ' ', $name)), 'UTF-8');
    }

    public static function unique(string $authors): string
    {
        // Preserve spelling and order; commas and semicolons delimit stored authors.
        $parts = preg_split('/(\s*[,;]\s*)/u', trim($authors), -1, PREG_SPLIT_DELIM_CAPTURE);
        $seen = [];
        $result = '';
        foreach ($parts as $index => $name) {
            if ($index % 2 !== 0) {
                continue;
            }
            $name = trim($name);
            $key = self::key($name);
            if ($key === '' || isset($seen[$key])) {
                continue;
            }
            $seen[$key] = true;
            $result .= ($result === '' ? '' : $parts[$index - 1]) . $name;
        }

        return $result;
    }
}
