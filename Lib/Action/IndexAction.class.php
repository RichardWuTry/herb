<?php
// 本类由系统自动生成，仅供测试用途
class IndexAction extends Action {
    public function index(){
		$this->display();
    }
	
	public function login(){
		if (!$this->isPost()) {
			redirect_to(__URL__.'/index');
		}
		
		$staff_name = $_POST['login'];
		$password = $_POST['password'];
		
		$Staff = M('Staff');
		if ($Staff->where("staff_name = '$staff_name' and password = '$password'")->find()) {
			$this->success();
		} else {
			$this->error('Incorrect name or password.');
		}
	}
}