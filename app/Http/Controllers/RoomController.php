<?php

namespace App\Http\Controllers;
use App\Room;
use App\Building;
use App\Http\Resources\RoomResource;
use Illuminate\Http\Request;

class RoomController extends Controller{
 public function index(Building $building){
  return RoomResource::collection(
  $rooms = Room::where('building_id', $building->id)
  );
 }

 public function show(Building $building, Room $room){
  return new RoomResource(
    $room
  );
 }


 public function store(Request $request, Building $building){
  $request->validate([
   "name" => "required|string|min:3|max:255",
   "seats" => "nullable|integer|min:0",
   "windows" => "required|boolean",
  ]);

  $room = new Room($request->input());
  $room->building_id = $building->id;
  $room->save();
  return new RoomResource($room);
 }

 public function destroy(Building $building, Room $room){
  $room->delete();

  return response()->json('Room deleted', 200);
 }

public function update(Request $request, Building $building, Room $room){
  $request->validate([
   "name" => "string|min:3|max:255",
   "seats" => "nullable|integer|min:0",
   "windows" => "boolean",
  ]);

  $room->fill($request->input());
  $room->save();

  return new RoomResource($room);
 }
}