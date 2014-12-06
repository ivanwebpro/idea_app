<?php
/**
 * 
 * Show approvals (only admins)
 */
class frontier_approvals_widget extends WP_Widget 
	{
	
	var $defaults;
	
    /** constructor */
    function frontier_approvals_widget() 
		{
	
		$this->defaults = array(
    		'title' 			=> __('My approvals','frontier-post'),
			'show_draft'		=> false,
			'show_pending'		=> true,
			'show_comments'		=> false,
			'show_comment_spam'	=> true,
    		'nolistwrap' 		=> true,
    		'no_approvals_text'	=> __('You have no approvals pending', 'frontier-post'),
			);

		
		
    	$widget_ops = array('description' => __( "List number of posts and comments for approval", 'frontier-post') );
        parent::WP_Widget(false, $name = 'Frontier My Approvals', $widget_ops);	
		}

    /** @see WP_Widget::widget */
    function widget($args, $instance) 
	{
	
	if(is_user_logged_in() && current_user_can("administrator"))
		{
		
		
		global $wpdb;
		
    	$instance 			= array_merge($this->defaults, $instance);
	
		//error_log(print_r($instance), true);
	
		if (isset( $instance['show_draft'] ) && $instance['show_draft'] == true )
			{
			$draft_cnt 			= $wpdb->get_var("SELECT count(id) AS draft_cnt FROM $wpdb->posts WHERE post_status = 'draft'");
			$draft_txt			= $draft_cnt.' '.__('draft posts','frontier-post');
			$show_draft 		= true;
			}
		else
			{
			$show_draft 		= false;
			}
		
		if (isset( $instance['show_pending'] ) && $instance['show_pending'] == true )
			{
			$pending_cnt 		= $wpdb->get_var("SELECT count(id) AS pending_cnt FROM $wpdb->posts WHERE post_status = 'pending'");
			$pending_txt		= $pending_cnt.' '.__('posts to be approved','frontier-post');
			$show_pending 		= true;
			}
		else
			{
			$show_pending 		= false;
			}
		
		if (isset( $instance['show_comments'] ) && $instance['show_comments'] == true )
			{
			$cmt_pending_cnt	= $wpdb->get_var("SELECT count(comment_ID) AS cmt_pending_cnt FROM $wpdb->comments WHERE comment_approved = 0");
			$cmt_pending_txt	= $cmt_pending_cnt.' '.__('comments to be approved','frontier-post');
			$show_comments 		= true;
			}
		else
			{
			$show_comments		= false;
			}
		
		if (isset( $instance['show_comment_spam'] ) && $instance['show_comment_spam'] == true )
			{
			$cmt_spam_cnt		= $wpdb->get_var("SELECT count(comment_ID) AS cmt_pending_cnt FROM $wpdb->comments WHERE comment_approved = 'spam'");
			$cmt_spam_txt		= $cmt_spam_cnt.' '.__('spam comments','frontier-post');
			$show_comment_spam 	= true;
			}
		else
			{
			$show_comment_spam	= false;
			}
		
		
		
		echo $args['before_widget'];
    	if( !empty($instance['title']) )
			{
		    echo $args['before_title'];
		    echo $instance['title'];
		    echo $args['after_title'];
			}
    	
		?>
		
		
		
		
		<div  class="frontier-my-post-widget">
		<ul>
			<?php if ($show_pending) 
				{ ?>
				<li>
					<a href="<?php echo site_url('/wp-admin/edit.php?post_status=pending&post_type=post')?>"><?php echo $pending_txt;?></a>
				</li>
			<?php } ?>
			<?php if ($show_draft) 
				{ ?>
				<li>
					<a href="<?php echo site_url('/wp-admin/edit.php?post_status=draft&post_type=post')?>"><?php echo $draft_txt;?></a>
				</li>
			<?php } ?>
			<?php if ($show_comments) 
				{ ?>
				<li>
					<a href="<?php echo site_url('/wp-admin/edit-comments.php?comment_status=moderated')?>"><?php echo $cmt_pending_txt;?></a>
				</li>
			<?php } ?>
			<?php if ($show_comment_spam) 
				{ ?>
				<li>
					<a href="<?php echo site_url('/wp-admin/edit-comments.php?comment_status=spam')?>"><?php echo $cmt_spam_txt;?></a>
				</li>
			<?php } ?>
		</ul>
		</div>
		<?php
		echo $args['after_widget'];
		}
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) 
		{
		$tmp_boolean_fields = array('show_draft', 'show_pending', 'show_comments', 'show_comment_spam');
    	foreach($this->defaults as $key => $value)
			{
    		if( !isset($new_instance[$key]) )
				{
				//check if is one of the logical fields (checkbox) and set value to false, so it isnt empty...
				if (in_array($key, $tmp_boolean_fields))
					$new_instance[$key] = false;
				else
					$new_instance[$key] = $value;
				}
			}
		//error_log("New: ".print_r($new_instance, true)." - old: ".print_r($old_instance, true));
    	return $new_instance;
		}

    /** @see WP_Widget::form */
    function form($instance) 
	{
    	$instance = array_merge($this->defaults, $instance);
    	
        ?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'frontier-post'); ?>: </label>
			<input type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($instance['title']); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('show_pending'); ?>"><?php _e('Show posts pending approval ?', 'frontier-post'); ?>: </label>
			<input type="checkbox" id="<?php echo $this->get_field_id('show_pending'); ?>" name="<?php echo $this->get_field_name('show_pending'); ?>" value="true" <?php echo ($instance['show_pending'] == true) ? 'checked="checked"':''; ?>/>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('show_draft'); ?>"><?php _e('Show number of draft posts ?', 'frontier-post'); ?>: </label>
			<input type="checkbox" id="<?php echo $this->get_field_id('show_draft'); ?>" name="<?php echo $this->get_field_name('show_draft'); ?>" value="true" <?php echo ($instance['show_draft'] == true) ? 'checked="checked"':''; ?>/>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('show_comments'); ?>"><?php _e('Show comments pending approval ?', 'frontier-post'); ?>: </label>
			<input type="checkbox" id="<?php echo $this->get_field_id('show_comments'); ?>" name="<?php echo $this->get_field_name('show_comments'); ?>" value="true" <?php echo ($instance['show_comments'] == true) ? 'checked="checked"':''; ?>/>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('show_comment_spam'); ?>"><?php _e('Show comments marked as spam ?', 'frontier-post'); ?>: </label>
			<input type="checkbox" id="<?php echo $this->get_field_id('show_comment_spam'); ?>" name="<?php echo $this->get_field_name('show_comment_spam'); ?>" value="true" <?php echo ($instance['show_comment_spam'] == true) ? 'checked="checked"':''; ?>/>
		</p>
		
		<?php 
    }
    
}    
add_action('widgets_init', create_function('', 'return register_widget("frontier_approvals_widget");'));
?>