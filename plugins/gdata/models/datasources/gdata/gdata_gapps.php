<?php
/**
 * DataSource for the Gdata Youtube API
 *
 */
class GdataGapps extends GdataSource {

  /**
   * Used in the Gdata ClientLogin request
   *
   * @var string
   */
  protected $_service = 'cl';

  /**
   * The URI of the Client Login.
   *
   * @var string
   */
  protected $_clientLoginUri = 'https://www.google.com/accounts/ClientLogin';

 
	public function setLogin($email, $password) {
		$this->config['email'] = $email;
		$this->config['passwd'] = $password;
	}


}
?>