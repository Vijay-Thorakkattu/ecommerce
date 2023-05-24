<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

        <!-- Styles -->       
    </head>
    <body class="antialiased">
        <div class="container">
            <div class="row mt-3">
                <div class="col-sm-12">
                    <a href="{{ url("/orders/create") }}" class="btn btn-info">Back</a>
                </div>
            </div>
            <div class="card mt-5">
                <div class="card-body">
            <div class="row justify-content-center mt-5">
                <h4 class="text-center">Invoice</h4>
            </div>
            <div class="row mt-2">
                <table class="table table-striped">
                    <thead>
                    <tbody>
                        <tr>
                            <td>Order Id</td>
                            <td>{{$order->order_id}}</td>
                        </tr>
                        <tr>
                            <td>Product</td>
                            <td>
                                
                                @foreach ($quantity as $qty)
                                <p>{{$qty->product->name}} x {{floatval($qty->quantity)}} = {{$qty->total_amount}}</p>
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <td>Total</td>
                            <td>{{$order->order_amount}}&nbsp;/-</td>
                        </tr>
                    </tbody>
                  </table>

            </div>
        </div>
    </div>
            
    </body>
</html>
