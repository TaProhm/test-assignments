<?php

/*
1. Дан массив "категории". Каждая категория имеет следующие параметры:
"id" — уникальный числовой идентификатор категорий
"title" — название категории
"children" - дочерние категории (массив из категорий)

Вложенность категории неограниченна (дочерние категории могу иметь свои вложенные категории и т.д.)

Пример массива :

$categories = array(
	array(
   	"id" => 1,
   	"title" =>  "Обувь",
   	'children' => array(
       	array(
           	'id' => 2,
           	'title' => 'Ботинки',
           	'children' => array(
               	array('id' => 3, 'title' => 'Кожа'),
               	array('id' => 4, 'title' => 'Текстиль'),
           	),
       	),
       	array('id' => 5, 'title' => 'Кроссовки',),
   	)
	),
	array(
   	"id" => 6,
   	"title" =>  "Спорт",
   	'children' => array(
       	array(
           	'id' => 7,
           	'title' => 'Мячи'
       	)
   	)
	),
);

Необходимо написать функцию searchCategory($categories, $id), которая по идентификатору категории возвращает название категории.

 */

/**
 * @param array $categories
 * @param int $id
 * @return string|null
 */
function searchCategory(array $categories, int $id): ?string
{
    foreach ($categories as $category) {
        if ($category['id'] === $id) {
            return $category['title'];
        }

        if (array_key_exists('children', $category)) {
            $title = searchCategory($category['children'], $id);
            if ($title) {
                return $title;
            }
        }
    }

    return null;
}
