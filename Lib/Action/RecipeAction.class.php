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
			$Cust = M('Customer');
			if ($customer = $Cust
							->where("customer_id = $customer_id")
							->find()) {
				$this->assign('customer', $customer);
				$this->assign('staff_id', $_SESSION['user_id']);
				$this->assign('staff_name', $_SESSION['user_name']);
				
				$Recipe = M('Recipe');
				if ($recipes = $Recipe
								->where("customer_id = $customer_id")
								->order('modify_at desc')
								->select()) {
					$this->assign('recipes', $recipes);		
				}
				
				$this->display();
			}
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
	
	public function addRecipe() {
		if ($this->isPost()) {
			$Recipe = D('Recipe');
			if ($Recipe->create()) {
				$Recipe->create_by = $_SESSION['user_name'];
				$Recipe->modify_by = $_SESSION['user_name'];
				if ($recipe_id = $Recipe->add()) {
					redirect(__URL__."/edit/rid/$recipe_id");
				}
			}
		}
	}
	
	public function edit() {
		if (isset($_GET['rid'])) {
			$recipe_id = $_GET['rid'];
			$Model = M();
			if ($record = $Model->query("select
											c.customer_id,
											c.firstname,
											c.surname,
											c.phone,
											c.email,
											c.is_active as c_is_active,
											c.modify_at as c_modify_at,
											c.modify_by as c_modify_by,
											
											r.recipe_id,
											r.contents,
											r.is_issued,
											r.is_active as r_is_active,
											r.issue_at,
											r.issue_by,
											r.modify_at as r_modify_at,
											r.modify_by as r_modify_by,
											
											rc.recipe_comment_id,
											rc.comment,
											rc.modify_at as rc_modify_at,
											rc.modify_by as rc_modify_by
										from
											customer c
											inner join
											recipe r
											on
												c.customer_id = r.customer_id
											left join
											recipe_comment rc
											on
												r.recipe_id = rc.recipe_id
										where
											r.recipe_id = $recipe_id
										limit 1")) {
				$this->assign('record', $record[0]);
				$this->assign('staff_id', $_SESSION['user_id']);
				$this->assign('staff_name', $_SESSION['user_name']);
				$this->display();
			}
		}
	}
	
	public function editRecipe() {
		if ($this->isPost()) {
			$Recipe = D('Recipe');
			if ($Recipe->create()) {
				$Recipe->modify_by = $_SESSION['user_name'];
				if ($Recipe->save()) {
					$this->success('Recipe update succeed');
				} else {
					$this->error('Recipe update failed');
				}
			} else {
				$this->error($Recipe->getError());
			}
		}
	}
	
	public function comment() {
		if ($this->isPost()) {
			$RecipeComment = D('RecipeComment');
			if ($RecipeComment->create()) {
				$RecipeComment->modify_by = $_SESSION['user_name'];
				if (empty($RecipeComment->recipe_comment_id)) {
					$RecipeComment->create_by = $_SESSION['user_name'];
					if ($recipe_comment_id = $RecipeComment->add()) {
						$data['id'] = 'recipe_comment_id';
						$data['value'] = $recipe_comment_id;
						$this->ajaxReturn($data, 'Comment add succeed', 1);
						//$this->success('Comment add succeed');
					} else {
						$this->error('Comment add failed');
					}
				} else {
					if ($RecipeComment->save()) {
						$this->success('Comment update succeed');
					} else {
						$this->error('Comment update failed');
					}
				}
			} else {
				$this->error($RecipeComment->getError());
			}
		}
	}
}
?>