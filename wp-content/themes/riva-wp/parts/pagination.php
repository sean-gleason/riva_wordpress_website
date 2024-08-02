<?php
/**
 * Template Partial: Pagination
 *
 * @package TaotiBaseTheme
 * @author Taoti Creative
 * @todo See if this partial is still in use?
 * @todo Accessibility Fix: Add a <span class="sr-only">prev</span> and next, once 'sr-only' added.
 */

?>
<div class="pagination-container">
	<?php
	the_posts_pagination(
		array(
			'mid_size'           => 2,
			'prev_text'          => '<i class="pagination-arrow pagination-arrow-left"></i>',
			'next_text'          => '<i class="pagination-arrow pagination-arrow-right"></i>',
			'screen_reader_text' => null,
		)
	);
	?>
</div>
