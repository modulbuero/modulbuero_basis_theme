$ = jQuery;
$(document).ready(() => $(".tab-header").click((e)=> mb_activateTab($(e.currentTarget))));

function mb_activateTab(tab){
	tab.siblings().removeClass("active");
	tab.addClass("active");
	var contentChildren = tab.parent().parent().find(".tabs-content").eq(0).children(); // Tabs in Tabs beachten, daher eq(0)
	var content = contentChildren.filter(x => contentChildren.eq(x).attr("data-id") == tab.attr("data-id"));
	contentChildren.removeClass("active"); 
	content.addClass("active");
}