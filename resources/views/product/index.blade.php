<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        
    </head>
    <body>
        This is product list

        <br><br>

        <a href="{{ route('product.show', 1) }}">detail product1</a><br>
        <a href="{{ route('product.show', 2) }}">detail product2</a><br>
        <a href="{{ route('product.show', 3) }}">detail product3</a><br>
        <a href="{{ route('product.show', 4) }}">detail product4</a><br>

        <br>

        <a href="{{ route('product.create') }}">create new product</a>


        <br>
        <br>
        <br>


        <ul>
            @foreach ($data as $key => $value)
                @if ($key === "age")
                    @continue
                @endif

                <li>{{ $loop->iteration }}) {{ $key }} = {{ $value }}</li>
            @endforeach
        </ul>

    </body>


</html>
