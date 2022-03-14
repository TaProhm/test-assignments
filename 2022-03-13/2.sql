# 2. Даны три таблицы:
#
# таблица `worker` (работник) с данными — id (id работника), first_name (имя), last_name (фамилия)
# таблица `child` (ребенок) с данными — worker_id (id работника), name (имя ребенка)
# таблица `car` (машина) с данными — worker_id (id работника), model (модель машины)
#
# Структура таблиц:
#
# CREATE TABLE `worker` (
#                           `id` int(11) NOT NULL,
#                           `first_name` varchar(100) NOT NULL,
#                           `last_name` varchar(100) NOT NULL,
#                           PRIMARY KEY (`id`)
# ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
#
#
# CREATE TABLE `car` (
#                        `user_id` int(11) NOT NULL,
#                        `model` varchar(100) DEFAULT NULL
# ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
#
#
# CREATE TABLE `child` (
#                          `user_id` int(11) NOT NULL,
#                          `name` varchar(100) NOT NULL
# ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
#
# Необходимо написать один SQL запрос который возвращает: имена и фамилии всех работников, список их детей через
# запятую и марку машины.
# Выбрать нужно только тех работников, у которых есть или была машина (если машина была и потом её не стало,
# то поле model становится null).


# ========= !!! MY COMMENT ABOUT THE TASK !!! ===============
# Насчёт таблицы car не совсем понятно: могут ли там быть записи о нескольких машинах.
# И вообще может ли там быть больше двух записей на одного worker (первая - о появлении машины, вторая - что машины не стало).
# Если могут, то возникает вопрос насчёт порядка появляения машин (нет колонки с датой). А также непонятно к какой машине
# относится null-значение в поле model, если машин вдруг несколько, а null-значение одно. Напрашивается отдельный столбец
# со статусом машины или отдельная таблица с действиями по машинам.


# !!! Чтобы не усложнять, при составлении запросов исхожу из логики, что в таблице car может быть максимум 2 записи для
# каждого worker. Одна - с моделью машины, другая - с model = null. Если запись одна, то там будет модель машины.

# !!! Насчет столбца "марка машины" в финальной выборке - не понятно что выводить: именно модель, даже если машины
# уже нет или текущий статус машины (т.е. может быть и null). Поэтому запрос написан под первое предположение
# "модель, даже если машины уже нет", а в комментариях в запросе указаны правки под второй случай.

# Для PostgreSQL вместо GROUP_CONCAT можно использовать string_agg или array_agg

SELECT
    w.first_name, w.last_name,
    GROUP_CONCAT(DISTINCT ch.name ORDER BY ch.name ASC) AS children,
    GROUP_CONCAT(DISTINCT c.model) AS car_model
    # IF(SUM(IF(c.model IS NULL, 1, 0)) > 0, null, GROUP_CONCAT(DISTINCT c.model)) AS car_model # если нужно выводить текущий статус машины
FROM
    worker AS w
INNER JOIN
    car AS c ON c.user_id = w.id AND c.model IS NOT NULL
    # car AS c ON c.user_id = w.id  # если нужно выводить текущий статус машины
LEFT JOIN
    child AS ch ON ch.user_id = w.id
GROUP BY
    w.id;
