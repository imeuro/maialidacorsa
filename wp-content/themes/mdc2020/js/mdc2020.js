window.addEventListener("DOMContentLoaded", function() {
	// INIT LIGHTBOX in albums
	let linkTags = document.querySelectorAll("figure.gallery-item a, .blocks-gallery-item figure a");
	if (linkTags.length !== 0) {
		Array.from(linkTags).forEach(function(el,item,array){
			el.setAttribute('data-fslightbox','');
			if (item == array.length - 1) {
				refreshFsLightbox();
				// console.log('refreshatoh!');
			}
		});
	}

	// let fotolistYear = document.querySelectorAll(".mdc-fotolist-title-year");
	// Array.from(fotolistYear).forEach(function(element,index) {
	// 	let singleFoto = element.querySelectorAll(".mdc-fotolist-item");
	// 	if (singleFoto.length === 0) {
	//		... 
	// 	}
	// });

});

window.addEventListener('load', function() {


	// INIT CAROUSELS in homepage
	let sw = window.innerWidth;

	if (document.querySelectorAll('.swiper-container').length !== 0) {
		let BHArgs = {
			direction: 'horizontal',
			autoplay: {
				delay: 5000,
			},
			loop: true,
			fadeEffect: {
				crossFade: true
			},
			keyboard: {
				enabled: true,
				onlyInViewport: true,
			},
			preloadImages: false,
			lazy: true
		};

		let GHArgs = {};
		if (sw > 640) {
			GHArgs = {
				slidesPerView: '3',
				autoHeight: true,
				centeredSlides: false,
				spaceBetween: 30,
				autoplay: {
					delay: 3000,
				},
				loop: true,
				pagination: {
					el: '.swiper-pagination',
					clickable: true,
				},
			};
		} else {
			GHArgs = {
				slidesPerView: '1',
				autoHeight: true,
				centeredSlides: true,
				spaceBetween: 30,
				autoplay: {
					delay: 3000,
				},
				loop: true,
				pagination: {
					el: '.swiper-pagination',
					clickable: true,
				},
			};
	    }

		let BHSwiper = new Swiper ('.swiper-container.swiper-big-home', BHArgs);
		let GHswiper = new Swiper('.swiper-container.swiper-gallery-home', GHArgs);
	}


});