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
                <a href="{{ url('/') }}" class="btn btn-info">Back</a>
            </div>
          </div>
            <div class="row justify-content-center mt-5">
                <h4 class="text-center">List Product</h4>
            </div>
            <div class="row mt-2">
                <table class="table table-striped">
                    <thead>
                      <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Product name</th>
                        <th scope="col">Category</th>
                        <th scope="col">Price</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        @php $i = 1; @endphp
                        @foreach($products as $product)
                      <tr>
                        <th scope="row">{{$i++}}</th>
                        <td>{{$product->name}}</td>
                        <td>{{$product->category_name}}</td>
                        <td>{{$product->amount}}</td>
                        <td>
                            <a class="btn btn-primary" href="{{ route('products.edit', ['product' => $product->id]) }}">Edit</a>
                            <form action="{{route('products.destroy',['product' => $product->id])}}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                              </form>
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>

            </div>
            
    </body>
</html>
