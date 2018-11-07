<?php

namespace App\Http\Controllers;

use App\Building;
use App\Http\Resources\BuildingResource;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class BuildingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return BuildingResource::collection(
            QueryBuilder::for((Building::class)) 
                ->allowedFilters('name', 'levels')
                ->allowedIncludes('rooms')
                ->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|string|min:3|max:255",
            "description" => "nullable|string|max:1000",
            "levels" => "required|integer|min:0",
        ]);

        return new BuildingResource(Building::create($request->input()));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Building  $building
     * @return \Illuminate\Http\Response
     */
    public function show(Building $building)
    {
        return new BuildingResource(
            QueryBuilder::for((Building::where('id', $building->id)))
                ->allowedIncludes('rooms')
                ->first()
        );

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Building  $building
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Building $building)
    {
        $request->validate([
            "name" => "nullable|string|min:3|max:255",
            "description" => "nullable|string|max:1000",
            "levels" => "nullable|integer|min:0",
        ]);

        $building->fill($request->input());
        $building->save();

        return new BuildingResource($building);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Building  $building
     * @return \Illuminate\Http\Response
     */
    public function destroy(Building $building)
    {
        \App\Room::where("building_id", $building->id)->delete();
        $building->delete();

        return response()->json('Building deleted', 200);
    }
}
