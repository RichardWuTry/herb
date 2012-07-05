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
	
	public function update() {
		if ($this->isPost()) {
			$Cust = D('Customer');
			if ($Cust->create()) {
				if ($Cust->save()) {
					$this->success('Succeed save customer information');
				} else {
					$this->error('Failed save customer information');
				}
			} else {
				$this->error($Cust->getError());
			}
		}
	}
	
	public function search() {
		$this->assign('staff_id', $_SESSION['user_id']);
		$this->assign('staff_name', $_SESSION['user_name']);
		$this->display();
	}
	
	public function searchCustomer() {
		if ($this->isPost()) {
			if (!empty($_POST['firstname'])) {
				$firstname = $_POST['firstname'];
				$condition_firstname = "firstname like '%$firstname%'";
			}
			
			if (!empty($_POST['surname'])) {
				$surname = $_POST['surname'];
				$condition_surname = "surname like '%$surname%'";
			}
			
			if (!empty($_POST['phone'])) {
				$phone = $_POST['phone'];
				$condition_phone = "phone like '%$phone%'";
			}
			
			if (!empty($_POST['email'])) {
				$email = $_POST['email'];
				$condition_email = "email like '%$email%'";
			}
			
			if (empty($_POST['include_inactive'])) {
				$condition_is_active = "is_active = 1";
			}
			
			$allAndCondition = (empty($condition_firstname) ? "" : " and ".$condition_firstname)
							.(empty($condition_surname) ? "" : " and ".$condition_surname)
							.(empty($condition_phone) ? "" : " and ".$condition_phone)
							.(empty($condition_email) ? "" : " and ".$condition_email);			
			$allAndCondition = substr($allAndCondition, 0, 4) == " and" 
								? substr($allAndCondition, 4)
								: $allAndCondition;
			$allOrCondition = str_replace("and", "or", $allAndCondition);
			
			if (!empty($condition_is_active)) {
				if (!empty($allAndCondition)) {
					$allAndCondition = $allAndCondition." and ".$condition_is_active;
					$allOrCondition = "(".$allOrCondition.") and ".$condition_is_active;
				} else {
					$allAndCondition = $condition_is_active;
					$allOrCondition = $condition_is_active;
				}
			}
			
			$queryScript1 = "select customer_id, firstname, surname, phone, email, is_active
							from customer "
							.(empty($allAndCondition) ? "" : " where ".$allAndCondition);
			$queryScript2 = "select customer_id, firstname, surname, phone, email, is_active
							from customer "
							.(empty($allOrCondition) ? "" : " where ".$allOrCondition);
			$finalScript = $queryScript1." union ".$queryScript2;
						
			$Model = M();
			$customer = $Model->query($finalScript);
			$this->ajaxReturn($customer, '', 1);
		}
	}
}

?>