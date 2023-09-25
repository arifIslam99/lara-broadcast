<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductDetails;
use App\Notifications\Alert;
use App\Models\User;

class ProductController extends Controller
{
    public function index(){
        return view('product');
    }

    public function uploads(Request $request)
    {
        // $path = storage_path('tmp/uploads');
        //$path = storage_path('app/public/images');
        $path = public_path('images');
        !file_exists($path) && mkdir($path, 0777, true);
        $file = $request->file('file');
        //$name = uniqid() . '_' . trim($file->getClientOriginalName());
        $name = $file->getClientOriginalName();
        $file->move($path, $name);
        return response()->json([
            'name' => $name,
            'original_name' => $file->getClientOriginalName(),
        ]);
    }

    public function store(Request $request)
    {
        $created = Product::create(['title' => $request->product_name, 'price' => $request->price, 'discription' => $request->product_details]);
        foreach ($request->input('document', []) as $file) {
            //your file to be uploaded insert to database
            ProductDetails::create(['product_id' => $created->id, 'photo' => $file]);
        }
        if ($created) { // inserted success
            $user=User::find(2);
            $message['title']="File Created";
            $message['alert']="Product created successfully...!";
            $user->notify(new Alert($message));
            return redirect()->route('product.create')
            ->withSuccess('Created successfully...!');
            // return back()->with('message','Created successfully...!');
            //  flash()->addInfo('Created successfully...!');
        }
        return redirect()
            ->back()
            ->withInput()
            ->with('error', 'fails not created..!');
    }

    public function fileDestroy(Request $request)
    {
        //$path = storage_path('app/public/images/') . $request->filename;
        $path = public_path() . '/images/' . $request->filename;
        if (file_exists($path)) {
            ProductDetails::where('photo', $request->filename)->delete();
            unlink($path);
        }
        return $request->filename;
    }
}
