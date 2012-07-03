<?php
class RecipeAction extends Action {
	function __construct() {
		parent::__construct();
		if (!isLogin()) {
			redirect(__APP__.'/Index/index/');
		}
	}
	
	public function list() {
		if (isset($_GET['id'])) {
			$customer_id = $_GET['id'];
			
		}
	}
	
	public function add() {
	
	}
	
	public function edit() {
	
	}
}
?>