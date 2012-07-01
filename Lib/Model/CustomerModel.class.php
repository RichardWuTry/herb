<?php
class CustomerModel extends Model {
	protected $_validate = array(
		array('firstname', 'require', 'Firstname cannot be empty', 1),
		array('surname', 'require', 'Surname cannot be empty', 1),
		array('email', 'email', 'Email is not valid', 2),
	);
	
	protected $_auto = array(
		array('create_at', 'date("Y-m-d H:i:s")', 1, 'function'),
	);
}
?>