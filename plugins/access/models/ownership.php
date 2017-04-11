<?php
class Ownership extends AccessAppModel {
	var $name = 'Ownership';

/**
 * Creates a record that binds an object with an owner
 *
 * @param string $owner
 * @param string $object
 * @param string $acces
 *
 * @return void
 */
	public function bind($owner, $object, $access)
	{
		if ($this->areBound($owner, $object)) {
			return $this->rebind($owner, $object, $access);
		}

		$data = array(
			'Ownership' => array(
				'owner_model' => $owner['model'],
				'owner_id' => $owner['id'],
				'object_model' => $object['model'],
				'object_id' => $object['id'],
				'access' => $access
			)
		);

		$this->create($data);
		$result = $this->save();
		if ($result) {
			$this->log(sprintf('%s::%s bound with %s::%s with access level %s', $owner['model'], $owner['id'], $object['model'], $object['id'], $access), 'access');
			return true;
		}
		$this->log(sprintf('Failed to bind %s::%s with %s::%s with access level %s', $owner['model'], $owner['id'], $object['model'], $object['id'], $access), 'access');

		return false;
	}

/**
 * Checks if owner and object are bound
 *
 * @param string $owner
 * @param string $object
 *
 * @return boolean true if previously bound
 */
    public function areBound($owner, $object)
    {
        $conditions = array(
            'owner_model' => $owner['model'],
            'owner_id' => $owner['id'],
            'object_model' => $object['model'],
            'object_id' => $object['id'],
        );

        return $this->find('count', compact('conditions'));
    }

    /**
     * Changes the access rights for an owner-object bind
     *
     * @param string $owner
     * @param string $object
     * @param string $access
     *
 * @return void
     */
    public function rebind($owner, $object, $access)
	{
		$conditions = array(
			'Ownership.owner_model' => $owner['model'],
			'Ownership.owner_id' => $owner['id'],
			'Ownership.object_model' => $object['model'],
			'Ownership.object_id' => $object['id'],
		);
        $result = $this->updateAll(array('access' => $access), $conditions);
		if ($result) {
            $this->log(
                sprintf(
                    '%s::%s rebound with %s::%s with access %s',
                    $owner['model'],
                    $owner['id'],
                    $object['model'],
                    $object['id'],
                    $access
                ),
                'access'
            );
			return true;
		}

        $this->log(
            sprintf(
                'Failed to bind %s::%s with %s::%s with access level %s',
                $owner['model'],
                $owner['id'],
                $object['model'],
                $object['id'],
                $access
            ),
            'access'
        );

		return false;
	}

/**
 * Remove the association between an object and its owner
 *
 * @param string $owner
 * @param string $object
 *
 * @return void
 */
    public function unbind($owner, $object)
	{
		$conditions = array(
			'Ownership.owner_model' => $owner['model'],
			'Ownership.owner_id' => $owner['id'],
			'Ownership.object_model' => $object['model'],
			'Ownership.object_id' => $object['id'],
		);

        $result = $this->deleteAll($conditions);

		if ($result) {
            $this->log(
                sprintf('%s::%s unbound from %s::%s', $owner['model'], $owner['id'], $object['model'], $object['id']),
                'access'
            );
			return true;
		}

        $this->log(
            sprintf(
                'Failed to unbind %s::%s from %s::%s',
                $owner['model'],
                $owner['id'],
                $object['model'],
                $object['id']
            ),
            'access'
        );
		return false;
	}
	
	
}
?>
