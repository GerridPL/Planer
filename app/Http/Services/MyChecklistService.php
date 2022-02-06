<?php

namespace App\Http\Services;

use App\Models\UserChecklist;
use App\Models\UserPoint;

class MyChecklistService
{
    //Ustaw pierwszy index na aktywny
    public static function activeFirst($checklistId)
    {
        //Pobieram punkt lub punkty z index 1
        $minPoint = UserPoint::with('user_checklist_relation')
            ->where('user_checklist',$checklistId)
            ->where('index',1)
            ->get();

        //Sprawdzam czy nie podpunktów do punktu
        foreach($minPoint as $point)
        {
            if($point->subIndex==1)
            {
                $minSubPoint = UserPoint::with('user_checklist_relation')
                    ->where('user_checklist',$checklistId)
                    ->where('index',1)
                    ->where('subindex',1)
                    ->first();
                break;
            }
            $minSubPoint = $point;
        }
        $minSubPoint->active = 1;
        $minSubPoint -> save();
        return;
    }

    //Ustaw następny index na aktywny
    public static function activeNext($checklistId, $activatedPoint)
    {
        $lastIndex = $activatedPoint->index;
        $lastSubIndex = $activatedPoint->subIndex;
        //Dezaktywuje poprzedni punkt
        $activatedPoint->active = 0;
        $activatedPoint->save();
        //Pobieram wszystkie niezrealizowane punkty z indeksem takim jak ostatnio (ewentualne kolejne podpunkty).
        $samePoint = UserPoint::with('user_checklist_relation')
            ->where('confirmed',0)
            ->where('skiped',0)
            ->where('user_checklist',$checklistId)
            ->where('index',$lastIndex)
            ->get();
        //Jeżeli znalazło niezrealizowane punkty z takim samym indexem to wchodzi do pętli i szuka kolejnego indeksu subindexu
        if(count($samePoint) != 0)
        {
            foreach($samePoint as $point)
            {
                if($point->subIndex>$lastSubIndex)
                {
                    $nextSubPoint = $point;
                    break;
                }
                $nextSubPoint = $point;
            }
            //Ustawiam na aktywny
            $nextSubPoint->active = 1;
            //Zapisuję
            $nextSubPoint -> save();
            return;
        }

        //Pobieram pozostałe niezrealizowane punkty
        $elsePoints = UserPoint::with('user_checklist_relation')
            ->where('user_checklist',$checklistId)
            ->where('confirmed',0)
            ->where('skiped',0)
            ->get();

        //Sprawdzam czy lista nie jest zrealizowana.
        if(count($elsePoints) == 0)
        {
            return;
        }
        //Wybieram następny punkt, ale jeszcze go nie przypisuję.
        foreach($elsePoints as $point)
        {
            if($point->index = $lastIndex + 1)
            {
                $nextPoint = $point;
                break;
            }
            $nextPoint = $point;
        }
        //Szukam ewentualnych podpunktów wcześniej wyszukanego punktu
        $elseSubPoints = UserPoint::with('user_checklist_relation')
            ->where('user_checklist',$checklistId)
            ->where('index',$nextPoint->index)
            ->where('confirmed',0)
            ->where('skiped',0)
            ->get();

        //Sprawdzam czy nie ma podpunktów do punktu, jak nie to ustawiam punkt jako aktywny.
        foreach($elseSubPoints as $point)
        {
            if($point->subIndex==1)
            {
                $minSubPoint = $point;
                break;
            }
            $minSubPoint = $point;
        }

        //Ustawiam na aktywny
        $minSubPoint->active = 1;
        //Zapisuję
        $minSubPoint -> save();
        return;

    }

    public static function updatePercent($checklistId)
    {
        $userChecklist = UserChecklist::findOrFail($checklistId);
        $allPoints = UserPoint::with('user_checklist_relation')
            ->where('user_checklist',$checklistId)
            ->get();
        $confirmedPoints = UserPoint::with('user_checklist_relation')
            ->where('user_checklist',$checklistId)
            ->where('confirmed',1)
            ->get();
        $percent = (int)((count($confirmedPoints) / count($allPoints)) * 100);
        $userChecklist->realization = $percent;
        $userChecklist -> save();
    }
}
