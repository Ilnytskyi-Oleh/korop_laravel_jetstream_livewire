<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreListingRequest;
use App\Http\Requests\UpdateListingRequest;
use App\Models\Category;
use App\Models\City;
use App\Models\Color;
use App\Models\Listing;
use App\Models\Size;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ListingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {

        $listings = Listing::with(['categories', 'sizes', 'colors', 'user.city'])
            ->when(request('title'), function ($query){
                $query->where('title', 'LIKE', '%'.request('title').'%');
            })
            ->when(request('category'), function ($query){
                $query->whereHas('categories', function ($q2){
                    $q2->where('id', request('category'));
                });
            })
            ->when(request('size'), function ($query){
                $query->whereHas('sizes', function ($q2){
                    $q2->where('id', request('size'));
                });
            })
            ->when(request('color'), function ($query){
                $query->whereHas('colors', function ($q2){
                    $q2->where('id', request('color'));
                });
            })
            ->when(request('city'), function ($query){
                $query->whereHas('user.city', function ($q2){
                    $q2->where('id', request('city'));
                });
            })
            ->when(request('saved'), function ($query){
                $query->whereHas('savedUsers', function ($q2){
                    $q2->where('id', auth()->id());
                });
            })
            ->paginate(3)->withQueryString();


        $categories = Category::lazy();
        $sizes = Size::lazy();
        $colors = Color::lazy();
        $cities = City::orderBy('name')->lazy();

        return view('listings.index', compact('listings', 'categories', 'sizes', 'colors', 'cities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $categories = Category::lazy();
        $colors = Color::lazy();
        $sizes = Size::lazy();

        return view('listings.create', compact('categories', 'colors', 'sizes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreListingRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreListingRequest $request)
    {
        $listing = auth()->user()->listings()->create($request->validated());

        for($i=1; $i<=3; $i++){
            if($request->hasFile('photo'. $i)){
                $listing->addMediaFromRequest('photo'.$i)->toMediaCollection('listings');
            }
        }

        $listing->categories()->attach($request->categories);
        $listing->colors()->attach($request->colors);
        $listing->sizes()->attach($request->sizes);

        return redirect()->route('listings.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Listing  $listing
     * @return \Illuminate\Http\Response
     */
    public function show(Listing $listing)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Listing  $listing
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Listing $listing)
    {
        $this->authorize('update', $listing);
        $listing->load('categories');
        $listing->load('colors');
        $listing->load('sizes');

        $media = $listing->getMedia('listings');

        $categories =  Category::all();
        $colors =  Color::all();
        $sizes =  Size::all();

        return view('listings.edit', compact('listing', 'media', 'categories', 'colors', 'sizes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateListingRequest  $request
     * @param  \App\Models\Listing  $listing
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateListingRequest $request, Listing $listing)
    {
        $this->authorize('update', $listing);

        $listing->update($request->validated());

        for($i=1; $i<=3; $i++){
            if($request->hasFile('photo'. $i)){
                $listing->addMediaFromRequest('photo'.$i)->toMediaCollection('listings');
            }
        }

        $listing->categories()->sync($request->categories);
        $listing->colors()->sync($request->colors);
        $listing->sizes()->sync($request->sizes);

        return redirect()->route('listings.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Listing  $listing
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Listing $listing)
    {
        $this->authorize('delete', $listing);

        $listing->delete();

        return redirect()->route('listings.index');
    }

    public function deletePhoto($listingsId, $photoId)
    {
        $listing = Listing::where('user_id', auth()->id())->findOrFail($listingsId);
        $photo = $listing->getMedia('listings')->where('id', $photoId)->first();
        $photo?->delete();
        return redirect()->route('listings.edit', $listingsId);
    }
}
