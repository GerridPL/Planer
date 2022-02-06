<?php

namespace App\Http\Controllers;

use App\Models\UserChecklist;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    public function index()
    {
        return view('calendar.index');
    }

    public function getChecklists($id)
    {
        $user = Auth::user();
        $checklists = UserChecklist::where('user', $user->id)
            ->where('status',$id)
            ->get();
        $calendarChecklist = array();
        foreach($checklists as $checklist){
            $calendarChecklist[] = array(
                'title' => $checklist->name,
                'start'=>$checklist->term,
                'end'=>$checklist->term
            );
        }
        return response()->json($calendarChecklist);
    }
}
