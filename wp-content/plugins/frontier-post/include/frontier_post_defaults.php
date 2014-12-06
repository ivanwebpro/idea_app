<?php
/*
Default values for Frontier Post plugin
*/

global $default_post_edit_max_age;
global $default_post_delete_max_age;


		
$default_post_edit_max_age		= 7;
$default_post_delete_max_age	= 3;

$frontier_option_list 	= array('can_add', 'can_edit', 'can_publish', 'can_private', 'can_draft', 'can_delete',  'redir_edit', 'show_admin_bar', 'exerpt_edit', 'tags_edit',  'can_media', 'editor', 'category', 'default_category');
$editor_types 			= array(__('Full Editor', 'frontier-post') => 'full', __('Minimal Visual', 'frontier-post') => 'minimal-visual', __('Minimal-Html', 'frontier-post') => 'minimal-html', __('Text Only', 'frontier-post') => 'text');
$category_types 		= array(__('Multi select', 'frontier-post') => 'multi', __('Checkbox', 'frontier-post') => 'checkbox', __('Single select', 'frontier-post') => 'single', __('Hide', 'frontier-post') => 'hide');
$frontier_option_slice 	= 8;

$std_mce_buttons_1		= 'bold, italic, strikethrough, bullist, numlist, blockquote, justifyleft, justifycenter, justifyright, link, unlink, wp_more, fullscreen, wp_adv';
$std_mce_buttons_2		= 'formatselect, underline, justifyfull, forecolor, pastetext, pasteword, removeformat, charmap, outdent, indent, undo, redo, wp_help';
$std_mce_buttons_3		= '';
$std_mce_buttons_4		= '';

$frontier_mce_buttons_1	= 'bold, italic, underline, strikethrough, bullist, numlist, blockquote, justifyleft, justifycenter, justifyright, link, unlink, wp_more, fullscreen, wp_adv';
$frontier_mce_buttons_2	= 'emotions, formatselect, justifyfull, forecolor, pastetext, pasteword, removeformat, charmap, outdent, indent, undo, redo, wp_help';
$frontier_mce_buttons_3 = 'search,replace,|,tablecontrols';
$frontier_mce_buttons_4 = '';

$frontier_author_default_caps = array('delete_posts' => true, 'delete_published_posts' => true, 'edit_posts' => true, 'edit_published_posts' => true, 'publish_posts' => true, 'private_posts' => false, 'read' => true, 'upload_files' => true);
$frontier_author_role_name	  = "frontier-author";


?>