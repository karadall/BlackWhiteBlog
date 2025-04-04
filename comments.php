<?php
if (post_password_required()) {
    return;
}
?>
<div id="comments" class="comments-area">
    <?php if (have_comments()) : ?>
        <h2 class="comments-title">
            <?php
            $comments_number = get_comments_number();
            if ($comments_number === 1) {
                echo '1 ' . __('Yorum', 'blackwhiteblog');
            } else {
                echo $comments_number . ' ' . __('Yorum', 'blackwhiteblog');
            }
            ?>
        </h2>
        <ol class="comment-list">
            <?php
            wp_list_comments(array(
                'style'       => 'ol',
                'short_ping'  => true,
                'avatar_size' => 48,
                'callback'    => 'custom_comment_callback',
            ));
            ?>
        </ol>
        <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : ?>
            <nav class="comment-navigation">
                <div class="comment-previous"><?php previous_comments_link('← ' . __('Önceki Yorumlar', 'blackwhiteblog')); ?></div>
                <div class="comment-next"><?php next_comments_link(__('Sonraki Yorumlar', 'blackwhiteblog') . ' →'); ?></div>
            </nav>
        <?php endif; ?>
    <?php endif; ?>
    <?php if (!comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')) : ?>
        <p class="no-comments"><?php _e('Yorumlar kapalı.', 'blackwhiteblog'); ?></p>
    <?php endif; ?>
    <?php
    comment_form(array(
        'title_reply'         => __('Yorum Yap', 'blackwhiteblog'),
        'title_reply_before'  => '<h2 id="reply-title" class="comment-reply-title">',
        'title_reply_after'   => '</h2>',
        'comment_field'       => '<div class="comment-form-comment"><textarea id="comment" name="comment" placeholder="' . esc_attr__('Yorumunuzu buraya yazın...', 'blackwhiteblog') . '" required></textarea></div>',
        'fields'              => array(
            'author' => '<div class="comment-form-author"><input id="author" name="author" type="text" placeholder="' . esc_attr__('İsim *', 'blackwhiteblog') . '" value="' . esc_attr($commenter['comment_author']) . '" required /></div>',
            'email'  => '<div class="comment-form-email"><input id="email" name="email" type="email" placeholder="' . esc_attr__('E-posta *', 'blackwhiteblog') . '" value="' . esc_attr($commenter['comment_author_email']) . '" required /></div>',
        ),
        'submit_button'       => '<button name="%1$s" type="submit" id="%2$s" class="%3$s">' . __('Gönder', 'blackwhiteblog') . '</button>',
        'submit_field'        => '<div class="form-submit">%1$s %2$s</div>',
        'logged_in_as'        => '<p class="logged-in-as">' . sprintf(
            __('%1$s olarak oturum açıldı. <a href="%2$s">Profilinizi düzenleyin</a> veya <a href="%3$s">oturumu kapatın</a>.', 'blackwhiteblog'),
            wp_get_current_user()->display_name,
            admin_url('profile.php'),
            wp_logout_url(apply_filters('the_permalink', get_permalink()))
        ) . '</p>',
        'comment_notes_before' => '<p class="comment-notes">' . __('Gerekli alanlar <span class="required">*</span> ile işaretlenmiştir.', 'blackwhiteblog') . '</p>',
    ));
    ?>
</div>
<?php
function custom_comment_callback($comment, $args, $depth) {
    ?>
    <li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
        <article class="comment-body">
            <div class="comment-author">
                <?php echo get_avatar($comment, $args['avatar_size']); ?>
                <div class="comment-author-info">
                    <span class="comment-author-name"><?php comment_author_link(); ?></span>
                    <time class="comment-date" datetime="<?php comment_time('c'); ?>">
                        <?php printf('%1$s', get_comment_date('d.m.Y')); ?>
                    </time>
                </div>
            </div>
            <div class="comment-content">
                <?php if ($comment->comment_approved == '0') : ?>
                    <p class="comment-awaiting-moderation"><?php _e('Yorumunuz onay bekliyor.', 'blackwhiteblog'); ?></p>
                <?php endif; ?>
                <?php comment_text(); ?>
            </div>
            <div class="comment-reply">
                <?php
                comment_reply_link(array_merge($args, array(
                    'reply_text' => __('Yanıtla', 'blackwhiteblog'),
                    'depth'      => $depth,
                    'max_depth'  => $args['max_depth'],
                )));
                ?>
            </div>
        </article>
    </li>
    <?php
}
?>