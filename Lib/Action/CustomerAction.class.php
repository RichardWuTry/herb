<?php
// 本类由系统自动生成，仅供测试用途
class CustomerAction extends Action {
	function __construct() {
		parent::__construct();
		if (!isLogin()) {
			redirect(__APP__.'/Index/index/');
		}
	}

	public function add() {
		$this->assign('staff_id', $_SESSION['user_id']);
		$this->assign('staff_name', $_SESSION['user_name']);
		$this->display();
	}

	public function search() {
		$this->display();
	}
	
	public function addCustomer() {
		if ($this->isPost()) {
			$Customer = D('Customer');
			if ($Customer->create()) {
				if ($customer_id = $Customer->add()) {
					$this->success($customer_id);
				} else {
					$this->error('Save Failed');
				}
			} else {
				$this->error($Customer->getError());
			}
		}
	}
}

?>