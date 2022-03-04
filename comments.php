<?php if(get_option('mb_kommentare_aus') != 'on'): ?>
<div class="kommentar-container">
    <div class="kommentar-reiter-wrap">
        <h3 id="kommentar-verfassen-reiter" class="active">Kommentar verfassen</h3>
        <h3 class="kommentare-reiter">
            <?php echo count($comments)." Kommentare"; ?>
        </h3>
    </div>
    <div id="kommentar_formular" class="active">    
        <form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">                
            <p>
                <label for="comment">Dein Kommentar*</label>
                <textarea name="comment" id="comment" rows="8"></textarea>
            </p>
            <div class="name-email-wrap">
                <p>
                    <label for="author">Name*</label>
                    <input type="text" name="author" id="author" value="<?php echo $comment_author; ?>"/>
                </p>
                <p>
                    <label for="email">E-Mail* <small>(wird nicht veröffentlicht)</small></label>
                    <input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" tabindex="2"/>
                </p>
            </div>
            
            <p class="datenschutz">
                Mit der Nutzung dieses Formulars erklären Sie sich mit der Speicherung und Verarbeitung Ihrer Daten durch diese Website einverstanden. Weiteres entnehmen Sie bitte der <a href="<?php echo get_privacy_policy_url(); ?>">Datenschutzerklärung.</a>
            </p>
            <p>
                <input name="submit" type="submit" id="submit" tabindex="5" value="Kommentar abschicken" />
                <input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
            </p>
            <?php do_action('comment_form', $post->ID); ?>
        
        </form>
    
    </div> <!-- kommentar_formular -->
    
    <div id="kommentare">
    <?php foreach ($comments as $comment) : ?>
        <?php if ($comment->comment_approved == '0') break; ?>
        <div class="comment" id="comment-<?php comment_ID() ?>">
        
            <small class="commentmetadata"><?php comment_author_link() ?> <strong>|</strong> am <?php comment_date('j. F Y') ?> um <?php comment_time('H:i') ?> Uhr</small>
        
            <?php comment_text() ?>
        
            
        
        </div>
    <?php endforeach; /* end for each comment */ ?> 
    </div><!-- kommentare -->
</div>
<?php endif; 