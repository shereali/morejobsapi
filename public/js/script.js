(function($) {
    "use strict";

    //when dom is ready
    $(document).ready(function() {

    	if ($(window).width() >= 768) {
			
			$('.close-btn').click(function(){
	   			$('#side-navigation').addClass('collapse-nav');
	    		$('#main-body-section').css( { marginLeft : "50px" } );
	    		$('.open-btn').show();
	    		$(this).hide();
			});

	    	$('.open-btn').click(function(){
	   			$('#side-navigation').removeClass('collapse-nav');
	    		$('#main-body-section').css( { marginLeft : "250px" } );
	    		$('.close-btn').show();
	    		$(this).hide();
			});

    	}

		if ($(window).width() < 768) {
			
			$('#side-navigation').addClass('collapse-nav-zero');
			$('#main-body-section').css( { marginLeft : "0" } );

	    	$('.open-btn').click(function(){
	   			$('#side-navigation').removeClass('collapse-nav-zero');
	    		$('.close-btn').show();
	    		$(this).hide();
			});

		    $('.close-btn').click(function(){
	   			$('#side-navigation').addClass('collapse-nav-zero').removeClass('collapse-nav');
	    		$('.open-btn').show();
	    		$(this).hide();
			});

		}

		// Add slideDown animation to Bootstrap dropdown when expanding.
		 $('.dropdown').on('show.bs.dropdown', function() {
		    $(this).find('.dropdown-menu').first().stop(true, true).slideDown();
		});

		  // Add slideUp animation to Bootstrap dropdown when collapsing.
		$('.dropdown').on('hide.bs.dropdown', function() {
		    $(this).find('.dropdown-menu').first().stop(true, true).slideUp();
		});

        $('.navbar.browse-category .dropdown-item').on('click', function (e) {
            const $el = $(this).children('.dropdown-toggle');
            const $parent = $el.offsetParent(".dropdown-menu");
            $(this).parent("li").toggleClass('open');

            console.log("Menu worked!!");

            if (!$parent.parent().hasClass('navbar-nav')) {
                if ($parent.hasClass('show')) {
                    $parent.removeClass('show');
                    $el.next().removeClass('show');
                    $el.next().css({"top": -999, "left": -999});
                } else {
                    $parent.parent().find('.show').removeClass('show');
                    $parent.addClass('show');
                    $el.next().addClass('show');
                    $el.next().css({"top": $el[0].offsetTop, "left": $parent.outerWidth() - 4});
                }
                e.preventDefault();
                e.stopPropagation();
            }
        });

        $('.navbar.browse-category .dropdown').on('hidden.bs.dropdown', function () {
            $(this).find('li.dropdown').removeClass('show open');
            $(this).find('ul.dropdown-menu').removeClass('show open');
        });



		//Data Table Added


	   	// Select2 Added
	   	$('.select2').select2({
	   		placeholder: "Select options",
	   		width: '100%'
	   	});

        $('[data-title="tooltip"]').tooltip({
            placement:'top',
            trigger: 'hover', //on mouse out it will disappear
            delay: {show: 300}
        });

	});
    //dom ready end
 

})(jQuery);

function loadsweatalert () {
	swal({
	    title: 'Are you sure?',
	    text: "You won't be able to revert this!",
	    type: 'warning',
	    showCancelButton: true,
	    confirmButtonColor: 'red',
	    cancelButtonColor: '#314258',
	    confirmButtonText: 'Delete'
	})
}
 

