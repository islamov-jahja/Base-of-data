SELECT * FROM `computer`;

-- 1.
INSERT INTO `computer`
VALUES (NULL, "ASUS", 5, 85000);

INSERT INTO `computer`
  (name, price, color)
  VALUES ("Packard bell", 100000, 7);

INSERT INTO `computer`
  (name, price, color)
  SELECT name, price, color FROM `computer`
  WHERE id_computer = 3;
-- 2
DELETE FROM `computer`;

DELETE FROM `computer`
WHERE id_computer = 2;

TRUNCATE TABLE `computer`;
-- 3
UPDATE `computer` SET name="ASUS";

UPDATE `computer` SET name='Packard bell'
  WHERE id_computer > 3;

UPDATE `computer` SET name='Acer', price=25000
  WHERE id_computer = 1;
-- 4
SELECT id_computer, name FROM computer;

SELECT * FROM `computer`;

SELECT * FROM `computer`
  WHERE name='Acer';