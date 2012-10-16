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
				
				if (isset($_GET['rid'])) {
					$recipe_id = $_GET['rid'];
					$Reci = M('Recipe');
					if ($recipe = $Reci
								->where("recipe_id = $recipe_id")
								->field("contents")
								->find()) {
						$contents = $recipe['contents'];
						if (strpos($contents,"Issued by: [") === 0) {
							$contents = implode("\n", array_slice(explode("\n", $contents), 3));
						}
						$this->assign('contents', $contents);
					}
				}

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
					$this->success($recipe_id);
				} else {
					$this->error('Recipe NOT created');
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
				if ($recipeDetail = $Model->query("select
													recipe_detail_id,
													herb,
													volumn
												from
													recipe_detail rd
												where
													rd.recipe_id = $recipe_id")) {
					$this->assign('recipeDetail', $recipeDetail);
				}
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
					$this->success('Recipe updated');
				} else {
					$this->error('Recipe NOT updated');
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
						$this->ajaxReturn($data, 'Comments saved', 1);
						//$this->success('Comment add succeed');
					} else {
						$this->error('Comments not updated');
					}
				} else {
					if ($RecipeComment->save()) {
						$this->success('Comments saved');
					} else {
						$this->error('Comments not updated');
					}
				}
			} else {
				$this->error($RecipeComment->getError());
			}
		}
	}
	
	public function addRecipeDetail() {
		if ($this->isPost()) {
			$recipe_id = $_POST['recipe_id'];
			$herb = $_POST['herb'];
			$volumn = $_POST['volumn'];
			
			$RecipeDetail = M('RecipeDetail');
			$RecipeDetail->recipe_id = $recipe_id;
			$RecipeDetail->herb = $herb;
			$RecipeDetail->volumn = $volumn;
			$RecipeDetail->create_at = date("Y-m-d H:i:s");
			$RecipeDetail->create_by = $_SESSION['user_name'];
			$RecipeDetail->modify_by = $_SESSION['user_name'];
			
			if ($recipe_detail_id = $RecipeDetail->add()) {
				$data['recipe_detail_id'] = $recipe_detail_id;
				$data['herb'] = $herb;
				$data['volumn'] = $volumn;
				$this->ajaxReturn($data, 'Herb saved', 1);
			} else {
				$this->error('Herb NOT saved');
			}
		}
	}
	
	public function delRecipeDetail() {
		if ($this->isPost()) {
			$recipe_detail_id = $_POST['recipe_detail_id'];
			$RecipeDetail = M('RecipeDetail');
			if ($RecipeDetail->delete($recipe_detail_id)) {
				$this->success($recipe_detail_id);
			} else {
				$this->error('Herb NOT deleted');
			}
		}		
	}
	
	public function copyRecipe() {
		if ($this->isPost()) {
			$recipeId = $_POST['recipe_id'];
			$staff = $_SESSION['user_name'];
			$Recipe = M('Recipe');
			if ($copyData = $Recipe->where("recipe_id = $recipeId")
									->field('customer_id, contents')
									->find()) {
				$copyData['create_by'] = $staff;
				$copyData['modify_by'] = $staff;
				$copyData['create_at'] = date("Y-m-d H:i:s");
				
				if ($newRecipeId = $Recipe->add($copyData)) {
					$Recipe->execute("insert into 
										recipe_detail
										(
											recipe_id,
											herb,
											volumn,
											create_at,
											create_by,
											modify_by
										)
									select
										$newRecipeId,
										herb,
										volumn,
										now(),
										'$staff',
										'$staff'
									from
										recipe_detail
									where
										recipe_id = $recipeId");
				
					$this->success($newRecipeId);
				}				
			}
			
			$this->error('Recipe NOT copied');
		}		
	}
	
	public function printRecipe() {
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
											r.modify_by as r_modify_by
										from
											customer c
											inner join
											recipe r
											on
												c.customer_id = r.customer_id
										where
											r.recipe_id = $recipe_id
										limit 1")) {
				if ($recipeDetail = $Model->query("select
													recipe_detail_id,
													herb,
													volumn
												from
													recipe_detail rd
												where
													rd.recipe_id = $recipe_id")) {
					$this->assign('recipeDetail', $recipeDetail);
				}
				$this->assign('record', $record[0]);
				$this->assign('staffName', $_SESSION['user_name']);
				$this->assign('printDate', date('d/m/Y H:i:s'));
				$this->display();
			}
		}
	}
}
?>