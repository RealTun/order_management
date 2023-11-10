<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\Order_details;
use App\Models\Type_Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $orders = Order::orderBy("updated_at", "desc")->paginate(5);
        return view("orders.index", compact("orders"))->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $type = Type_Product::all();
        $product = Product::all();
        // dd($product_type->product);
        // $product = DB::table("type_product")
        // ->join("products","products.ma_loai","=","type_product.ma_loai")
        // ->get();
        return view("orders.add", compact("product", 'type'));
    }

    public function getSelectType(Request $request)
    {
        $selectedType = $request->input('selectedType');
        $selectedProduct = $request->input('selectedProduct');

        $options = Product::where('ma_loai', $selectedType)->select('ma_sp', 'ten_sp', 'donvi', 'dongia')->get();
        $product = Product::where('ma_sp', $selectedProduct)->select('donvi', 'dongia')->first();
        // Return the options as a JSON response
        return response()->json(['options' => $options, 'product' => $product]);
    }

    public function getSelectProduct(Request $request)
    {
        $selectedValue = $request->input('selectedValue');

        $product = Product::where('ma_sp', $selectedValue)->select('donvi', 'dongia')->first();
        // Return the options as a JSON response
        return response()->json(['product' => $product]);
    }

    public function addRow(Request $request)
    {
        $order_id = $request->input('order_id');
        $product_id = $request->input('product_id');
        $quantity = $request->input('quantity');

        $exist =  Order_details::where('ma_hoadon', $order_id)
            ->where('ma_sp', $product_id)
            ->exists();
        if ($exist) {
            Order_details::where('ma_hoadon', $order_id)
            ->where('ma_sp', $product_id)
            ->update([
                'soluong'=> Order_details::where('ma_hoadon', $order_id)
                            ->where('ma_sp', $product_id)->value('soluong') + $quantity,
            ]);
        } 
        else {
            Order_details::create([
                'ma_hoadon' => $order_id,
                'ma_sp' => $product_id,
                'soluong' => $quantity
            ]);
        }
        
        return response()->json(['success' => 'Cập nhật hoá đơn thành công']);
    }

    public function saveTable(Request $request)
    {
        $row = $request->input('row');
        $customer = $request->input('customer');
        $id_product = $request->input('id_product');
        $table = session()->get('table', []);
        session()->forget('customer');

        if (isset($table[$id_product])) {
            $table[$id_product]['quantity'] += $row[3];
        } else {
            $table[$id_product] = [
                "type" => $row[0],
                "product_name" => $row[1],
                "unit" => $row[2],
                "quantity" => $row[3],
                "price" => $row[4],
                "total" => $row[5],
            ];
        }
        session()->put("table", $table);
        session()->put("customer", $customer);
        return redirect()->back();
    }

    public function remove(Request $request)
    {
        $id_product = $request->input('id_product');
        $table = session()->get('table');
        if (isset($table[$id_product])) {
            unset($table[$id_product]);
            session()->put('table', $table);
        }
    }
    public function store(Request $request)
    {
        $validateData = Validator::make($request->only(['tenkh', 'diachi', 'dienthoai']), [
            'tenkh' => 'required|regex:/^[\p{L} \p{Mn}\p{Pd}]+$/u',
            'diachi' => 'required',
            'dienthoai' => 'required|numeric',
        ]);

        $orders = session()->get('table', []);
        if (empty($orders)) {
            return redirect()->back()->with('error', 'Vui lòng thêm sản phầm cần bán!');
        }

        if ($validateData->passes()) {
            Order::create([
                'ten_hoadon' => "test",
                'ten_kh' => $request->tenkh,
                'diachi' => $request->diachi,
                'dienthoai' => $request->dienthoai,
            ]);
            $id = Order::orderBy('ma_hoadon', 'desc')->value('ma_hoadon');

            foreach ($orders as $product_id => $details) {
                Order_details::create([
                    'ma_hoadon' => $id,
                    'ma_sp' => $product_id,
                    'soluong' => $details['quantity'],
                ]);
            }
            session()->flush();
            return redirect()->route('orders.index')->with('success', 'Thêm mới hoá đơn thành công');
        }
        return redirect()->back()->with('errors', $validateData->errors()->all());
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $order = DB::table('order_details')
            ->join('orders', 'orders.ma_hoadon', '=', 'order_details.ma_hoadon')
            ->join('products', 'order_details.ma_sp', '=', 'products.ma_sp')
            ->join('type_product', 'products.ma_loai', '=', 'type_product.ma_loai')
            ->where('orders.ma_hoadon', $id)
            ->get();
        $order_customer = DB::table('orders')->where('ma_hoadon', $id)->first(['ma_hoadon', 'ten_kh', 'diachi', 'dienthoai']);
        return view('orders.details', compact('order', 'order_customer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $type = Type_Product::all();
        $product = Product::all();
        $order = DB::table('order_details')
            ->join('orders', 'orders.ma_hoadon', '=', 'order_details.ma_hoadon')
            ->join('products', 'order_details.ma_sp', '=', 'products.ma_sp')
            ->join('type_product', 'products.ma_loai', '=', 'type_product.ma_loai')
            ->where('orders.ma_hoadon', $id)
            ->get();

        $order_customer = DB::table('orders')->where('ma_hoadon', $id)->first(['ma_hoadon', 'ten_kh', 'diachi', 'dienthoai']);
        return view('orders.edit', compact('order', 'order_customer', 'type', 'product'));
    }

    public function updateOrderProduct(Request $request)
    {
        $order_id = $request->input('order_id');
        $product_id = $request->input('product_id');
        $quantity = $request->input('quantity');

        Order_details::where('ma_hoadon', $order_id)
            ->where('ma_sp', $product_id)
            ->update([
                'ma_sp' => $product_id,
                'soluong' => $quantity,
            ]);
        return response()->json(['success' => 'Update quantity successful']);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $orders = $request->input('orders');
        $order_id = $request->input('order_id');
        //
        $validateData = Validator::make($request->only(['tenkh', 'diachi', 'dienthoai']), [
            'tenkh' => 'required',
            'diachi' => 'required',
            'dienthoai' => 'required|numeric',
        ]);

        if ($validateData->passes()) {
            $order = Order::find($order_id);
            $order->update([
                'ten_kh' => $request->tenkh,
                'diachi' => $request->diachi,
                'dienthoai' => $request->dienthoai,
            ]);
            foreach ($orders as $order) {
                Order_details::create([
                    'ma_hoadon' => $order_id,
                    'ma_sp' => $order[0],
                    'soluong' => $order[1],
                ]);
            }
            return response()->json(['success' => 'Update order successful']);
        }
        return response()->json(['error' => $validateData->errors()->all()]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $order = Order::find($id);
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Delete order successfully');
    }

    public function deleteRow(Request $request)
    {
        $order_id = $request->input('order_id');
        $product_id = $request->input('product_id');
        Order_details::where('ma_sp', $product_id)
            ->where('ma_hoadon', $order_id)
            ->delete();
        return response()->json(['success' => 'Update order successful']);
    }
}
