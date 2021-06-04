<?php

function action_taxonomy_edit_form($tag, $taxonomy) { ?>
	<script>

			jQuery(document).ready(function () {
				jQuery('.edit-tag-actions').clone().insertBefore('#edittag .form-table[role="presentation"]');
			})
	</script>
<?php }

;


add_action("casino-payment_edit_form", 'action_taxonomy_edit_form', 10, 2);
add_action("casino-provider_edit_form", 'action_taxonomy_edit_form', 10, 2);
add_action("casino-category_edit_form", 'action_taxonomy_edit_form', 10, 2);
add_action("casino-games_edit_form", 'action_taxonomy_edit_form', 10, 2);
add_action("casino-slots_edit_form", 'action_taxonomy_edit_form', 10, 2);

