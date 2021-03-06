<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use App\Models\User;
use App\Models\Department;
use App\Models\Complaint;
use App\Models\Complaint_type;
use App\Models\Permission;
use App\Models\Tender;
use App\Models\Tender_section;
use Carbon\Carbon;

class StatisticsController extends Controller
{
    public function system()
    {
        $users['total'] = User::all()->count();
        foreach (Department::all() as $department) {
            $users['types'][$department->name] = Department::find($department->id)->users()->count();
        }

        $permissions['total'] = 0;
        foreach (Permission::all() as $permission) {
            $permissions['types'][$permission->name] = Permission::find($permission->id)->users()->count();
            $permissions['total'] +=  Permission::find($permission->id)->users()->count();
        }

        return view('admin/statistic/system', [
            'users' => json_encode($users),
            'permissions' => json_encode($permissions)
        ]);
    }

    public function detail_complaint($dates)
    {
        $date = explode(',', $dates);
        $data['total'] = Complaint::whereBetween('created_at', [$date[0], $date[1] . ' 23:59:59'])->count();
        $data['complaint_types'] = [];
        foreach (Complaint_type::all() as $complaint_type) {
            array_push($data['complaint_types'], (object) ['Type' => $complaint_type->name, "Amount" => Complaint_type::find($complaint_type->id)->complaints()->whereBetween('created_at', [$date[0], $date[1] . ' 23:59:59'])->count()]);
        }
        $data['date'] = Carbon::now();
        return $data;
    }

    public function business()
    {
        $advertisements['total'] = Advertisement::all()->count();
        $advertisements['types'] = [];
        $advertisements['types']["With link"] = Advertisement::where('link', '!=', '')->count();
        $advertisements['types']["Without link"] = $advertisements['total'] - $advertisements['types']["With link"];

        $tenders['total'] = Tender::all()->count();
        $tenders['types'] = [];
        foreach (Tender_section::orderBy('year', 'desc')->orderBy('number', 'asc')->get() as $tender_section) {
            $tenders['types'][$tender_section->get_name] = Tender_section::find($tender_section->id)->tenders()->count();
        }

        return view('admin/statistic/business', [
            'advertisements' => json_encode($advertisements),
            'tenders' => json_encode($tenders)
        ]);
    }
}
