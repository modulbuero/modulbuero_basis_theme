<?php
$mb_datei_antrag        = get_post_meta( get_the_ID(), 'mbgi-antraege-antrag-file', true); 
$mb_datei_bezeichnung   = get_post_meta( get_the_ID(), 'mbgi-antraege-antrag-bezeichnung', true);

if(!empty($mb_datei_antrag)){
    echo "<div class='mb-antrag-wrapper'>";
    echo "<a class='mbgi_antrag' href='".$mb_datei_antrag."'>".$mb_datei_bezeichnung."</a>";
    echo "</div>";
}
?>
