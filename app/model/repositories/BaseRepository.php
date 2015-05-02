<?php
/**
 * @author Martin Mikšík
 */
namespace Cake\Model;

use LeanMapper\Repository;

class BaseRepository extends Repository {

	public function find($id)
	{
		$row = $this->connection->select('*')
			->from($this->getTable())
			->where('id = %i', $id)
			->fetch();
		return ($row === false ? NULL : $this->createEntity($row));
	}

	public function findAll()
	{
		return $this->createEntities(
			$this->connection->select('*')
				->from($this->getTable())
				->fetchAll()
		);
	}

	public function countAll()
	{
		$q =  $this->connection->select('COUNT(*) AS count')
				->from($this->getTable());
		return $q->fetch()->count;
	}

}
 