<?php
/**
 * Plugin Name: somc-subpages-ledaco-anders
 * Description: Display all subpages of the page it's placed on.
 * Author: ledaco-anders
 */
 
class SomcSubpagesLedacoAnders extends WP_Widget {
	
	public function __construct() {
		parent::__construct(
			'somc-subpages-ledaco-anders',
			__('somc-subpages-ledaco-anders', 'text_domain'),
			array( 'description' => __("Display all subpages of the page it's placed on.", 'text_domain'), )
		);
	}
	
	public function widget($args, $instance) {
		global $post;
		
		$children = get_pages('child_of=' . $post->ID . '&sort_column=post_title&sort_order=ASC');
		
		for($i=0; $i<count($children); $i++) if($children[$i]->post_parent == $post->ID) $children[$i]->post_parent = 0;
		
		$all = array();
		
		foreach($children as $child) {
			$all[$child->ID] = array(
									"ID" => $child->ID,
									"post_title" => $child->post_title,
									"child_list" => array()
									);
			if(!array_key_exists($child->post_parent, $all)) {
				$all[$child->post_parent] = array(
												"ID" => "",
												"post_title" => "",
												"child_list" => array()
												);
			}
			
			$all[$child->post_parent]['child_list'][$child->ID] = $child->ID; 
		}
		
		if(!empty($all)) {
			echo '<table class="sortable">
					<thead>
						<tr>
							<th>Title</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
				';
			
			foreach($all[0]['child_list'] as $child_id) {
				$this->printRow($child_id, $all);
			}
			
			echo '</tbody></table>';
		}
	}
	
	//Prints all subpages. The function calls itself if a subpage has subpages.
	private function printRow($index, $all) {
		echo '<tr>';
			if(!empty($all[$index]['child_list'])) echo '<td class="arrow">';
			else echo '<td>';
				echo '<p class="title">';
					if(has_post_thumbnail($all[$index]['ID'])) {
						echo get_the_post_thumbnail($all[$index]['ID'], array(40,40));
					}else {
						echo '<img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==" width="40" height="40" alt="" />';
					}
					echo substr($all[$index]['post_title'], 0, 20);
				echo '</p>';
			echo '</td>';
			echo '<td>';
				if(!empty($all[$index]['child_list'])) {
					echo '<table class="sortable hidden">
							<thead>
								<tr>
									<th>Title</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
						';
					
					foreach($all[$index]['child_list'] as $child_id) {
						$this->printRow($child_id, $all);
					}
					
					echo '</tbody></table>';
				}
			echo '</td>';
		echo '</tr>';
	}
}

function register_somcsubpages_widget() {
    register_widget('SomcSubpagesLedacoAnders');
}

function register_somcsubpages_widget_stylesheet() {
	wp_register_style('custom-style', plugins_url('somc-fedev-20150323-ledaco-anders.min.css', __FILE__ ), array(), '1.0', 'all');
	wp_enqueue_style('custom-style');
}

function register_somcsubpages_widget_script2() {
	wp_register_script('custom_script2', plugins_url('tablesorter/jquery.tablesorter.min.js', __FILE__), array('jquery'),'1.1', true);
	wp_enqueue_script('custom_script2');
}

function register_somcsubpages_widget_script() {
	wp_register_script('custom_script', plugins_url('somc-fedev-20150323-ledaco-anders.js', __FILE__), array('jquery'),'1.1', true);
	wp_enqueue_script('custom_script');
}

add_action('widgets_init', 'register_somcsubpages_widget');
add_action('wp_enqueue_scripts', 'register_somcsubpages_widget_stylesheet');
add_action('wp_enqueue_scripts', 'register_somcsubpages_widget_script2');
add_action('wp_enqueue_scripts', 'register_somcsubpages_widget_script');

add_filter('widget_text', 'do_shortcode');

function shortcode() {
	$obj = new SomcSubpagesLedacoAnders();
	$obj->widget("", "");
}
add_shortcode('somc-subpages-ledaco-anders', 'shortcode');