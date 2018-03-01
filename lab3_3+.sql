-- 1
SELECT * FROM `hardware`
  ORDER BY price;

SELECT * FROM `hardware`
  ORDER BY price DESC ;

SELECT * FROM `hardware`
  ORDER BY id_iron, price;

SELECT  price, id_computer FROM `computer`
  ORDER BY 1;

-- 2
SELECT MAX(price) FROM `computer`
  WHERE id_computer < 2;

SELECT MIN(price) FROM `computer`
  WHERE id_computer < 5;

SELECT AVG(price) FROM `computer`
  WHERE id_computer BETWEEN 1 AND 3;

SELECT SUM(price) FROM `hardware`
  WHERE id_iron BETWEEN 1 AND 3;
-- 3
SELECT name, SUM(price) FROM `computer`
-- произвожу выборку данных
-- и возвращаемого значения агрегированной функции SUM по столбцу name,
-- таблицы computer, где значения ячеек столбца name
-- не могут равняться "ASUS",
-- при этом производится группировка по значениям столбца name.
  WHERE name != 'ASUS'
  GROUP BY name;

SELECT name, SUM(price) AS  sum  FROM `computer`
-- произвожу выборку данных
-- и возвращаемого значения агрегированной функции SUM по столбцу name,
-- таблицы computer, где значения ячеек столбца name
-- не могут равняться "ASUS",
-- при этом производится группировка по значениям столбца name.
-- А после группировки еще фильтруем значния по sum . где sum > 50000
  WHERE name != 'ASUS'
  GROUP BY name
  HAVING sum > 50000;
