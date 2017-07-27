
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

	
<script type="text/javascript" src="Assets/js/jquery.uploadPreview.min.js"></script>
<script src="Assets/js/lib/uploadfile/custom-file-input.js"></script>
<script src="Assets/js/app.js"></script>\


	<script type="text/javascript">
	    function copyTextToClipboard(text) {
	        var textArea = document.createElement("textarea");
	        textArea.style.background = 'transparent';
	        textArea.value = text;
	        document.body.appendChild(textArea);
	        textArea.select();
	        try {
	            var successful = document.execCommand('copy');
	            // var msg = successful ? 'successful' : 'unsuccessful';
	            // console.log('Copying text command was ' + msg);
	            swal({
				  title: 'Berhasil !',
				  text: 'Link Berhasil Di Copy!',
				  type: 'success',
				  timer: 2000
				})
	        } catch (err) {
	            console.log('Oops, unable to copy');
	        }
	        document.body.removeChild(textArea);
	    } 

	    function CopyLink() {
	      copyTextToClipboard(location.href);
	    }
	</script>
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