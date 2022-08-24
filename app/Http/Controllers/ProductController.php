<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Image as ModelsImage;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

use function GuzzleHttp\Promise\queue;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        // $category = Category::find()
        return view('products.index', compact(['products']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $authorized_user = Auth::user();
        // Gate::authorize('user-create', [$authorized_user]);
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validation
        $request->validate([
            'name' => ['required',],
            'description' => ['required',],
            'price' => ['required', 'numeric'],
            'category_id' => ['required'],
            'image' => ['required', 'file:jpg,jpeg,png',],
        ]);


        // Creating new product
        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id,
        ]);

        if ($request->hasFile('image')) {
            // Достанем с блейда новый ImageUpload
            $image =  $request->file('image');
            $path = $image->store('products/original');

            // Создадим запись в images
            $preview_image = Image::make($image)->fit(100, 100);
            $full_image = Image::make($image)->fit(800, 500);

            $preview_name =  $image->hashName();
            $full_name =  $image->hashName();

            $image_note = ModelsImage::create(
                [
                    'original_image' => $path,
                    'preview_image' => 'products/previews/' . $preview_name,
                    'full_image' => 'products/full/' . $full_name,
                    'product_id' => $product->id,
                ]
            );

            // Сохраним файлы
            $preview_image->save(storage_path('app/public/products/previews/' . $preview_name));
            $full_image->save(storage_path('app/public/products/full/' . $full_name));
        }

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        $category = Category::find($product->category_id);
        return view('products.show', compact(['product', 'category']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);
        $categories = Category::all();
        return view('products.edit', compact(['product', 'categories']));
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
        $product = Product::find($id);

        // Validating product
        $request->validate([
            'name' => ['required',],
            'description' => ['required',],
            'price' => ['required', 'numeric'],
            'category_id' => ['required'],
            'image' => ['required', 'file:jpg,jpeg,png',],
        ]);

        // Updating product
        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id,
        ]);

        // Updating new image
        if ($request->hasFile('image')) {

            // Удалим старые изображения
            Storage::delete($product->image->original_image);
            Storage::delete($product->image->full_image);
            Storage::delete($product->image->preview_image);

            // Достанем с блейда новый ImageUpload
            $image =  $request->file('image');
            $path = $image->store('products/original');

            // Создадим запись в images
            $preview_image = Image::make($image)->fit(100, 100);
            $full_image = Image::make($image)->fit(800, 500);

            $preview_name = 'prev_' . $image->hashName();
            $full_name = 'full_' . $image->hashName();

            $image_note = $product->image->update(
                [
                    'original_image' => $path,
                    'preview_image' => 'products/previews/' . $preview_name,
                    'full_image' => 'products/full/' . $full_name,
                    'product_id' => $product->id,
                ]
            );


            // Сохраним новые 
            $preview_image->save(storage_path('app/public/products/previews/' . $preview_name));
            $full_image->save(storage_path('app/public/products/full/' . $full_name));
        }

        // View
        return redirect()->route('products.index')->with('success', 'Product updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        Storage::delete($product->image->original_image);
        Storage::delete($product->image->full_image);
        Storage::delete($product->image->preview_image);
        $product->image()->delete();
        $product->delete();
        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully');
    }
}
