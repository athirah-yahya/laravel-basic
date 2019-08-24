<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        
    </head>
    <body>
        This is product list

        <br><br>

        <ul>
            @foreach ($data as $item)
                detail product {{ $item["id"] }} 
                <a href="{{ route('product.edit', $item["id"]) }}">EDIT</a>
                <a href="{{ route('product.show', $item["id"]) }}">SHOW</a><br>
            @endforeach
        </ul>

        <br>

        <a href="{{ route('product.create') }}">create new product</a>


        <br>
        <br>
        <br>


    </body>


</html>
