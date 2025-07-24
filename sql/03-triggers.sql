DELIMITER $$

DROP TRIGGER IF EXISTS trigger_board_uuid$$
CREATE TRIGGER board_id_uuid
BEFORE INSERT ON boards
FOR EACH ROW
BEGIN
  if NEW.board_uuid IS NULL THEN
    SET NEW.board_uuid = UUID();
  END IF;
END$$

DROP TRIGGER IF EXISTS trigger_column_uuid$$
CREATE TRIGGER column_id_uuid
BEFORE INSERT ON columns
FOR EACH ROW
BEGIN
  if NEW.column_uuid IS NULL THEN
    SET NEW.column_uuid = UUID();
  END IF;
END$$

DROP TRIGGER IF EXISTS trigger_card_uuid$$
CREATE TRIGGER card_id_uuid
BEFORE INSERT ON cards
FOR EACH ROW
BEGIN
  if NEW.card_uuid IS NULL THEN
    SET NEW.card_uuid = UUID();
  END IF;
END$$

DELIMITER ;
