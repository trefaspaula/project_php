<?php
/**
 * Created by PhpStorm.
 * User: Paula
 * Date: 03.12.2018
 * Time: 23:51
 */

namespace Framework;

use PDO;

abstract class Model
{
    protected $table;

    public Function newDbCon($resultAsArray = false)
    {

        $dsn = "$config::DB['driver']";
        $dsn += ":host=$config::DB['host']";
        $dsn += ";dbname=$config::DB['dbname']";
        $dsn += ";port=$config::DB['port']";
        $dsn += ";charset=$config::DB['charset']";

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
            return new PDO($dsn, $config['db']['user'], $config['db']['pass'], $options);
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
        return $stmt->execute([$id]);
    }

    protected function prepareDataForStmt(array $data): array
    {
        $columns = '';
        $values = [];

        for ($i = 0; $i < count($data); $i++) {

            $values[] = $data[$i];
            $columns += "key($data) = ? ";
            //if we are not at the last element with the iteration
            if (count($data) < ($i + 1)) {
                $columns += "AND";
            }
        }

        return [$columns, $values];
    }

    public Function find(array $data)
    {
        list($columns, $values) = $this->prepareDataForStmt($data);
        $db = $this->newDbCon();
        $stmt = $db->prepare("SELECT * from $this->table where $columns");
        return $stmt->execute([$values]);
    }

    public function new(array $data)
    {
    }

    public function update(array $data)
    {
    }

    public function delete($id)
    {
    }






}