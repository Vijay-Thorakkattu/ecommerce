<?php

namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\Quantity;
use App\Models\Product;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;


use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
       
        $data['products'] = Product::all();
        return view('admin.create_order',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
   
        $data['orders'] = Order::orderBy('created_at', 'desc')->get();
        return view('admin.list_order',$data);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

            $validator = Validator::make($request->all(), [
                'customer_name'=> 'required|max:255',
                'phone'=> 'required|numeric|digits_between:8,15',
                'quantity'=>'required'
            ], [
                'customer_name.required' => 'Customer field is required.',
            ]);
        
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }


        $currentDateTime = Carbon::now();
        $currentDateTimeString = $currentDateTime->format('Y-m-d H:i:s');
        $orderId = $this->generateUniqueCode(9);
        $ins_result = array(
                'customer_name' =>$request->customer_name,
                'phone'=>$request->phone,
                'order_date'=>$currentDateTimeString,
                'order_id'=>$orderId
                        );

        $order = Order::create($ins_result);

        $sum = 0;
        $totalPrice=0;

        if($request->productIDs){    
            foreach($request->productIDs as $key => $productID) {

                $qty = $request->quantity[$key];
                $productPrice = Product::where('id',$productID)->value('amount');

                $totalPrice = $qty * $productPrice;

                $sum += $totalPrice;

                $quantity = Quantity::create([

                    'order_id' =>$order->order_id,
                    'product_id'=>$productID,
                    'quantity'=>$qty,
                    'total_amount'=>$totalPrice

                ]);

                $order->update(['order_amount'=>$sum]);
            }
                        
        }


        Session::flash('success', 'Order Placed successfully.');
        return redirect()->back();

        

    }
  

    protected function generateUniqueCode($limit){

        $code ='';
        $limit = 5;

        for ($i=0; $i < $limit; $i++){
            $digit = ($i === 0) ? rand(1,9) : rand(0, 9);
            $code .= $digit;
        }

        return $code;
    }

   

  

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $order = Order::where('id',$id)->first();
        
        $quantity = Quantity::where('order_id',$order->order_id)
                            ->get();
        return view('admin.order_invoice',compact('order','quantity'));
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
       
        $products = Product::all();
        $order = Order::where('id',$id)->first();
        $quantity = Quantity::where('order_id',$order->order_id)
                            ->get();
        return view('admin.edit_order',compact('order','quantity','products'));

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
            'customer_name'=> 'required|max:255',
            'phone'=> 'required|numeric|digits_between:8,15',
            'quantity'=>'required'
        ], [
            'customer_name.required' => 'Customer field is required.',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $currentDateTime = Carbon::now();
        $currentDateTimeString = $currentDateTime->format('Y-m-d H:i:s');
        $ins_result = array(
                'customer_name' =>$request->customer_name,
                'phone'=>$request->phone,
                'order_date'=>$currentDateTimeString,
                        );


        $order = Order::where('id',$id)->first();
        Quantity::where('order_id',$order->order_id)->delete();
        $order->where('id',$id)->update($ins_result);

        $sum = 0;
        $totalPrice=0;

        if($request->productIDs){    
            foreach($request->productIDs as $key => $productID) {

                $qty = $request->quantity[$key];
                $productPrice = Product::where('id',$productID)->value('amount');

                $totalPrice = $qty * $productPrice;

                $sum += $totalPrice;

                $quantity = Quantity::create([

                    'order_id' =>$order->order_id,
                    'product_id'=>$productID,
                    'quantity'=>$qty,
                    'total_amount'=>$totalPrice

                ]);

                $order->update(['order_amount'=>$sum]);
            }
                        
        }

        Session::flash('success', 'Order Updated successfully.');
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

        $order = Order::where('id',$id)->first();
        $order->where('id',$id)->delete();
        Quantity::where('order_id',$order->order_id)->delete();
        Session::flash('success', 'Order deleted successfully.');
        return redirect()->back();

    }
}
