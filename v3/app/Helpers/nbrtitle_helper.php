<?php

	function nTitle(string $title): string {
    $title = mb_strtolower($title, 'UTF-8');
    $title = preg_replace('/[\x00-\x1F\x7F]+/', ' ', $title);
    $title = preg_replace('/\s+/', ' ', $title);
    $title = trim($title);
    $title = mb_strtoupper(mb_substr($title, 0, 1, 'UTF-8'), 'UTF-8') . mb_substr($title, 1, null, 'UTF-8');
    return $title;
}
