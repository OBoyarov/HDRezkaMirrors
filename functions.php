<?php

/**
 * Упрощенная функция поиска искомых символов в тексте (php version < 8+)
 *
 * @param $text [Где ищем]
 * @param $find [Что ищем]
 * @return bool [true or false]
 */
function str_contains($text, $find):bool {
    if (strpos($text, $find) !== false) {
        return true;
    } else {
        return false;
    }
}
