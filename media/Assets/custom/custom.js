var manageKategoriTable;
	$(document).ready(function() {
		manageKategoriTable = $("#manageKategoriTable").DataTable({
			"ajax": "php_action/retrieve.php",
			"order": []
		});

		$("#addMemberModalBtn").on('click', function() {
			// reset the form 
			$("#createMemberForm")[0].reset();
			// remove the error 
			$(".form-group").removeClass('has-error').removeClass('has-success');
			$(".text-danger").remove();
			// empty the message div
			$(".messages").html("");

			// submit form
			$("#createMemberForm").unbind('submit').bind('submit', function() {

				$(".text-danger").remove();

				var form = $(this);

				// validation
				var name = $("#name").val();
				var address = $("#address").val();
				var contact = $("#contact").val();
				var active = $("#active").val();

				if(name == "") {
					$("#name").closest('.form-group').addClass('has-error');
					$("#name").after('<p class="text-danger">The Name field is required</p>');
				} else {
					$("#name").closest('.form-group').removeClass('has-error');
					$("#name").closest('.form-group').addClass('has-success');				
				}

				if(address == "") {
					$("#address").closest('.form-group').addClass('has-error');
					$("#address").after('<p class="text-danger">The Address field is required</p>');
				} else {
					$("#address").closest('.form-group').removeClass('has-error');
					$("#address").closest('.form-group').addClass('has-success');				
				}

				if(contact == "") {
					$("#contact").closest('.form-group').addClass('has-error');
					$("#contact").after('<p class="text-danger">The Contact field is requiredsss</p>');
				} else {
					$("#contact").closest('.form-group').removeClass('has-error');
					$("#contact").closest('.form-group').addClass('has-success');				
				}

				if(active == "") {
					$("#active").closest('.form-group').addClass('has-error');
					$("#active").after('<p class="text-danger">The Active field is required</p>');
				} else {
					$("#active").closest('.form-group').removeClass('has-error');
					$("#active").closest('.form-group').addClass('has-success');				
				}

				if(name && address && contact && active) {
					//submi the form to server
					$.ajax({
						url : form.attr('action'),
						type : form.attr('method'),
						data : form.serialize(),
						dataType : 'json',
						success:function(response) {

							// remove the error 
							$(".form-group").removeClass('has-error').removeClass('has-success');

							if(response.success == true) {
								$(".messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
								  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
								  '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
								'</div>');

								// reset the form
								$("#createMemberForm")[0].reset();		

								// reload the datatables
								manageKategoriTable.ajax.reload(null, false);
								// this function is built in function of datatables;

							} else {
								$(".messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
								  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
								  '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+response.messages+
								'</div>');
							}  // /else
						} // success  
					}); // ajax subit 				
				} /// if


				return false;
			}); // /submit form for create member
		}); // /add modal

	});
}