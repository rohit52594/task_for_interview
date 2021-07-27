<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Task</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>

<body>
	<div class="container" style="margin-top: 5em;">
		<form action="" method="post" id="formData">
			<div class="row">
				<div class="col-sm-4">
					<label for="name">Name: </label>
					<input class="form-control" type="text" name="name" id="name" required />
				</div>
				<div class="col-sm-4">
					<label for="email">Email ID: </label>
					<input class="form-control" type="email" name="email" id="email" required>
				</div>
				<div class="col-sm-4">
					<label for="phone">Phone No: </label>
					<input class="form-control" type="text" pattern="[6789]{1}[0-9]{9}" maxlength="10" name="phone" id="phone" required>
				</div>
			</div>

			<div class="row mt-3">
				<div class="col-sm-4">
					<label for="image">Image: </label>
					<input class="form-control" type="file" name="image" id="image" required>
				</div>
			</div>

			<div class="row mt-3">
				<div class="col-sm-12">
					<center>
						<button class="btn btn-info" type="submit">Submit</button>
					</center>
				</div>
			</div>
		</form>
		<table class="mt-4 table table-responsive" style="margin-top: 5em;">
			<thead>
				<tr>
					<td>S.No.</td>
					<td>Name</td>
					<td>Email ID</td>
					<td>Phone No</td>
					<td>Image</td>
				</tr>
			</thead>
			<tbody id="tableElem">
			</tbody>
		</table>
	</div>
</body>

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script>
	$("form#formData").on("submit", function(e) {
		e.preventDefault(e)
		e.stopPropagation();
		var formData = new FormData();
		formData.append('name', $('#name').val())
		formData.append('email', $('#email').val())
		formData.append('phone', $('#phone').val())
		console.log($('#image')[0].files[0])
		formData.append('image_link', $('#image')[0].files[0])
		$.ajax({
			url: '<?= base_url('index.php/welcome/submitForm'); ?>',
			data: formData,
			processData: false,
			contentType: false,
			method: 'post',
			success: function(response) {
				$('#formData')[0].reset();
				refreshTable()
			},
			error: function(err) {
				console.log(err);
			}
		});
	});

	const refreshTable = () => {
		$.ajax({
			url: '<?= base_url('index.php/welcome/refresh'); ?>',
			method: 'get',
			dataType: 'json',
			beforeSend: function() {
				$('#tableElem').html('fetching data...')
			},
			success: function(response) {
				$('#tableElem').html(response.table)
			}
		});
	};
</script>

</html>