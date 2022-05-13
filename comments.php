<?php $comment_form_args = [
	'fields' => [
		'author' => '<div class="uk-margin"><input class="uk-input" id="author" name="author" aria-required="true" placeholder="نام (ضروری)"></div>',
		'email' => '<div class="uk-margin"><input class="uk-input" id="email" name="email" placeholder="ایمیل (ضروری)"></div>',
		'url' => '<div class="uk-margin"><input class="uk-input" id="url" name="url" placeholder="وبسایت (اختیاری)"></div>',
	],
	'label_submit' => 'ارسال دیدگاه',
	'title_reply' => 'نظر خود را ثبت کنید',
	'title_reply_to' => 'Reply',
	'cancel_reply_link' => 'Cancel Reply',
	'comment_field' => '<div class="uk-margin"><textarea class="uk-textarea uk-resize-vertical" id="comment" name="comment" aria-required="true" placeholder="نظر"></textarea></p>',
	'comment_notes_before' => '',
	'comment_notes_after' => '',
	'id_submit' => __('comment-submit'),
	'class_submit' => 'uk-button uk-button-default uk-border-pill'
];
comment_form($comment_form_args);
$args = [
	'post_id' => get_the_ID(),
	'status' => 'approve',
	'type' => 'comment',
	'orderby' => 'comment_date'
];
$comments_query = new WP_Comment_Query;
$comments = $comments_query->query($args);
?>
<?php if ($comments): ?>
	<ul class="uk-comment-list">
		<?php foreach ($comments as $comment) : ?>
			<?php if (intval($comment->comment_parent) === 0): ?>
				<li class="uk-margin-small-top">
					<article class="uk-comment f1-background-444444 f1-border-radius-10 uk-padding-small">
						<header class="uk-comment-header">
							<div class="uk-grid-medium uk-flex-middle" uk-grid>
								<div class="uk-width-auto">
									<img class="uk-comment-avatar uk-border-circle" src="<?php echo "https://www.gravatar.com/avatar/" . md5(strtolower(trim($comment->comment_author_email))) ?>" width="40" height="40" alt="avatar">
								</div>
								<div class="uk-width-expand">
									<h4 class="uk-comment-title uk-margin-remove"><?= $comment->comment_author ?></h4>
									<ul class="uk-comment-meta uk-subnav uk-subnav-divider uk-margin-remove-top">
										<li><?= $comment->comment_date_gmt ?></li>
									</ul>
								</div>
							</div>
						</header>
						<div class="uk-comment-body">
							<p><?= $comment->comment_content ?></p>
						</div>
					</article>
					<?php if (count($comment->get_children()) > 0): ?>
						<ul class="uk-margin-small-top">
							<?php foreach ($comment->get_children() as $child_comment): ?>
								<li class="uk-margin-small-top">
									<article class="uk-comment f1-background-444444 f1-border-radius-10 uk-padding-small">
										<header class="uk-comment-header">
											<div class="uk-grid-medium uk-flex-middle" uk-grid>
												<div class="uk-width-auto">
													<img class="uk-comment-avatar uk-border-circle" src="<?php echo "https://www.gravatar.com/avatar/" . md5(strtolower(trim($child_comment->comment_author_email))) ?>" width="40" height="40" alt="avatar">
												</div>
												<div class="uk-width-expand">
													<h4 class="uk-comment-title uk-margin-remove"><?= $child_comment->comment_author ?></h4>
													<ul class="uk-comment-meta uk-subnav uk-subnav-divider uk-margin-remove-top">
														<li><?= $child_comment->comment_date_gmt ?></li>
													</ul>
												</div>
											</div>
										</header>
										<div class="uk-comment-body">
											<p><?= $child_comment->comment_content ?></p>
										</div>
									</article>
								</li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
				</li>
			<?php endif; ?>
		<?php endforeach; ?>
	</ul>
<?php endif; ?>