<!doctype html>
<html lang="{{ str_replace("_", "-", app()->getLocale()) }}">
    <head>
        <link rel="stylesheet" type="text/css" href="{{ asset("css/app.css") }}">
    </head>
    <body>
        <h1>Data ID: {{ $id }}</h1>

        <div
            class="container"
            style="
                margin-top: 20px;
                padding: 20px;
                background-color: teal;
                border-radius: 10px;
                color: white;
            "
        >

	    <form class="col-md-4" action="{{ route("product.destroy", $id) }}" method="POST">
	        <div>

	            @csrf
	            @method("DELETE")

	        	<button class="btn btn-danger" type="submit">Delete</button>
		    </div>
	    </form>
	</body>


</html>
