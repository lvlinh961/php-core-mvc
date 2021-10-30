<?php
namespace lvl\phpcoremvc\db;

use lvl\phpcoremvc\Application;
use lvl\phpcoremvc\Model;

abstract class DbModel extends Model
{
	abstract public function tableName();

	abstract public function attributes();

	abstract public function primaryKey();

	public function save()
	{
		$tableName = $this->tableName();
		$attributes = $this->attributes();
		$params = array_map(function($attr) {return ":$attr";}, $attributes);

		$statement = self::prepare("INSERT INTO $tableName (".implode(',', $attributes).") 
			VALUES(".implode(',', $params).")");

		foreach ($attributes as $attribute) {
			$statement->bindValue(":$attribute", $this->{$attribute});
		}

		$statement->execute();
		return true;
	}

	public function findOne($where)
	{
		$tableName = static::tableName();
		$attributes = array_keys($where);
		$conds = implode('AND ', array_map(function($attr) {return "$attr=:$attr";}, $attributes));

		$statement = self::prepare("SELECT * FROM $tableName WHERE $conds");

		foreach ($where as $key => $value) {
			$statement->bindValue(":$key", $value);
		}

		$statement->execute();
		return $statement->fetchObject(static::class);
	}

	public static function prepare($sql)
	{
		return Application::$app->db->pdo->prepare($sql);
	}
}