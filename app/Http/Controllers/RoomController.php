<?php

namespace App\Http\Controllers;

use App\Room;
use App\Building;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Resources\RoomResource;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Building $building)
    {
        return RoomResource::collection(
            QueryBuilder::for(Room::where('building_id', $building->id))
                ->allowedIncludes('building')
                ->allowedFilters('name', 'seats', 'windows')
                ->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Building $building)
    {
        $request->validate([
            "name" => "required|string|min:3|max:255",
            "seats" => "nullable|integer|min:0",
            "windows" => "required|boolean"
        ]);

        $room = new Room($request->input());
        $room->building_id = $building->id;
        $room->save();

        return new RoomResource($room);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function show(Building $building, Room $room)
    {
        return new RoomResource(
            QueryBuilder::for(Room::where('id', $room->id))
                ->allowedFilters('name', 'seats', 'windows')
                ->first()
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Building $building, Room $room)
    {
        $request->validate([
            "name" => "string|min:3|max:255",
            "seats" => "nullable|integer|min:0",
            "windows" => "boolean",
        ]);
        
        $room->fill($request->input());
        $room->save();

        return new RoomResource($room);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function destroy(Building $building, Room $room)
    {
        $room->delete();

        return response()->json('Room deleted',200);
    }
}
