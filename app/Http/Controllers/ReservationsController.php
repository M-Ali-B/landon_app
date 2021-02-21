<?php

namespace App\Http\Controllers;

use App\Client;
use App\Reservation;
use App\Room;
use Illuminate\Http\Request;

class ReservationsController extends Controller
{
    //
    public function bookRoom($client_id,$room_id,$date_in,$date_out)
    {
        $client_instance = new Client();
        $reservation_instance = new Reservation();
        $room_instance = new Room();

        $client = $client_instance->find($client_id);
        $room = $room_instance->find($room_id);

        $reservation_instance->date_in = $date_in;
        $reservation_instance->date_out = $date_out;

        $reservation_instance->room()->associate($room);
        $reservation_instance->client()->associate($client);
        if($room->isRoomBooked($room_id,$date_in,$date_out))
        {
            abort(405, 'trying to book same room again');
        }
        $reservation_instance->save();

        return redirect()->route('clients');
        return view('reservations/bookRoom');
    }
}
