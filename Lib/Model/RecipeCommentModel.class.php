<?php
class RecipeCommentModel extends Model {
	protected $_auto = array(
		array('create_at', 'date("Y-m-d H:i:s")', 1, 'function'),
	);
}
?>