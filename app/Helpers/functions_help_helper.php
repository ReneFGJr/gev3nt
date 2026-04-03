<?php

if (!function_exists('pre')) {
    /**
     * Imprime um valor em bloco <pre> para depuracao.
     */
    function pre($value, bool $stop = true)
    {
        echo '<hr>';
        echo '<pre>';
        print_r($value);
        echo '</pre>';
        echo '<hr>';

        if ($stop) {
            exit;
        }
        return "";
    }
}
