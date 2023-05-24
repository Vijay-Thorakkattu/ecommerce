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
                    <a href="{{ url("/products/create") }}" class="btn btn-info">Back</a>
                </div>
            </div>
            <div class="row justify-content-center mt-5">
                <h4 class="text-center">Edit Product</h4>
            </div>
            <div class="row mt-2">
                <form enctype="multipart/form-data" action="{{ route('products.update', ['product' => $product->id]) }}" method="POST">
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
                    <label for="inputPassword" class="col-sm-2 col-form-label">Product name *</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="name" id="inputPassword" value={{$product->name}} placeholder="Product Name">
                      @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Image *</label>
                    <div class="col-sm-10">
                      <input class="form-control" type="file" name="file"  accept="image/gif, image/jpeg, image/png" id="formFile" required>
                      <img class="input-fields-style card-img-top mt-2" src="{{ asset($product->file_path) }}" alt="Card image cap" style="width: 200px;">
                      @error('file')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row mt-2">
                    <label for="inputPassword" class="col-sm-2 col-form-label" required>Category *</label>
                    <div class="col-sm-10">
                        <div class="form-group">
                            <select class="form-control" id="exampleFormControlSelect1" name="catgeory_id" required>
                                <option value="" disabled selected>- select -</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ $category->id == $product->category_id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('catgeory_id')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="mb-3 row mt-2">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Price *</label>
                    <div class="col-sm-10">
                      <input type="number" class="form-control" name="amount" id="inputPassword" value={{$product->amount}} placeholder="Price" required>
                      @error('amount')
                      <span class="text-danger">{{ $message }}</span>
                    @enderror
                    </div>
                </div>
                <div class="mb-3 row">
                    <div class="col-sm-12">
                      <button type="submit" class="btn btn-primary" style="float:right">Update</button>
                    </div>
                </div>
                </form>
            </div>
            
    </body>
</html>
