<?php

namespace Bukubuku\Core;

abstract class DatabaseModel extends Model
{
    //The following abstract methods have to be implemented in subclasses.
    //They include database-related information.
    //Get database table.
    abstract static protected function getTable(): string;
    //Get the primary key of the database table (assumption: one column).
    abstract static protected function getPrimaryKey(): string;
    //Get the mapping column=>property.
    abstract static protected function columnMapping(): array;

    //Get all columns of the database table.
    public static function getColumnNames(): array
    {
        return array_keys(static::columnMapping());
    }

    //Determine the property for a given column.
    public static function columnToProperty(string $column): string|null
    {
        if (array_key_exists($column, static::columnMapping())) {
            return static::columnMapping()[$column];
        } else {
            return null;
        }
    }

    //Determine the column for a given property.
    public static function propertyToColumn(string $property): string|null
    {
        $column = array_search($property, static::columnMapping());
        if ($column != false) {
            return $column;
        } else {
            return null;
        }
    }

    //Prepare SQL statement.
    public static function prepare($query)
    {
        return Application::$app->db->pdo->prepare($query);
    }

    //Add an alias to column.
    public static function addAlias(string $column): string
    {
        $alias = static::columnToProperty($column);
        return "$column AS $alias";
    }

    //Read all records from the database
    public static function getAll(): array
    {
        $table = static::getTable();
        $columns = static::getColumns();
        $columnsWithAlias = array_map(fn($column) => static::addAlias($column), $columns);


        //Create SQL statement.
        $query = 'SELECT ' . implode(', ', $columnsWithAlias)  . ' FROM ' . $table . ';';
        $statement = static::prepare($query);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function insert(): bool
    {
        $table = static::getTable();
        $columnNames = static::getColumnNames();
        $parameters = array_map(fn($columnName) => ":$columnName", $columnNames);

        //Create SQL statement.
        $query = 'INSERT INTO ' . $table .  ' (' . implode(', ', $columnNames) . ') VALUES (' . implode(', ', $parameters) . ');';
        $statement = static::prepare($query);

        //Fill the parameters.
        foreach ($columnNames as $columnName) {
            $propertyName = static::columnToProperty($columnName);
            if ($propertyName != null) {
                $value = $this->{$propertyName};
            } else {
                $value = null;
            }

            $statement->bindValue(":$columnName", $value);
        }

        //Execute the statement.
        $statement->execute();
        return true;
    }

    protected function isUnique(string $propertyName): bool
    {
        $table = static::getTable();
        $columnName = static::propertyToColumn($propertyName);

        //Create SQL statement.
        $query = "SELECT COUNT(*) FROM $table WHERE $columnName = :$columnName;";
        $statement = static::prepare($query);

        //Fill the parameter and execute the statement.
        $value = $this->{$propertyName};
        $statement->bindValue(":$columnName", $value);
        $statement->execute();
        return !$statement->fetchColumn();
    }
}
