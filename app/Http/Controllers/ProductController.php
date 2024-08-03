<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Size;
use App\Services\PaginateAndFilter;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = PaginateAndFilter::applyFilters(Product::class, 'name');
        return response()->json(PaginateAndFilter::response($query), Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:50'],
            'description' => ['required', 'max:255'],
            'price' => ['required', 'numeric', 'min:0', 'not_in:0'],
            'sizes_names' => ['required', 'array', 'each' => ['required', 'char', 'in:PP,P,M,G,GG,XG,XGG']],
            'sizes' => ['required', 'array', 'each' => ['required', 'integer'],],
        ]);

        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'rating' => 0,
            'images' => 'https://encrypted-tbn1.gstatic.com/shopping?q=tbn:ANd9GcSqLlSyCbzV4zhkXkyptnI3TwLnZX0rzxdWY30RhsSGp3hA8uyRNWWYiIMRywH2KUy5ozt6PoSAWw_k6IFDdWtLPpZh1JLB_wZYvZd2kJXSoJyuDLxF7w6O&usqp=CAE',
        ]);
        // Associar tamanhos ao produto com quantidade
        if (sizeOf($request->sizes_names) == sizeof($request->sizes)) {
            $sizes = collect($request->sizes_names)->mapWithKeys(function ($sizeName, $index) use ($request) {
                $size = Size::select('id', 'name')->where('name', $sizeName)->first();
                return [$size->id => ['quantity' => $request->sizes[$index]]];
            });

            $product->sizes()->sync($sizes);

            // Carregar os tamanhos associados ao produto
            $product->load('sizes');
            return response()->json(['message' => 'Product created successfully', 'data' => $product], Response::HTTP_CREATED);
        }
        return response()->json(['message' => 'Error associating sizes to product'], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => ['required', 'max:50'],
            'description' => ['required', 'max:255'],
            'price' => ['required', 'numeric', 'min:0', 'not_in:0'],
            'sizes_names' => ['required', 'array', 'each' => ['required', 'char', 'in:PP,P,M,G,GG,XG,XGG']],
            'sizes' => ['required', 'array', 'each' => ['required', 'integer'],],
        ]);
        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'sizes_names' => $request->sizes_names,
            'sizes' => $request->sizes,
        ]);
        $product->load('sizes');
        return response()->json(['message' => 'Produto ' . $id . ' atualizado com sucesso!', 'data' => $product], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
