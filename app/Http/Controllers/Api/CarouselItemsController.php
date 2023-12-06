<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\CarouselItems;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\CarouselItemsRequest;

class CarouselItemsController extends Controller
{
    /**
     * Display a listing of the resource with page or keyword.
     */
    public function index(Request $request)
    {
        // Show data based on logged user
        $carouselItems = CarouselItems::where('user_id', $request->user()->id);

        // Cater Search use "keyword"
        if ($request->keyword) {
            $carouselItems->where(function ($query) use ($request) {
                $query->where('carousel_name', 'like', '%' . $request->keyword . '%')
                    ->orWhere('description', 'like', '%' . $request->keyword . '%');
            });
        }

        // Paginate based on number set; You can change the number below
        return $carouselItems->paginate(3);
        
        // Show all data; Uncomment if necessary
        // return CarouselItems::all();
    }

    /**
     * Display all listing of the resource.
     */
    public function all(Request $request)
    {
        return CarouselItems::where('user_id', $request->user()->id)
                                ->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CarouselItemsRequest $request)
    {
        $validated = $request->validated();

        $validated['image_path'] = $request->file('image_path')->storePublicly('carousel', 'public');

        $carouselItem = CarouselItems::create($validated);

        return $carouselItem;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return CarouselItems::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CarouselItemsRequest $request, string $id)
    {
        $validated = $request->validated();

        // Upload image to backend and store image path
        $validated['image_path'] = $request->file('image_path')->storePublicly('carousel', 'public');

        // Get info by id
        $carouselItem = CarouselItems::findOrFail($id);

        // Delete previous image
        if ( !is_null($carouselItem->image_path) ){
            Storage::disk('public')->delete($carouselItem->image_path);
        }

        // Update new info
        $carouselItem->update($validated);

        return $carouselItem;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $carouselItem = CarouselItems::findOrFail($id);

        if ( !is_null($carouselItem->image_path) ){
            Storage::disk('public')->delete($carouselItem->image_path);
        }

        $carouselItem->delete();

        return $carouselItem;
    }

}
