$( document ).ready(function() {

   	$('#postForm #enable360Image').change(function() {
        imagePostPreview(); 
    });

	// postTypeMessage click event when click (define post type and make current post type active) 
	$( ".postTypeMessage" ).click(function() {
		$("#postLinkDetails,#postImageDetails,#postVideoDetails").hide();
		$(".postTypeLink,.postTypeImage,.postTypeVideo").removeClass("postTypeActive");
		$("input[name='postType']").val("message");
		$(this).addClass("postTypeActive");
		resetPostPreview();
	});
	
	// postTypeLink click event when click (define post type and make current post type active) 
	$( ".postTypeLink" ).click(function() {
		$("#postLinkDetails").show();
		$("#postImageDetails").hide();
		$("#postVideoDetails").hide();
		$(this).addClass("postTypeActive");
		$(".postTypeMessage").removeClass("postTypeActive");
		$(".postTypeImage").removeClass("postTypeActive");
		$(".postTypeVideo").removeClass("postTypeActive");
		$("input[name='postType']").val("link");
		linkPostPreview();
	});
	
	// postTypeImage click event when click (define post type and make current post type active) 
	$( ".postTypeImage" ).click(function() {
		$("#postImageDetails").show();
		$("#postVideoDetails").hide();
		$("#postLinkDetails").hide();
		$(this).addClass("postTypeActive");
		$(".postTypeMessage").removeClass("postTypeActive");
		$(".postTypeLink").removeClass("postTypeActive");
		$(".postTypeVideo").removeClass("postTypeActive");
		$("input[name='postType']").val("image");
		imagePostPreview();
	});

	// postTypeVideo click event when click (define post type and make current post type active) 
	$( ".postTypeVideo" ).click(function() {
		$("#postVideoDetails").show();
		$("#postImageDetails").hide();
		$("#postLinkDetails").hide();
		$(this).addClass("postTypeActive");
		$(".postTypeMessage").removeClass("postTypeActive");
		$(".postTypeImage").removeClass("postTypeActive");
		$(".postTypeLink").removeClass("postTypeActive");
		$("input[name='postType']").val("video");
		videoPostPreview();
	});
	
});