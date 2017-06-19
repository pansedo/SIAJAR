<footer class="footer col-md-12">
	All rights reserved <b><a href='http://seamolec.org'>SEAMOLEC</a></b> &copy; 2017
</footer>

	<script src="assets/js/lib/jquery/jquery.min.js"></script>
	<script src="assets/js/lib/tether/tether.min.js"></script>
	<script src="assets/js/lib/bootstrap/bootstrap.min.js"></script>
	<script src="assets/js/plugins.js"></script>

	<script src="assets/js/lib/salvattore/salvattore.min.js"></script>
	<script src="assets/js/lib/ion-range-slider/ion.rangeSlider.js"></script>
	<script src="assets/js/lib/fancybox/jquery.fancybox.pack.js"></script>
	<script type="text/javascript">
		$(window).bind('scroll', function () {
			if ($(window).scrollTop() > 225) {
				$('#menu-fixed').addClass('menu-fixed');
			} else {
				$('#menu-fixed').removeClass('menu-fixed');
			}

			if ($(window).scrollTop() > 550) {
				$('#menu-fixed2').addClass('menu-fixed2');
			} else {
				$('#menu-fixed2').removeClass('menu-fixed2');
			}
		});

		$(document).ready(function() {
			$('[data-toggle="popover"]').popover();
		});
	</script>
