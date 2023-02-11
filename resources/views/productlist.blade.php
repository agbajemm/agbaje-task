@if($products)
    {{ $sum = 0  }}
    @foreach($products as $product)
        <tr>
            <td>{{ $product->name }}</td>
            <td>{{ number_format($product->quantity )  }}</td>
            <td>{{  number_format($product->price) }}</td>
            <td>{{ ($product->total_value)?number_format($product->total_value):null }}</td>
            <td><a href='#' class='btn btn-success edit' data-id='{{ $product->id }}' data-name='{{ $product->name }}' data-quantity='{{ $product->quantity }}' data-price='{{ $product->price }}'> Edit</a>
                <a href='#' class='btn btn-danger delete' data-id='{{ $product->id }}'> Delete</a>
            </td>
        </tr>
        {{ $sum = $sum+$product->total_value }}
    @endforeach
    <tr>
        <td></td>
        <td></td>
        <td></td>
            <td style="font-weight: bold;">SUM: {{ number_format($sum)}}  </td>
        <td></td>
    </tr>

@endif
