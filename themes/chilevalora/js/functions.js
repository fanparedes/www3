var $ = jQuery.noConflict();
$( document ).ready( function() {
    $('#abrirpopup1').on({
        'click': function(){
        $('#abrirpopup1').attr('src','images/mapa-y-popup.jpg');
        }
    });
    
    $('#abrirpopup2').on({
        'click': function(){
        $('#abrirpopup2').attr('src','images/popup.jpg');
        }
    });
    
    $('[data-toggle="popover"]').popover();
    $('select').selectpicker();
    // Remove svg.radial-progress .complete inline styling
    $('svg.radial-progress').each(function( index, value ) { 
        $(this).find($('circle.complete')).removeAttr( 'style' );
    });
    $('svg.radial-progress').each(function( index, value ) { 
        // Get percentage of progress
        percent = $(value).data('percentage');
        // Get radius of the svg's circle.complete
        radius = $(this).find($('circle.complete')).attr('r');
        // Get circumference (2πr)
        circumference = 2 * Math.PI * radius;
        // Get stroke-dashoffset value based on the percentage of the circumference
        strokeDashOffset = circumference - ((percent * circumference) / 100);
        // Transition progress for 1.25 seconds
        $(this).find($('circle.complete')).animate({'stroke-dashoffset': strokeDashOffset}, 1250);
    });
    
    $('.progress-bar').each(function( index, value ) { 
        var newprogress = $(this).attr('aria-valuenow');
        $(this).css('width', newprogress+"%");
    });
    
    $("[data-txtalt]").click(function () {
        var temp1 = $(this).data('txtalt');
        var temp2 = $(this).html();
        $(this).text(temp1);
        $(this).data('txtalt', temp2);
    });

    
    $('input[name="preparate"]').amsifySuggestags({
		suggestions: ['HTML','Javascript', 'PHP', 'CSS', 'ASP', '.NET'],
		whiteList: true
	});
    if ($(window).width() < 321) {
        var owl = $('.owl-carousel'),
            owlOptions = {
                loop: false,
                margin: 0,
                smartSpeed: 700,
                stagePadding: 35,
                nav: true,
                items: 1
            };
    } else {
        var owl = $('.owl-carousel'),
            owlOptions = {
                loop: false,
                margin: 0,
                smartSpeed: 700,
                stagePadding: 50,
                nav: true,
                items: 1
            };
    }

    if ($(window).width() < 768) {
        var owlActive = owl.owlCarousel(owlOptions);
    } else {
        owl.addClass('off');
    }
    $(window).resize(function() {
        if ($(window).width() < 768) {
            if ($('.owl-carousel').hasClass('off')) {
                var owlActive = owl.owlCarousel(owlOptions);
                owl.removeClass('off');
            }
        } else {
            if (!$('.owl-carousel').hasClass('off')) {
                owl.addClass('off').trigger('destroy.owl.carousel');
                owl.find('.owl-stage-outer').children(':eq(0)').unwrap();
            }
        }
    });
    
    $('.openMenu').click(function () {
        var container = $("#navbarNavDropdown");
        container.addClass( 'cbp-spmenu-open' );
        $('#backMenu').fadeIn();
    });
    
    $('.closeMenu').click(function () {
        var container = $("#navbarNavDropdown");
        container.removeClass( 'cbp-spmenu-open' );
        $('#backMenu').fadeOut();
    });
    
    $('.openFiltroSector').click(function () {
        var container = $("#FiltroSector");
        container.addClass( 'open' );
        $('#backMenu').fadeIn();
    });
    
    $('.closeFiltroSector').click(function () {
        var container = $("#FiltroSector");
        container.removeClass( 'open' );
        $('#backMenu').fadeOut();
    });
    
    $('.openFiltroOcupacion').click(function () {
        var container = $("#FiltroOcupacion");
        container.addClass( 'open' );
        $('#backMenu').fadeIn();
    });
    
    $('.closeFiltroOcupacion').click(function () {
        var container = $("#FiltroOcupacion");
        container.removeClass( 'open' );
        $('#backMenu').fadeOut();
    });
    
    $('.openFiltroRegion').click(function () {
        var container = $("#FiltroRegion");
        container.addClass( 'open' );
        $('#backMenu').fadeIn();
    });
    
    $('.closeFiltroRegion').click(function () {
        var container = $("#FiltroRegion");
        container.removeClass( 'open' );
        $('#backMenu').fadeOut();
    });

});

$(function() {
  $('a[href*="#"]:not([href="#"], [href*="#collapse"], [href*="#dropdown-toggle"], [href*="#modal"], [href*="#popover"])').on("click touchstart", function(){
    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
      if (target.length) {
        $('html, body').animate({
          scrollTop: target.offset().top
        }, 500);
        return false;
      }
    }
  });
});

$(document).mouseup(function(e) {
    var container = $("#navbarNavDropdown");
    // if the target of the click isn't the container nor a descendant of the container
    if (!container.is(e.target) && container.has(e.target).length === 0 && container.hasClass('cbp-spmenu-open')) 
    {
        container.removeClass( 'cbp-spmenu-open' );
        $('#backMenu').fadeOut();
    }
}); 

$(document).mouseup(function(e) {
    var container = $("#FiltroSector");
    // if the target of the click isn't the container nor a descendant of the container
    if (!container.is(e.target) && container.has(e.target).length === 0 && container.hasClass('open')) 
    {
        container.removeClass( 'open' );
        $('#backMenu').fadeOut();
    }
}); 

$(document).mouseup(function(e) {
    var container = $("#FiltroOcupacion");
    // if the target of the click isn't the container nor a descendant of the container
    if (!container.is(e.target) && container.has(e.target).length === 0 && container.hasClass('open')) 
    {
        container.removeClass( 'open' );
        $('#backMenu').fadeOut();
    }
}); 

$(document).mouseup(function(e) {
    var container = $("#FiltroRegion");
    // if the target of the click isn't the container nor a descendant of the container
    if (!container.is(e.target) && container.has(e.target).length === 0 && container.hasClass('open')) 
    {
        container.removeClass( 'open' );
        $('#backMenu').fadeOut();
    }
}); 