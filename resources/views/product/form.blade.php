<!doctype html>
<html lang="{{ str_replace("_", "-", app()->getLocale()) }}">
    <head>
        <link rel="stylesheet" type="text/css" href="{{ asset("css/app.css") }}">
    </head>
    <body>
        <h1>{{ $title }}</h1>

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
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            <div class="row">
                <form class="col-md-4" action="{{ route($actionRouteName, $id ?? null) }}" method="POST">
                    <div>

                        @csrf

                        @isset($data)
                            @method("PUT")
                        @endisset

                    	<div class="form-group">
                            <label>sku</label>
                	        <input
                                class="form-control"
                                name="sku"
                                placeholder="sku"
                                value="{{ old("sku", $data["sku"] ?? "") }}"
                            />
                	   	</div>

                        <div class="form-group">
                            <label>name</label>
                            <input
                                class="form-control"
                                name="name"
                                placeholder="name"
                                value="{{ old("name", $data["name"] ?? "") }}"
                            />
                        </div>

                        <div class="form-group">
                            <label>stock</label>
                            <input
                                class="form-control"
                                type="number"
                                step="1"
                                min="0"
                                name="stock"
                                placeholder="stock"
                                value="{{ old("stock", $data["stock"] ?? 0) }}"
                            />
                        </div>

                        <div class="form-group">
                            <label>price</label>
                            <input
                                class="form-control"
                                type="number"
                                step="1000"
                                min="0"
                                name="price"
                                placeholder="price"
                                value="{{ old("price", $data["price"] ?? 0) }}"
                            />
                        </div>

                        <div class="form-group">
                            <label>description</label>
                            <textarea
                                class="form-control"
                                name="description"
                                placeholder="description"
                            >{{ old("description", $data["description"] ?? "") }}</textarea>
                        </div>
                    </div>

            	   	<button class="btn btn-success" type="submit">{{ $buttonTitle }}</button>
               </form>
            </div>
        </div>

    </body>


</html>
