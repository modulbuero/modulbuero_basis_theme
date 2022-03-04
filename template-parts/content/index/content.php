<?php
if($GLOBALS['mb_posttype'] === 'post'){
    echo "<h1 class='main-title'>Aktuelles</h1>";
}else{
    $post_type_obj = get_post_type_object($GLOBALS['mb_posttype']);
    echo '<h1 class="main-title">'.$post_type_obj->labels->name.'</h1>';
}
?>

<div class="loop">
    <?php while ( have_posts() ){
        the_post();
        get_template_part('template-parts/content/index/loop', $GLOBALS['mb_posttype']);
	}?>
</div>
