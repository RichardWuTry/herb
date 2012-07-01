<?php
// 本类由系统自动生成，仅供测试用途
class IndexAction extends Action {
    public function index(){
		$this->display();
    }
	
	public function login(){
		if (!$this->isPost()) {
			redirect(__URL__.'/index');
		}
		
		$staff_name = $_POST['login'];
		$password = $_POST['password'];
		
		$Staff = M('Staff');
		if ($currStaff = $Staff
						->where("staff_name = '$staff_name' and password = '$password'")
						->field('staff_id')
						->find()) {
			setSessionCookie($currStaff['staff_id'], $staff_name, 1);
			$this->success();
		} else {
			$this->error('Incorrect name or password.');
		}
	}
}