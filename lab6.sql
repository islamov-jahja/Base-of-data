--2
--Выдать информацию о клиентах гостиницы “Алтай”, проживающих в номерах категории “люкс”.
SELECT
  full_name,
  phone
FROM room_in_reservation
  LEFT JOIN room r ON room_in_reservation.id_room = r.id_room
  LEFT JOIN room_kind kind ON r.room_kind_id = kind.room_kind_id
  LEFT JOIN hotel h ON r.hotel_id = h.hotel_id
  LEFT JOIN reservation r2 ON room_in_reservation.id_reservation = r2.id_reservation
  LEFT JOIN client c2 ON r2.id_client = c2.id_client
WHERE hotel_name = "Алтай" AND kind.name = "люкс";

--3
--Дать список свободных номеров всех гостиниц на 30.05.12.
SELECT DISTINCT number_of_room_in_hotel, hotel_name
FROM room_in_reservation
  RIGHT JOIN room r ON room_in_reservation.id_room = r.id_room
  LEFT JOIN hotel h ON r.hotel_id = h.hotel_id
WHERE "2012-05-30" NOT BETWEEN room_in_reservation.date_of_arrival AND room_in_reservation.date_of_departure OR
      room_in_reservation.id_room IS NULL;

--4
--Дать количество проживающих в гостинице “Восток” на 25.05.12 по каждому номеру
-- room kind
SELECT kind.name,  COUNT(room_in_reservation.id_room_in_reservation)
FROM room_in_reservation
  LEFT JOIN room r ON room_in_reservation.id_room = r.id_room
  LEFT JOIN hotel h ON r.hotel_id = h.hotel_id
  LEFT JOIN room_kind kind ON r.room_kind_id = kind.room_kind_id
WHERE h.hotel_name = 'Восток' AND
      "2012-05-25" BETWEEN room_in_reservation.date_of_arrival AND room_in_reservation.date_of_departure
GROUP BY kind.name;

--5
--Дать список последних проживавших клиентов по всем комнатам гостиницы “Космос”, выехавшим в апреле 2012 с указанием даты выезда.
-- ON
DROP TABLE temp_table;
CREATE TEMPORARY TABLE IF NOT EXISTS
  temp_table(INDEX (id_room))
      ENGINE = InnoDB
  AS (
  SELECT room.id_room as id_room, MAX(room_in_reservation.date_of_departure) as date_of_departure FROM room_in_reservation
  LEFT JOIN room ON room_in_reservation.id_room = room.hotel_id
  LEFT JOIN hotel ON hotel.hotel_id = room.hotel_id
  LEFT JOIN reservation ON reservation.id_reservation = room_in_reservation.id_reservation
  LEFT JOIN `client` ON `client`.id_client = reservation.id_client
  WHERE hotel.hotel_name = "Космос" AND room_in_reservation.date_of_departure BETWEEN "2012-04-01" AND "2012-04-30"
  GROUP BY room.id_room
  );

EXPLAIN SELECT `client`.full_name, `client`.phone, `temp_table`.date_of_departure FROM temp_table
LEFT JOIN `room_in_reservation` ON `room_in_reservation`.id_room = `temp_table`.id_room and room_in_reservation.date_of_departure = temp_table.date_of_departure
LEFT JOIN `reservation` ON `reservation`.id_reservation = `room_in_reservation`.id_reservation
LEFT JOIN `client` ON `client`.id_client = `reservation`.id_client;

--6
--Продлить до 30.05.12 дату проживания в гостинице “Сокол” всем клиентам комнат категории “люкс”, которые заселились 15.05.12, а выезжают 28.05.12
UPDATE room_in_reservation
LEFT JOIN room r ON room_in_reservation.id_room = r.id_room
LEFT JOIN room_kind kind ON r.room_kind_id = kind.room_kind_id
LEFT JOIN hotel h ON r.hotel_id = h.hotel_id
SET room_in_reservation.date_of_departure = "2012-05-30"
WHERE h.hotel_name = "Сокол"
AND kind.name = "люкс"
AND room_in_reservation.date_of_arrival = '2012-05-15'
AND room_in_reservation.date_of_departure = '2012-05-28';

--7
--Привести пример транзакции при создании брони.
START TRANSACTION;
SELECT @id_room := 8;
INSERT INTO `reservation` VALUES (NULL, @id_room, "2018-07-13");
SELECT @new_reservation_id := LAST_INSERT_ID();
INSERT INTO `room_in_reservation`
VALUES (NULL, @new_reservation_id, @id_room, "2018-07-13", "2018-08-29");
COMMIT;