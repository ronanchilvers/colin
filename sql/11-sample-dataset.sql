INSERT INTO `boards` (`board_id`, `board_uuid`, `board_title`)
VALUES
	(1,'019835c6-6d0d-7451-8d45-f2451b6d9750','Testing 1'),
	(2,'019835c6-6d0d-7e4f-b68c-444716c1b7d3','Testing 2'),
	(3,'019835c6-6d0d-7039-bdf7-fe1d81d97a78','Testing 3'),
	(4,'019835c6-6d0d-777d-8250-4ce1aade1601','Testing 4'),
	(5,'019835c6-6d0d-7fba-91db-135dbe74465e','Testing 5');

INSERT INTO `columns` (`column_id`, `column_uuid`, `column_board`, `column_title`, `column_position`)
VALUES
	(1,'0198362f-9d7c-79fc-803b-26992760c6d3', 1,'To Do',1),
	(2,'0198362f-9d7c-7f51-8c50-a47897bf31f1', 1,'Doing',2),
	(3,'0198362f-9d7c-772a-85bf-14ec8a0cd0bd', 1,'Done',3);

INSERT INTO `cards` (`card_board`, `card_uuid`, `card_column`, `card_title`, `card_content`)
VALUES
    (1, '01983630-4abb-7d96-a1a4-883970a9cb1b', 1, 'Card 1', ''),
    (1, '01983630-4abb-705c-ac6b-592b1019602b', 1, 'Card 2', ''),
    (1, '01983630-4abb-7d2c-91ca-7c5ba6417a03', 2, 'Card 3', ''),
    (1, '01983630-4abb-74b4-b6b6-0e46821b15f6', 2, 'Card 4', ''),
    (1, '01983630-4abb-7ddf-8c65-8591d92bf4e6', 2, 'Card 5', ''),
    (1, '01983630-4abb-70d9-ae50-5b99ab4b89c5', 3, 'Card 6', ''),
    (1, '01983630-4abb-7e40-94d5-70f3eae3fc34', 3, 'Card 7', ''),
    (1, '01983630-4abb-76d0-b563-d7a94111d118', 1, 'Card 8', '');
