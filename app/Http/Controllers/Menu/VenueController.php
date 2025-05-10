<?php

namespace App\Http\Controllers\Menu;

use App\Http\Controllers\Controller;
use App\Http\Requests\Menu\VenueRequest;
use App\Models\OptionCategory;
use App\Models\Venue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class VenueController extends Controller
{
    public function index()
    {
        $venues = Venue::with(['tiers', 'venueGallery', 'category'])->latest()->get();
        $categories = OptionCategory::where('status', 'active')->get();
        return view('menu.venues', compact('venues', 'categories'));
    }

    public function store(VenueRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::user()->id;

        $venue = Venue::create($data);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('venue_images', 'public');
                $venue->venueGallery()->create([
                    'venue_id' => $venue->venue_id,
                    'image_name' => $path,
                ]);
            }
        }

        if (!empty($data['tiers'])) {
            foreach ($data['tiers'] as $tier) {
                $venue->tiers()->create([
                    'user_id' => Auth::user()->id,
                    'max_pax' => $tier['max_pax'],
                    'price' => $tier['price'],
                    'included_overnight_pax' => $tier['included_overnight_pax'] ?? 0,
                ]);
            }
        }

        return redirect()->route('venues')->with('success', 'Venue created successfully.');
    }

    public function update(VenueRequest $request, Venue $venue)
    {
        $data = $request->validated();

        $venue->update($data);

        if ($request->hasFile('images')) {
            foreach ($venue->venueGallery as $image) {
                Storage::disk('public')->delete($image->image_name);
                $image->delete();
            }

            foreach ($request->file('images') as $image) {
                $path = $image->store('venue_images', 'public');
                $venue->venueGallery()->create([
                    'venue_id' => $venue->venue_id,
                    'image_name' => $path,
                ]);
            }
        }

        if (!empty($data['tiers'])) {
            $existingTierIds = $venue->tiers->pluck('pricing_tier_id')->toArray();

            foreach ($data['tiers'] as $tier) {
                if (isset($tier['id']) && in_array($tier['id'], $existingTierIds)) {
                    $venue->tiers()->where('pricing_tier_id', $tier['id'])->update([
                        'max_pax' => $tier['max_pax'],
                        'price' => $tier['price'],
                        'included_overnight_pax' => $tier['included_overnight_pax'] ?? 0,
                    ]);
                } else {
                    $venue->tiers()->create([
                        'user_id' => Auth::user()->id,
                        'max_pax' => $tier['max_pax'],
                        'price' => $tier['price'],
                        'included_overnight_pax' => $tier['included_overnight_pax'] ?? 0,
                    ]);
                }
            }

            $tierIdsToKeep = array_column($data['tiers'], 'id');
            $venue->tiers()->whereNotIn('pricing_tier_id', $tierIdsToKeep)->delete();
        }

        return redirect()->route('venues')->with('success', 'Venue updated successfully.');
    }

    public function destroy(Venue $venue)
    {
        foreach ($venue->venueGallery as $image) {
            Storage::disk('public')->delete($image->image_name);
        }
        
        $venue->delete();

        return redirect()->route('venues')->with('success', 'Venue deleted successfully.');
    }
}
