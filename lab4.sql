SELECT
  name,
  description
FROM `equipment`
  LEFT JOIN `computer`
    ON equipment.id_computer = computer.id_computer
WHERE id_equipment > 2;

SELECT
  name,
  description
FROM `computer`
  RIGHT JOIN `equipment`
    ON equipment.id_computer = computer.id_computer
WHERE id_equipment > 2;

SELECT
  name,
  description
FROM `equipment`
  LEFT JOIN `computer`
    ON equipment.id_computer = computer.id_computer
WHERE computer.name = 'Packard bell' AND computer.color = 5 ;

SELECT
  name,
  description
FROM `equipment`
  LEFT JOIN `computer`
    ON equipment.id_computer = computer.id_computer
WHERE computer.name = 'Packard bell' AND equipment.id_equipment > 2 ;

SELECT
  computer.name,
  hardware.name,
  description
FROM `equipment`
  LEFT JOIN `computer`
    ON equipment.id_computer = computer.id_computer
  LEFT JOIN `hardware`
    ON equipment.id_iron = hardware.id_iron
WHERE computer.name = 'Packard bell' AND equipment.id_equipment > 2;