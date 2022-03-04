jQuery(document).ready(($) => {
	$(".mbgi-block-bild-lupe .wrap").click(function(){$(this).siblings().css("display", "flex");});
	$(".mbgi-block-bild-lupe .lupe-lightbox").click(function(){$(this).css("display", "");});
});