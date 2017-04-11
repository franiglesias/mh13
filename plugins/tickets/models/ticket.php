<?php
class Ticket extends TicketsAppModel {

	var $name = 'Ticket';
	
	/**
	 * Inits and save a ticket for the model/action
	 *
     * @param string $model
     * @param string $action
     * @param string $expiration
     *
	 * @return id of the newly created ticket
	 * @author Fran Iglesias
	 */
	public function init(Model &$model, $action, $expiration)
	{
		$data = array(
			'action' => $action,
			'created' => date('Y-m-d H:i:s'),
			'expiration' => date('Y-m-d H:i:s',strtotime($expiration)),
			'model' => $model->alias,
			'foreign_key' => $model->id
			);
					
		if($this->save($data)) {
			return $this->id;
		}
		return false;
	}

	/**
	 * Redeems a ticket calling the model action registered
	 *
     * @param string $model
     * @param string $id
     *
	 * @return boolean
	 * @author Fran Iglesias
	 */
	public function redeem(Model &$model, $id)
	{
		$this->getPending($id);
		if (!$this->data) {
			return false;
		}
		$model->id = $this->data['Ticket']['foreign_key'];
		$method = $this->data['Ticket']['action'];
		if (method_exists($model, $method)) {
			$this->saveField('used', 1);
			return $model->{$method}($model->id);
		}
		return false;
	}

    /**
     * Loads a ticket by Id given is a current valid unused ticket
     *
     * @param string $id
     *
     * @return void
     * @author Fran Iglesias
     */
    public function getPending($id = null)
    {
        $this->setId($id);
        $this->data = $this->find(
            'first',
            array(
                'conditions' => array(
                    'id' => $this->id,
                    'used' => 0,
                    'expiration >= CURDATE()',
                ),
            )
        );
    }
	
	/**
	 * Remove all expired or used tickets
	 *
	 * @return void
	 * @author Fran Iglesias
	 */
	public function flush()
	{
		$this->deleteAll(array(
			'OR' => array(
				'expiration < CURDATE()',
				array('expiration >= CURDATE() AND used = 1')
			)
		));
	}


}
?>
