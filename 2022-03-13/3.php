<?php

/*
3. Написать функцию, которая на входе принимает массив из открывающихся или закрывающихся тегов  (например “<a>”, “</td>” ),
а возвращает результат проверки корректности: т.е. является ли принятая функцией последовательность тегов структурой
корректного HTML документа. Например, последовательность “<a>”, “<div>”, “</div>”, “</a>”, “<span>”, “</span>” -
корректная структура, а последовательность “<a>”, “<div>”, ”</a>” - некорректная структура.
Необходимо использовать нативный php без использования библиотек DOMDocument, Simplexml и тд.
*/

/**
 * @param array $tags
 * @return bool
 */
function isValidHtml(array $tags): bool
{
    $s = new SplStack();
    foreach ($tags as $tag) {
        if (mb_stripos($tag, '/') === false) {
            $s->push($tag);
        } else if (!$s->isEmpty() && $s->top() === str_replace('/', '',$tag)) {
            $s->pop();
        } else {
            return false;
        }
    }

    return $s->isEmpty();
}
