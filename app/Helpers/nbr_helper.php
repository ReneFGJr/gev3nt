<?php

/**
 * Format certificate authors as full names with normalized capitalization.
 */
if (!function_exists('nbr_author')) {
    function nbr_author(string $nome, int $modo = 3): string
    {
        if ($modo !== 3) {
            throw new InvalidArgumentException('Unsupported author format: ' . $modo);
        }

        $nome = Normalizer::normalize($nome, Normalizer::FORM_C);
        $nome = trim(preg_replace('/\s+/u', ' ', $nome));
        $nome = mb_convert_case($nome, MB_CASE_TITLE, 'UTF-8');

        return preg_replace_callback(
            '/\b(?:De|Da|Do|Das|Dos|E|Em)\b/u',
            static fn (array $match): string => mb_strtolower($match[0], 'UTF-8'),
            $nome
        );
    }
}
