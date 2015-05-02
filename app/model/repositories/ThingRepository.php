<?php
/**
 * @author Martin Mikšík
 */
namespace Cake\Model;


class ThingRepository extends BaseRepository{

	public function findRnd()
	{
		$row = $this->connection->select('*')
			 ->from($this->getTable())
			 ->orderBy('RAND()')
			 ->fetch();
		return ($row === false ? NULL : $this->createEntity($row));
	}
} 