<?php

namespace Bukubuku\Core;

abstract class DatabaseModel extends Model
{
    //The following abstract methods have to be implemented in subclasses.
    //They include database-related information.
    //Get database table.
    abstract static protected function getTableName(): string;
    //Get the primary key of the database table (assumption: one column).
    abstract static protected function getPrimaryKeyName(): string;
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

    //Load parameters (from HTML form or session) into model.
    public static function fromDatabase($primaryKeyValue)
    {
        $tableName = static::getTableName();
        $columnNames = static::getColumnNames();
        $columnsWithAlias = array_map(fn($columnName) => static::addAlias($columnName), $columnNames);
        $primaryKeyName = static::getPrimaryKeyName();

        //Create SQL statement.
        $query = 'SELECT ' . implode(', ', $columnsWithAlias)  . ' FROM ' . $tableName . ' WHERE ' . $primaryKeyName . '= :' . $primaryKeyName . ';';
        $statement = static::prepare($query);
        $statement->execute([$primaryKeyName => $primaryKeyValue]);
        $properties = $statement->fetchAll()[0];

        return new static($properties);
    }

    //Add an alias to column.
    public static function addAlias(string $column): string
    {
        $alias = static::columnToProperty($column);
        return "$column AS $alias";
    }

    //Read all records from the database
    public static function getAll(int $page = 0, int $limit = 10): array
    {
        $tableName = static::getTableName();
        $columnNames = static::getColumnNames();
        $columnsWithAlias = array_map(fn($columnName) => static::addAlias($columnName), $columnNames);

        //Create SQL statement.
        $query = 'SELECT ' . implode(', ', $columnsWithAlias)  . ' FROM ' . $tableName;
        if ($page != 0) {
            $query = $query . ' LIMIT :limit OFFSET :offset;';
            $offset = ($page - 1) * $limit;
        } else {
            $query = $query . ';';
        }

        $statement = static::prepare($query);
        if ($page != 0) {
            $statement->bindValue(':limit', $limit, \PDO::PARAM_INT);
            $statement->bindValue(':offset', $offset, \PDO::PARAM_INT);
        }
        $statement->execute();

        return $statement->fetchAll();
    }

    public static function checkExistence(int $primaryKeyValue): bool
    {
        $tableName = static::getTableName();
        $primaryKeyName = static::getPrimaryKeyName();

        //Create SQL statement.
        $query = "SELECT COUNT(*) FROM $tableName WHERE $primaryKeyName = :$primaryKeyName;";
        $statement = static::prepare($query);

        //Bind the parameter and execute the statement.
        $statement->bindValue(":$primaryKeyName", $primaryKeyValue);
        $statement->execute();
        return $statement->fetchColumn();
    }

    public function insert(): bool
    {
        $tableName = static::getTableName();
        $columnNames = static::getColumnNames();
        $parameters = array_map(fn($columnName) => ":$columnName", $columnNames);

        //Create SQL statement.
        $query = 'INSERT INTO ' . $tableName .  ' (' . implode(', ', $columnNames) . ') VALUES (' . implode(', ', $parameters) . ');';
        $statement = static::prepare($query);

        //Bind the parameters.
        foreach ($columnNames as $columnName) {
            $propertyName = static::columnToProperty($columnName);
            if ($propertyName != null) {
                $value = $this->{$propertyName};
                //Implement special logic for DateTime
                if ($value instanceof \DateTime) {
                    //$value = $value->format('Y-m-d');
                    $value = $value->format('Y-m-d H:i:s');
                }
            } else {
                $value = null;
            }

            $statement->bindValue(":$columnName", $value);
        }

        //Execute the statement.
        $statement->execute();
        return true;
    }

    public function update(array $properties = []): bool
    {
        $tableName = static::getTableName();
        $primaryKeyName = static::getPrimaryKeyName();
        if (empty($properties)) {
            $columnNames = static::getColumnNames();
        } else {
            $columnNames = [];
            foreach ($properties as $property) {
                array_push($columnNames, static::propertyToColumn($property));
            }
        }
        $columnNames = array_diff($columnNames, [$primaryKeyName]);
        $columnNamesWithParameters = array_map(fn($columnName) => "$columnName = :$columnName", $columnNames);

        //Create SQL statement.
        $query = 'UPDATE ' . $tableName . ' SET ' . implode(', ', $columnNamesWithParameters) .
            ' WHERE ' . $primaryKeyName . ' = :' . $primaryKeyName . ';';
        $statement = static::prepare($query);

        //Bind the parameters.
        $primaryKeyPropertyName = static::columnToProperty($primaryKeyName);
        $statement->bindValue(":$primaryKeyName", $this->{$primaryKeyPropertyName});
        foreach ($columnNames as $columnName) {
            $propertyName = static::columnToProperty($columnName);
            if ($propertyName != null) {
                $value = $this->{$propertyName};
                //Implement special logic for DateTime
                if ($value instanceof \DateTime) {
                    //$value = $value->format('Y-m-d');
                    $value = $value->format('Y-m-d H:i:s');
                }
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
        $tableName = static::getTableName();
        $columnName = static::propertyToColumn($propertyName);

        //Create SQL statement.
        $query = "SELECT COUNT(*) FROM $tableName WHERE $columnName = :$columnName;";
        $statement = static::prepare($query);

        //Bind the parameter and execute the statement.
        $value = $this->{$propertyName};
        $statement->bindValue(":$columnName", $value);
        $statement->execute();
        return !$statement->fetchColumn();
    }
}
