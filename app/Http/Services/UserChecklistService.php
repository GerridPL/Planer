<?php

namespace App\Http\Services;

use App\Models\UserChecklist;
use App\Models\UserPoint;
use Illuminate\Support\Facades\DB;

class UserChecklistService
{


    public static function getUserChecklist($checklistId, $user)
    {
        $userChecklist = UserChecklist::with('user_relation','company_relation',
            'checklist_category_relation','allocated_by_relation', 'file_relation',
            'global_checklist_relation')
            ->where('company', $user->company)
            ->where('user', $user->id)
            ->findOrFail($checklistId);
        return $userChecklist;
    }

    public static function getUserChecklists($user)
    {
        $userChecklists = UserChecklist::with('user_relation', 'checklist_category_relation',
            'allocated_by_relation', 'global_checklist_relation', 'company_relation')
            ->where('company', $user->company)
            ->where('user', $user->id)
            ->get();
        return $userChecklists;
    }

    public static function getCompanyUserChecklists($user, $checklistId)
    {
        $userChecklist = UserChecklist::with('user_relation', 'checklist_category_relation',
            'allocated_by_relation', 'global_checklist_relation', 'company_relation')
            ->where('company', $user->company)
            ->findOrFail($checklistId);
        return $userChecklist;
    }

    public static function getSubPointsFromChecklist($checklistId)
    {
        $checklistSubPoints = UserPoint::with('user_checklist_relation','user_point_relation')
            ->where('user_checklist', $checklistId)
            ->whereNotNull('user_point')
            ->get();
        return $checklistSubPoints;
    }

    public static function getPointsFromChecklist($checklistId)
    {
        $userPoints = UserPoint::with('user_checklist_relation', 'company_relation', 'user_point_relation')
            ->where('user_checklist', $checklistId)
            ->orderBy('index','asc')
            ->orderBy('subIndex','asc')
            ->get();

        return $userPoints;
    }

    public static function getUserPointByChecklistAndPointId($user, $checklistId, $pointId)
    {
        $point = UserPoint::with('company_relation', 'user_checklist_relation')
            ->where('company',$user->company)
            ->where('user_checklist',$checklistId)
            ->findOrFail($pointId);
        return $point;
    }

    public static function getChecklistsByGlobalChecklist($globalChecklistId)
    {
        $checklists = UserChecklist::with('user_relation')->where('global_checklist',$globalChecklistId)->get();
        return $checklists;
    }

    //Użytkownicy mający zadaną listę na podstawie listy globalnej
    public static function getUsersWithChecklist($user, $globalChecklistId)
    {
        $usersWithChecklist = DB::table('users')
            ->where('company',$user->company)
            ->whereExists(function ($query) use ($globalChecklistId) {
               $query->select(DB::raw(1))
                     ->from('user_checklists')
                     ->where('global_checklist',$globalChecklistId)
                     ->whereColumn('users.id', 'user_checklists.user');
           })
           ->get();
        return $usersWithChecklist;
    }

    public static function addCopyTextAfterName($companyUser, $checklist)
    {
        $userChecklists = UserChecklist::with('user_relation')->with('company_relation')->where('user', $companyUser->id)->get();
        foreach ($userChecklists as $list) {
            if ($list->name == $checklist->name) {
                $checklist->name = "$checklist->name Kopia";
            }
        }
    }
}
