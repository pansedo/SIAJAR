<footer class="footer col-md-12">
	All rights reserved <b><a href='http://seamolec.org'>SEAMOLEC</a></b> &copy; 2017
</footer>

	
	<script src="assets/js/lib/tether/tether.min.js"></script>
	<script src="assets/js/lib/bootstrap/bootstrap.min.js"></script>
	<script src="assets/js/plugins.js"></script>

	<script src="assets/js/lib/salvattore/salvattore.min.js"></script>
	<script src="assets/js/lib/ion-range-slider/ion.rangeSlider.js"></script>
	<script src="assets/js/lib/fancybox/jquery.fancybox.pack.js"></script>
	<script src="assets/js/lib/blockUI/jquery.blockUI.js"></script>
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

		function SelectElement(ID, iniValue){
    		var element = document.getElementById(ID);
		    element.value = iniValue;
			// alert(iniValue);
	  	}

		function loading(){
			$('.page-content').block({
				message: '<div class="blockui-default-message"><i class="fa fa-circle-o-notch fa-spin"></i><h6>Mohon tunggu...</h6></div>',
				overlayCSS:  {
					background: '#3ac9d6',
					opacity: 0.5,
					cursor: 'wait'
				},
				css: {
					width: '50%'
				},
				blockMsgClass: 'block-msg-default'
			});
		}

		function loaded(){
			$('.page-content').unblock();
		}

		$(document).ready(function() {
			$('[data-toggle="popover"]').popover();
		});
	</script>
