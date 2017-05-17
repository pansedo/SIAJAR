
	<script src="Assets/js/lib/tether/tether.min.js"></script>
	<script src="Assets/js/lib/bootstrap/bootstrap.min.js"></script>
	<script src="Assets/js/plugins.js"></script>
	<script src="Assets/js/lib/slick-carousel/slick.min.js"></script>
	<script src="Assets/js/lib/hide-show-password/bootstrap-show-password.min.js"></script>
	<script src="Assets/js/lib/hide-show-password/bootstrap-show-password-init.js"></script>

	<script src="Assets/js/lib/jquery-tag-editor/jquery.caret.min.js"></script>
	<script src="Assets/js/lib/jquery-tag-editor/jquery.tag-editor.min.js"></script>
	<script src="Assets/js/lib/bootstrap-select/bootstrap-select.min.js"></script>
	<script src="Assets/js/lib/select2/select2.full.min.js"></script>

	<script src="Assets/js/lib/ladda-button/spin.min.js"></script>
	<script src="Assets/js/lib/ladda-button/ladda.min.js"></script>
	<script src="Assets/js/lib/ladda-button/ladda-button-init.js"></script>
	<script>
		$(function() {
			$('#tags-editor-textarea').tagEditor();
		});
	</script>


	<script src="Assets/js/lib/salvattore/salvattore.min.js"></script>
	<script type="text/javascript" src="Assets/js/lib/match-height/jquery.matchHeight.min.js"></script>
	<script>
		$(function() {
			$('.card-user').matchHeight();
		});
	</script>

	<!--<script>
		$(function () {
			$(".profile-card-slider").slick({
				slidesToShow: 1,
				adaptiveHeight: true,
				prevArrow: '<i class="slick-arrow font-icon-arrow-left"></i>',
				nextArrow: '<i class="slick-arrow font-icon-arrow-right"></i>'
			});

			var postsSlider = $(".posts-slider");

			postsSlider.slick({
				slidesToShow: 4,
				adaptiveHeight: true,
				arrows: false,
				responsive: [
					{
						breakpoint: 1700,
						settings: {
							slidesToShow: 3
						}
					},
					{
						breakpoint: 1350,
						settings: {
							slidesToShow: 2
						}
					},
					{
						breakpoint: 992,
						settings: {
							slidesToShow: 3
						}
					},
					{
						breakpoint: 768,
						settings: {
							slidesToShow: 2
						}
					},
					{
						breakpoint: 500,
						settings: {
							slidesToShow: 1
						}
					}
				]
			});

			$('.posts-slider-prev').click(function(){
				postsSlider.slick('slickPrev');
			});

			$('.posts-slider-next').click(function(){
				postsSlider.slick('slickNext');
			});

			/* ==========================================================================
			 Recomendations slider
			 ========================================================================== */

			var recomendationsSlider = $(".recomendations-slider");

			recomendationsSlider.slick({
				slidesToShow: 4,
				adaptiveHeight: true,
				arrows: false,
				responsive: [
					{
						breakpoint: 1700,
						settings: {
							slidesToShow: 3
						}
					},
					{
						breakpoint: 1350,
						settings: {
							slidesToShow: 2
						}
					},
					{
						breakpoint: 992,
						settings: {
							slidesToShow: 3
						}
					},
					{
						breakpoint: 768,
						settings: {
							slidesToShow: 2
						}
					},
					{
						breakpoint: 500,
						settings: {
							slidesToShow: 1
						}
					}
				]
			});

			$('.recomendations-slider-prev').click(function() {
				recomendationsSlider.slick('slickPrev');
			});

			$('.recomendations-slider-next').click(function(){
				recomendationsSlider.slick('slickNext');
			});
		});
	</script>-->
<script type="text/javascript" src="Assets/js/jquery.uploadPreview.min.js"></script>
<script src="Assets/js/lib/uploadfile/custom-file-input.js"></script>
<script src="Assets/js/app.js"></script>\


	<script type="text/javascript">
		$(document).ready(function() {
		  $.uploadPreview({
		    input_field: "#image-upload",
		    preview_box: "#image-preview",
		    label_field: "#image-label"
		  });
		}); 
	</script>
</body>
</html>