<?php
class StaffAction extends Action {
	public function logout() {
		clearSessionCookie();
		redirect(__APP__.'/Index/index/');
	}
}
?>