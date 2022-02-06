<?php

namespace App\Http\Services;

use App\Models\GlobalPoint;
use App\Models\GlobalChecklist;

class GlobalChecklistService
{
    public static function getGlobalPoints($checklistId)
    {
        $globalPoints = GlobalPoint::with('checklist', 'master_point')
            ->where('checklist', $checklistId)
            ->get();
        return $globalPoints;
    }

    public static function getGlobalPoint($checklistId, $pointId)
    {
        $globalPoint = GlobalPoint::with('checklist', 'master_point')
            ->where('checklist', $checklistId)
            ->findOrFail($pointId);
        return $globalPoint;
    }

    public static function getGlobalPointsWhereIndex($checklistId, $pointIndex)
    {
        $globalPoint = GlobalPoint::with('checklist')
            ->where('checklist', $checklistId)
            ->where('index', $pointIndex)
            ->first();
        return $globalPoint;
    }

    public static function getGlobalPointByUserAndId($user, $pointId)
    {
        $globalPoint = GlobalPoint::with('checklist')
            ->with('master_point')
            ->where('company', $user->company)
            ->findOrFail($pointId);
        return $globalPoint;
    }

    public static function getGlobalChecklist($globalChecklistId, $user)
    {
        $checklist = GlobalChecklist::with('user', 'category')
            ->where('company', $user->company)
            ->findOrFail($globalChecklistId);
        return $checklist;
    }

    public static function getGlobalChecklistWithTrashed($globalChecklistId, $user)
    {
        $checklist = GlobalChecklist::with('user', 'category')
            ->where('company', $user->company)
            ->withTrashed()
            ->find($globalChecklistId);
        return $checklist;
    }

    public static function getGlobalChecklistFromUser($user)
    {
        $checklists = GlobalChecklist::with('user')
            ->where('company', $user->company)
            ->get();
        return $checklists;
    }

    public static function getAllGlobalChecklist($user)
    {
        $globalChecklists = GlobalChecklist::with('user', 'category')
            ->where('company', $user->company)
            ->get();
        return $globalChecklists;
    }

    public static function getAllGlobalChecklistWithTrashed($user)
    {
        $globalChecklists = GlobalChecklist::with('user', 'category')
            ->where('company', $user->company)
            ->withTrashed()
            ->get();
        return $globalChecklists;
    }
}
