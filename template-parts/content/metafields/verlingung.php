<?php
$mb_verlinkung = get_post_meta( get_the_ID(), 'mb_verlinkung', true); 

if(!empty($mb_verlinkung)){
    echo "<div class='mb-verlinkung-wrapper'>";
    echo "<a class='mb-verlinkung' href='".$mb_verlinkung[0]['url']."'>".$mb_verlinkung[0]['title']."</a>";
    echo "</div>";
}
?>
