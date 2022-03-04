$ = jQuery;

class CountdownBlock{
	constructor(blockId){
		this.blockId = blockId;
		this.date = this.getCountdownDate();
		this.interval = setInterval(this.renderCountdown, 1000, this);
		this.renderCountdown(this);
	}

	getCountdownDate(){
		return $(".mbgi-block-countdown .mbgi-countdown-date").eq(this.blockId).attr("data-timestamp");
	}

	renderCountdown(block){
		var timeDiffObj = block.getTimeDifferenceObject();
		if(timeDiffObj.d < 0) {block.setFinished(); return;}
		$(".mbgi-block-countdown .mbgi-countdown-date p.days").eq(block.blockId).html(timeDiffObj.d);
		$(".mbgi-block-countdown .mbgi-countdown-date p.hours").eq(block.blockId).html(timeDiffObj.h);
		$(".mbgi-block-countdown .mbgi-countdown-date p.minutes").eq(block.blockId).html(timeDiffObj.m);
		$(".mbgi-block-countdown .mbgi-countdown-date p.seconds").eq(block.blockId).html(timeDiffObj.s);
	}

	getTimeDifferenceObject(){
		var days, hours, minutes, seconds, offset, dateDifference = 0;
	
		// Differenz zwischen den beiden Dates in Sekunden erhalten
		var now = Math.round(Date.now() / 1000); // für s statt ms
		offset = new Date().getTimezoneOffset() / 60; // zeitzonen offset in stunden
		now -= offset *60*60; // offset in sekunden 
		var dateDifference = this.date - now;  // in sekunden
	
		days = Math.floor(dateDifference / (60 * 60 * 24)); // 60 Sekunden * 60  = 1 Stunde * 24 = 1 Tag
		seconds = dateDifference - (days * 60 * 60 * 24); // == modulo, kann nicht > 23.x Stunden sein
	
		hours = Math.floor(seconds / (60*60)); // Stunden = 60 Sekunden * 60, -1 , sonst eine stunde zu viel
		seconds -= hours * 60 * 60;
	
		minutes = Math.floor(seconds / 60); // Minuten = 60 Sekunden
		seconds -= minutes * 60;
	
		return {d: days, h: hours, m: minutes, s: seconds};
	}

	setFinished(){
		clearInterval(this.interval);
		var currentBlock = $(".mbgi-block-countdown").eq(this.blockId);
		currentBlock.find(".mbgi-countdown-date").html("<p class='ended-countdown centered'>"+currentBlock.attr("data-end-msg")+"</p>");
	}
}


$(document).ready(() => initCountdown());

function initCountdown(){
	var countdownBlocks = $(".mbgi-block-countdown");
	countdownBlocks.each(function(){
		new CountdownBlock(countdownBlocks.index($(this)));
	});
}

