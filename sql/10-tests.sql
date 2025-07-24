INSERT INTO boards
    (board_title)
VALUES
    ("Testing 1"),
    ("Testing 2"),
    ("Testing 3"),
    ("Testing 4"),
    ("Testing 5")
    ;


SELECT BIN_TO_UUID(board_id, 1), board_name FROM boards;
SELECT BIN_TO_UUID(column_id, 1), BIN_TO_UUID(column_board, 1), column_name FROM columns;


UPDATE columns SET column_position = (@i := @i + 1)
WHERE column_uuid IN ("0198362f-9d7c-79fc-803b-26992760c6d3", "0198362f-9d7c-772a-85bf-14ec8a0cd0bd", "0198362f-9d7c-7f51-8c50-a47897bf31f1")
ORDER BY FIELD(column_uuid, "0198362f-9d7c-79fc-803b-26992760c6d3", "0198362f-9d7c-772a-85bf-14ec8a0cd0bd", "0198362f-9d7c-7f51-8c50-a47897bf31f1")
