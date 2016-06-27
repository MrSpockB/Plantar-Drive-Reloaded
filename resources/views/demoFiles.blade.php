<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Demo Multiple Files</title>
	<link rel="stylesheet" href="{{ asset('lib/css/dropzone.css') }}">
	<link rel="stylesheet" href="{{ asset('lib/css/basic.css') }}">
</head>
<body>
	<form action="{{ url('upload') }}" method="POST" class="dropzone" id="dropFiles">
		<div class="fallback">
			<input type="file" name="archivos[]" multiple>
		</div>
	    <input type="hidden" name="_token" value="{{ csrf_token() }}">
	</form>
	<script src="{{ asset('lib/js/dropzone.js') }}"></script>
	<script>
		var ids = [];
		Dropzone.options.dropFiles = {
			paramName: "file",
			success: function()
			{
				this.on("success", function(file, res){console.log(res);ids.push(res.id)});
			}
		};
	</script>
</body>
</html>