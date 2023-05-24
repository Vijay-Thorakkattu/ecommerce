<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['categories'] = Category::all();
        return view('admin.create_product',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
       

        $data['products'] = Product::select('products.*', 'categories.name as category_name')
        ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
        ->orderBy('products.id', 'desc')
        ->get();

        return view('admin.list_product',$data);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'name'=>'required',
            'catgeory_id' => 'required|integer',
            'amount' => 'required|numeric|min:0',
            'file' => 'mimes:jpeg,jpg,png,gif|required|max:10000'

        ], [
            'catgeory_id.required' => 'Category field is required.',
            'amount.required' => 'Price field is required.',
            'file.required' => 'Please select an image.',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
    
        $ins_result = array(
            'name'       =>$request->name,
            'category_id'=>$request->catgeory_id,
            'amount'=>$request->amount,
                    );

            if ($request->has('file')) {

                        $name = time().'_'.$request->file->getClientOriginalName();
                        $filePath = $request->file('file')->storeAs('uploads/image', $name, 'public');
                        $file_path = '/storage/' . $filePath;
            }
    
            if($file_path != ""){
                $ins_result['file_path']=$file_path;
                $ins_result['file_name']=$name;
            }
            
            Product::create($ins_result);
            Session::flash('success', 'Product saved successfully.');
            return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //

        $data['categories'] = Category::all();
        $data['product'] = Product::find($id);
        return view('admin.edit_product',$data);
        

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'name'=>'required',
            'catgeory_id' => 'required|integer',
            'amount' => 'required|numeric|min:0',
            

        ], [
            'catgeory_id.required' => 'Category field is required.',
            'amount.required' => 'Price field is required.',
           
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }


        $file_path = "";
        $name = "";
        if($request->has('file')) {
            if($request->file != ''){

                $get_data = Product::where('id',$id)->first();

                if($get_data->file_path != ""){
    
                    $filePath = $get_data->file_path;
    
                    if (file_exists(public_path($filePath))) {
                        unlink(public_path($filePath));
                    }

                    $name = time().'_'.$request->file->getClientOriginalName();
                    $filePath = $request->file('file')->storeAs('uploads/image', $name, 'public');
                     $file_path = '/storage/' . $filePath;

                }else{

                    $name = time().'_'.$request->file->getClientOriginalName();
                    $filePath = $request->file('file')->storeAs('uploads/image', $name, 'public');
                    $file_path = '/storage/' . $filePath;

                }

            }

            
        }

        $ins_result = array(
            'name'       =>$request->name,
            'category_id'=>$request->catgeory_id,
            'amount'=>$request->amount,
                    );

    
            if($file_path != ""){
                $ins_result['file_path']=$file_path;
                $ins_result['file_name']=$name;
            }
            
            Product::where('id',$id)->update($ins_result);
            Session::flash('success', 'Product updated successfully.');
            return redirect()->back(); 
                    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        Product::where('id',$id)->delete();
        Session::flash('success', 'Product deleted successfully.');
        return redirect()->back();
        
    }
}
