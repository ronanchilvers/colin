<?php

declare(strict_types=1);

namespace App\Database;

use PDO;

class Connection
{
    private $db = null;

    public function __construct(
        private string $dsn,
        private string $username,
        private string $password
    ) {
    }

    public function select(string $sql, array $params = []): ?array
    {
        $this->connect();
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_NAMED);
    }

    public function selectOne(string $sql, array $params = []): ?array
    {
        $this->connect();
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetch(PDO::FETCH_NAMED);
    }

    public function update(
        string $table,
        array $records,
        string $where,
        array $params,
    ) {
        $this->connect();
        $fields = [];
        foreach ($records as $field => $value) {
            $fields[] = "{$field} = :{$field}";
        }
        $sql = sprintf(
            "UPDATE %s
             SET %s
             WHERE %s",
            $table,
            implode(', ', $fields),
            $where
        );
        $records += $params;

        $stmt = $this->db->prepare($sql);
        $stmt->execute($records);

        return true;
    }

    public function insert(string $table, array $records): bool
    {
        $this->connect();
        $fields = $placeholders = [];
        foreach ($records as $field => $value) {
            $fields[] = $field;
            $placeholders[] = ":{$field}";
        }
        $sql = sprintf(
            "INSERT INTO %s (%s) VALUES (%s)",
            $table,
            implode(', ', $fields),
            implode(', ', $placeholders)
        );

        $stmt = $this->db->prepare($sql);
        $stmt->execute($records);

        return true;
    }

    public function delete(string $table, string $where, array $params): bool
    {
        $this->connect();
        $sql = sprintf(
            'DELETE FROM %s WHERE %s',
            $table,
            $where
        );
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return true;
    }

    public function query(string $sql, array $params = []): bool
    {
        $this->connect();
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return true;
    }

    private function connect(): void
    {
        if (!$this->db instanceof PDO) {
            $this->db = new PDO(
                $this->dsn,
                $this->username,
                $this->password
            );
        }
    }
}
