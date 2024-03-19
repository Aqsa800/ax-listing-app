<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ListingResource;
use App\Models\Listing;

class ListingController extends Controller
{
    public function index(Request $request)
    {
        $columns = ['id', 'title', 'price', 'type'];

        // Start with total records count equal to total listings
        $totalRecords = Listing::count();

        // Apply pagination
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);

        $listings = Listing::query();

        // Apply filters
        if ($request->filled('filters')) {
            $filters = json_decode($request->input('filters'), true);
            foreach ($filters as $filter) {
                $attribute = $filter['attribute'];
                $operator = $filter['operator'];
                $value = $filter['value'];

                // Handle filtering based on the attribute
                switch ($attribute) {
                    case 'portal':
                        // If the attribute is 'portal', filter based on related portals
                        switch ($operator) {
                            case 'equals':
                                $listings->whereHas('portals', function ($query) use ($value) {
                                    $query->where('name', $value);
                                });
                                break;
                            case 'not_equals':
                                $listings->whereDoesntHave('portals', function ($query) use ($value) {
                                    $query->where('name', $value);
                                });
                                break;
                            case 'contains':
                                $listings->whereHas('portals', function ($query) use ($value) {
                                    $query->where('name', 'like', "%$value%");
                                });
                                break;
                            case 'starts_with':
                                $listings->whereHas('portals', function ($query) use ($value) {
                                    $query->where('name', 'like', "$value%");
                                });
                                break;
                            case 'ends_with':
                                $listings->whereHas('portals', function ($query) use ($value) {
                                    $query->where('name', 'like', "%$value");
                                });
                                break;
                            case 'is':
                                $listings->whereHas('portals', function ($query) use ($value) {
                                    $query->where('name', $value);
                                });
                                break;
                            case 'is_not':
                                $listings->whereDoesntHave('portals', function ($query) use ($value) {
                                    $query->where('name', '!=', $value);
                                });
                                break;
                        }
                        break;
                    case 'bed':
                        // If the attribute is 'portal', filter based on related portals
                        switch ($operator) {
                            case 'equals':
                                $listings->whereHas('bedroomData', function ($query) use ($value) {
                                    $query->where('name', $value);
                                });
                                break;
                            case 'not_equals':
                                $listings->whereDoesntHave('bedroomData', function ($query) use ($value) {
                                    $query->where('name', $value);
                                });
                                break;
                            case 'contains':
                                $listings->whereHas('bedroomData', function ($query) use ($value) {
                                    $query->where('name', 'like', "%$value%");
                                });
                                break;
                            case 'starts_with':
                                $listings->whereHas('bedroomData', function ($query) use ($value) {
                                    $query->where('name', 'like', "$value%");
                                });
                                break;
                            case 'ends_with':
                                $listings->whereHas('bedroomData', function ($query) use ($value) {
                                    $query->where('name', 'like', "%$value");
                                });
                                break;
                            case 'is':
                                $listings->whereHas('bedroomData', function ($query) use ($value) {
                                    $query->where('name', $value);
                                });
                                break;
                            case 'is_not':
                                $listings->whereDoesntHave('bedroomData', function ($query) use ($value) {
                                    $query->where('name', '!=', $value);
                                });
                                break;
                        }
                        break;
                    case 'bath':
                        // If the attribute is 'portal', filter based on related portals
                        switch ($operator) {
                            case 'equals':
                                $listings->whereHas('bathroomData', function ($query) use ($value) {
                                    $query->where('name', $value);
                                });
                                break;
                            case 'not_equals':
                                $listings->whereDoesntHave('bathroomData', function ($query) use ($value) {
                                    $query->where('name', $value);
                                });
                                break;
                            case 'contains':
                                $listings->whereHas('bathroomData', function ($query) use ($value) {
                                    $query->where('name', 'like', "%$value%");
                                });
                                break;
                            case 'starts_with':
                                $listings->whereHas('bathroomData', function ($query) use ($value) {
                                    $query->where('name', 'like', "$value%");
                                });
                                break;
                            case 'ends_with':
                                $listings->whereHas('bathroomData', function ($query) use ($value) {
                                    $query->where('name', 'like', "%$value");
                                });
                                break;
                            case 'is':
                                $listings->whereHas('bathroomData', function ($query) use ($value) {
                                    $query->where('name', $value);
                                });
                                break;
                            case 'is_not':
                                $listings->whereDoesntHave('bathroomData', function ($query) use ($value) {
                                    $query->where('name', '!=', $value);
                                });
                                break;
                        }
                        break;
                    case 'id':
                    case 'title':
                    case 'price':
                    case 'type':
                        switch ($operator) {
                            case 'equals':
                                $listings->where($attribute, $value);
                                break;
                            case 'not_equals':
                                $listings->where($attribute, '!=', $value);
                                break;
                            case 'contains':
                                $listings->where($attribute, 'like', "%$value%");
                                break;
                            case 'starts_with':
                                $listings->where($attribute, 'like', "$value%");
                                break;
                            case 'ends_with':
                                $listings->where($attribute, 'like', "%$value");
                                break;
                            case 'is':
                                $listings->where($attribute, $value);
                                break;
                            case 'is_not':
                                $listings->where($attribute, '!=', $value);
                                break;
                        }
                        break;
                    default:
                        break;
                }
            }
        }

        // Get the count of filtered records
        $filteredRecordsCount = $listings->count();

        // Handle ordering
        if ($request->has('order')) {
            $orderColumn = $request->input('order.0.column');
            $orderDirection = $request->input('order.0.dir');
            $listings->orderBy($columns[$orderColumn], $orderDirection);
        }

        // Apply pagination and get filtered data
        $listings = ListingResource::collection($listings->skip($start)->take($length)->get());

        // Return JSON response with updated totalRecords and filteredRecordsCount
        return response()->json([
            'draw' => $request->input('draw', 1),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecordsCount,
            'data' => $listings,
        ]);
    }
}
