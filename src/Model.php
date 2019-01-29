<?php
/**
 * Created by PhpStorm.
 * User: Paula
 * Date: 03.12.2018
 * Time: 23:51
 */

namespace Framework;

use App\Config;
use PDO;

abstract class Model
{
    protected $table;

    public Function newDbCon($resultAsArray = false)
    {

        $dsn = Config::DB['driver'];
        $dsn .= ":host=" . Config::DB['host'];
        $dsn .= ";dbname=" . Config::DB['dbname'];
        $dsn .= ";port=" . Config::DB['port'];
        $dsn .= ";charset=" . Config::DB['charset'];

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        //by default the result from database will be an object but if specified it can be changed to    an associative array / matrix
        if ($resultAsArray) {
            $options[PDO::ATTR_DEFAULT_FETCH_MODE] = PDO::FETCH_ASSOC;
        }

        try {
            return new PDO($dsn, Config::DB['user'], Config::DB['pass'], $options);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public Function getAll(): array
    {
        $db = $this->newDbCon();
        $stmt = $db->query("SELECT * from $this->table");

        return $stmt->fetchAll();
    }

    public function get($id)
    {
        $db = $this->newDbCon();
        $stmt = $db->prepare("SELECT * from $this->table where id=?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    protected function prepareDataForStmt(array $data): array
    {
        $columns = '';
        $values = [];

        for ($i = 0; $i < count($data); $i++) {

            $values[] = $data[$i];
            $columns .= "key($data) = ? ";
            //if we are not at the last element with the iteration
            if (count($data) < ($i + 1)) {
                $columns .= "AND";
            }
        }

        return [$columns, $values];
    }

    public Function find(array $data)
    {
        list($columns, $values) = $this->prepareDataForStmt($data);
        $db = $this->newDbCon();
        $stmt = $db->prepare("SELECT * from $this->table where $columns");
        $stmt->execute([$values]);

        return $stmt->fetch();
    }

    private function prepareStmt(array $data): array
    {
        $i = 1;
        $columns = '';
        $values = [];
        foreach ($data as $key => $value) {
            $values[] = $value;
            $columns .= $key . '=?';
            if ($i < (count($data))) {
                $columns .= ", ";
            }
            $i++;
        }
        return [$columns, $values];
    }


    public function new(array $data)
    {
        list($columns, $values) = $this->prepareStmt($data);

        $db = $this->newDbCon();
        $stmt = $db->prepare('INSERT INTO ' . $this->table . ' SET ' . $columns);

        $stmt->execute($values);

        return $db->lastInsertId();
    }

    public function update(array $data)
    {
        list($columns, $values) = $this->prepareStmt($data);
        $values[] = reset($where);

        $db = $this->newDbCon();
        $stmt = $db->prepare('UPDATE ' . $this->table . ' SET ' . $columns . ' WHERE ' . key($where) . '=?');

        return $stmt->execute($values);
    }

    public function delete($id)
    {
        $db = $this->newDbCon();
        $stmt = $db->prepare('DELETE FROM ' . $this->table . ' WHERE id=?');

        return $stmt->execute([$id]);
    }


}