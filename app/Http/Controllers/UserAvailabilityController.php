<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserAvailabilityRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserAvailabilityController extends Controller
{
    public function store(UserAvailabilityRequest $request)
    {
        $auth = auth()->user();

        $data = $auth->availabilities()->where('date', $request->date)->first();
        if ($data) {
            $data->delete();
        } else {
            $data = $auth->availabilities()->make();
            $data->date = $request->date;
            $data->available = false;
            $data->save();
        }

        if ($data) {
            if ($request->available == true) {
                $data->delete();
            } else {
                $data->update([
                    'date' => $request->date,
                    'available' => $request->available
                ]);
            }
        }

        return response()->json($data, 200);
    }

    public function updateAvailability(UserAvailabilityRequest $request)
    {
        $user = auth()->user();

        $date = Carbon::parse($request->date);

        $month = $date->month;
        $year = $date->year;

        $firstDayOfMonth = Carbon::createFromDate($year, $month, 1);

        //Get the number of days in selected month
        $daysInMonth = $firstDayOfMonth->daysInMonth;

        //Loop through all the days of the selected month
        for ($day = 1; $day <= $daysInMonth; $day++) {

            $currentDate = Carbon::createFromDate($year, $month, $day)->toDateString();

            if (request()->get('available') == false) {

                $data = $user->availabilities()->make();
                $data->date = $currentDate;
                $data->available = $request->available;
                $data->save();
            } else {
                $data = $user->availabilities()->where('date', $currentDate)->delete();

            }
        }

        return response()->json($data);
    }

    public function getUserAvailabilities()
    {
        $auth = auth()->user();

        $data = $auth->availabilities;

        return response()->json($data, 200);
    }

    public function getUsersAvailabilities($user_id)
    {
        $user = User::findOrFail($user_id);

        $data = $user->availabilities;

        return response()->json($data, 200);
    }
}
