<?php
class RecipeAction extends Action {
	function __construct() {
		parent::__construct();
		if (!isLogin()) {
			redirect(__APP__.'/Index/index/');
		}
	}
	
	
	public function lists() {
		if (isset($_GET['id'])) {
			$customer_id = $_GET['id'];
		}
	}
	
	public function add() {
		if (isset($_GET['cid'])) {
			$customer_id = $_GET['cid'];
			$Cust = M('Customer');
			if ($customer = $Cust
							->where("customer_id = $customer_id")
							->find()) {
				$this->assign('customer', $customer);
				$this->assign('staff_id', $_SESSION['user_id']);
				$this->assign('staff_name', $_SESSION['user_name']);
				
				// if (isset($_GET['rid'])) {
					// $recipe_id = $_GET['rid'];
					// $Reci = M('Reci');
					// if ($recipe = $Reci
								// ->where("recipe_id = $recipe_id")
								// ->find()) {
						// $this->assign('recipe', $recipe);
					// }
				// }

				$this->display();
			}
		}
	}
	
	public function edit() {
		
	}
}
?>