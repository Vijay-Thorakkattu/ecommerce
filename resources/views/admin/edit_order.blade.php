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
            <div class="row justify-content-center mt-5">
                <h4 class="text-center">Edit Order</h4>
            </div>
            <div class="row mt-2">
                <form enctype="multipart/form-data" method="post" action="{{route('orders.update',['order' => $order->id])}}">
                @csrf
                @method('PUT')
                @if (Session::has('success'))
                <div class="alert alert-success">
                    {{ Session::get('success') }}
                </div>
                @endif
                @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <div class="mb-3 row">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Customer name *</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="customer_name" id="inputPassword" placeholder="customer Name"   value={{$order->customer_name}} required >
                    </div>
                    @error('customer_name')
                            <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3 row">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Phone *</label>
                    <div class="col-sm-10">
                      <input type="number" class="form-control" name="phone" id="inputPassword" placeholder="Customer Phone" value={{$order->phone}} required>
                    </div>
                    @error('phone')
                            <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group row mt-2">
                    <label for="inputPassword" class="col-sm-2 col-form-label" required>Product *</label>
                    <div class="col-sm-10">
                        <div class="form-group">
                            <select class="form-control"  id="product_id" required>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('product_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 row mt-2">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Quantity *</label>
                    <div class="col-sm-10">
                      <input type="number" class="form-control"  id="quantity" value="1" placeholder="Quantity" required>
                      @error('quantity')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="mt-6">
                    <button type="button" onclick="addQuantity()" class="btn btn-primary">
                        Add
                    </button>
                </div>
                <div class="mt-6">
                    <div>
                        <table class="table float-right col-sm-6 col-form-label">									
                            <tbody id="stock_values" >
                                @foreach($quantity as $qty )
                                <tr class="mt-2">
                                <td><input type="hidden" name="productIDs[]" value="{{$qty->product->id}}" >{{$qty->product->name}}</td>
                                <td><input type="hidden" name="quantity[]" value="{{floatval($qty->quantity)}}" >{{floatval($qty->quantity)}}- Qty</td>
                                <td><button class="px-3 py-1 btn btn-success" onclick="remove(this)">Close</button></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="mb-3 row mt-2">
                    <div class="col-sm-12">
                      <button type="submit" class="btn btn-primary" style="float:right">Save</button>
                    </div>
                </div>
                </form>
            </div>
            
    </body>
</html>

<script>
    function addQuantity(){
        var stock = document.getElementById('quantity').value;
        selectElement = document.querySelector('#product_id');
        var productID = selectElement.options[selectElement.selectedIndex].value;
        var productName = selectElement.options[selectElement.selectedIndex].text;			
        var tbody = document.getElementById('stock_values');			 
        tbody.innerHTML +='<tr class="mt-2"><td><input type="hidden" name="productIDs[]" value="'+productID+'" >'+productName+'</td><td><input type="hidden" name="quantity[]" value="'+stock+'">'+stock+'- Qty</td><td><button class="px-3 py-1 btn btn-success" onclick="remove(this)">Close</button></td></tr>';
    }

    function remove(btnremove) {               
            btnremove.parentNode.parentNode.remove();
    }
</script>
