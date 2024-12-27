<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DailyAttendance;
use App\Models\Staff;
use App\Models\StaffMember;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('staffs.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('staffs.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:120',
            'phone' => 'required|unique:staffs,phone',
        ]);

        $fileName = '';
        if ($request->hasFile('image')) {
            $fileName = fileUpload('staffs', $request->image);
        }

        $createStaff = new Staff();
        $createStaff->image = $fileName;
        $createStaff->type = $request->type;
        $createStaff->is_leader = $request->staff_leader;
        $createStaff->role = $request->role;
        $createStaff->name = $request->name;
        $createStaff->phone = $request->phone;
        $createStaff->email = $request->email;
        $createStaff->address = $request->address;
        $createStaff->salary = $request->type == 1 ? $request->salary : null;
        $createStaff->rate_per_day = $request->type == 2 ? $request->rate_per_day : null;
        if($request->joining_date != null) {
            $createStaff->joining_date = date('Y-m-d', strtotime($request->joining_date));
        }
        if($request->resign_date != null) {
            $createStaff->resign_date = date('Y-m-d', strtotime($request->resign_date));
        }
        $createStaff->save();

        if($request->staff_leader == 1 && $request->team_name != null) {

            foreach($request->team_name as $key => $teamname) {

                if(isset($request->team_name[$key]) && $request->team_name[$key] != '') {

                    $createTeam = StaffMember::create([
                        'staff_id' => $createStaff->id,
                        'name' => $request->team_name[$key],
                        'role' => $request->team_role[$key],
                        'join_date' => $request->team_joindate[$key] != null ? date('Y-m-d', strtotime($request->team_joindate[$key])) : null,
                        'end_date' => $request->team_enddate[$key] != null ? date('Y-m-d', strtotime($request->team_enddate[$key])) : null
                    ]);
                }
            }
        }

        if($createStaff) {
            return redirect()->route('staffs.index')->with(['success' => true, 'message' => 'Staff added successfully!']);
        } else {
            return redirect()->route('staffs.index')->with(['error'  => true, 'message' => 'Something went wrong!']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $Staff = Staff::where('id', $id)->first();
        $data['staff'] = $Staff;

        $teamMembers = StaffMember::where('staff_id', $id)->get();
        $data['teamMembers'] = $teamMembers;

        return view('staffs.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|max:120',
            'phone' => 'required|unique:staffs,phone,' . $id,
        ]);

        $updateStaff = Staff::where('id', $id)->first();
        $updateStaff->type = $request->type;
        // $updateStaff->is_leader = $request->staff_leader;
        $updateStaff->role = $request->role;
        $updateStaff->name = $request->name;
        $updateStaff->phone = $request->phone;
        $updateStaff->email = $request->email;
        $updateStaff->address = $request->address;
        $updateStaff->salary = $request->type == 1 ? $request->salary : null;
        $updateStaff->rate_per_day = $request->type == 2 ? $request->rate_per_day : null;
        if($request->joining_date != null) {
            $updateStaff->joining_date = date('Y-m-d', strtotime($request->joining_date));
        }
        if($request->resign_date != null) {
            $updateStaff->resign_date = date('Y-m-d', strtotime($request->resign_date));
        }
        $updateStaff->save();

        if($request->hasFile('image')){
            $staff = Staff::where('id', $id)->first();
            if(isset($staff->image) && $staff->image != null) {
    
                $fileName = fileUpload('staffs', $request->image, $staff->image);
    
            } else {
    
                $fileName = fileUpload('staffs', $request->image);
            }
            $staff->image = $fileName;
            $staff->save();
        }

        if($updateStaff) {
            return redirect()->route('staffs.index')->with(['success' => true, 'message' => 'Staff updated successfully!']);
        } else {
            return redirect()->route('staffs.index')->with(['error'  => true, 'message' => 'Something went wrong!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $deleteStaff = Staff::where('id', $id)->delete();

        if($deleteStaff) {
            return response()->json(['status' => true, 'message' => 'Success', 'data' => []], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Error', 'data' => []], 201);
        }
    }

    public function getTable(Request $request) {

        $type = $request->type;

        $query = Staff::orderBy('id', 'desc');

        if(isset($type) && $type != 0) {
            $query->where('type', $type);
        }

        $staffs = $query->get();
        $data['staffs'] = $staffs;
        return View::make('staffs.Ajax.table', $data);
    }

    public function teams($id) {

        $data['leader_id'] = $id;

        $teamMembers = StaffMember::where('staff_id', $id)->get();
        $data['teamMembers'] = $teamMembers;

        return view('staffs.teams', $data);
    }

    public function getAttendance(Request $request) {

        $leader_id = $request->leader_id;
        $date = $request->date;
        $type = $request->type;

        $query = DailyAttendance::with(['staff', 'staffMember'])->where('attendance_date', $date);
                if ($leader_id) {
                    $query->where('staff_id', $leader_id);
                    $leader = Staff::where('id', $leader_id)->where('is_leader', 1)->first();
                    $data['leader'] = $leader;
                }
                if ($type) {
                    $query->whereHas('staff', function ($query) use ($type) {
                        $query->where('type', $type);
                    });
                }
        $dailyAttendances = $query->get();

        $data['dailyAttendances'] = $dailyAttendances;
        $data['date'] = $date;
        $data['type'] = $type;

        return View::make('staffs.Ajax.attendance_table', $data);
    }

    public function getDailyAttendence(Request $request) {

        $leaders = Staff::where('is_leader', 1)->pluck('name', 'id')->toArray();
        $data['leaders'] = $leaders;

        return View::make('staffs.daily_attendance', $data);
    }

    public function addAttendence(Request $request) {

        $staffId = $request->staff_id;
        $staffMemberId = $request->staff_member_id;
        $status = $request->status;
        $date = date('Y-m-d');

        $attendence = DailyAttendance::where([['staff_id', $staffId], ['staff_member_id', $staffMemberId], ['attendance_date', $date]])->first();

        if($attendence) {
            $attendence->attendance_date = $date;
            $attendence->status = $status;
            $attendence->save();
        } else {
            
            $attendence = new DailyAttendance();
            $attendence->attendance_date = $date;
            $attendence->staff_id = $staffId;
            $attendence->staff_member_id = $staffMemberId;
            $attendence->status = $status;
            $attendence->save();
        }

        if($attendence) {
            return response()->json(['success' => true, 'message' => 'Attendance added successfull', 'data' => []], 200);
        } else {
            return response()->json(['error' => true, 'message' => 'Something went wrong', 'data' => []], 201);
        }
    }

    public function attendanceHistory() {

        $members = StaffMember::select('name', 'id', 'staff_id')->get();
        $data['members'] = $members;

        $leaders = Staff::where('is_leader', 1)->pluck('name', 'id')->toArray();
        $data['leaders'] = $leaders;

        return view('staffs.attandance_history', $data);
    }

    public function getAttendanceHistory(Request $request) {

        $startDate = $request->startdate;
        $endDate = $request->enddate;
        $leader_id = $request->leader_id;
        $staff_member = $request->staff_member;

        $dates = [];
        $currentDate = strtotime($endDate); // Start from the end date

        while ($currentDate >= strtotime($startDate)) { // Loop until reaching the start date
            $dates[] = date('Y-m-d', $currentDate); // Add current date to the array
            $currentDate = strtotime('-1 day', $currentDate); // Move to the previous day
        }

        $attendanceQuery = DailyAttendance::whereIn('attendance_date', $dates);
        $membersQuery = StaffMember::orderBy('id', 'DESC');

        if($staff_member != '') {
            $attendanceQuery->where('staff_member_id', $staff_member);
            $membersQuery->where('id', $staff_member);
        }

        if($leader_id != '') {
            $attendanceQuery->where('staff_id', $leader_id);
            $membersQuery->where('staff_id', $leader_id);
        }

        $dailyAttendance = $attendanceQuery->get();
        $members = $membersQuery->get();

        $attendanceData = [];
        foreach ($dailyAttendance as $attendance) {
            // Convert staff_member_id and attendance_date to string or another suitable type
            $memberId = (string)$attendance->staff_member_id;
            $date = date('Y-m-d', strtotime($attendance->attendance_date));

            // Use the converted values as array keys
            $attendanceData[$date][$memberId] = $attendance->status;
        }

        $data['attendanceData'] = $attendanceData;
        $data['dates'] = $dates;
        $data['members'] = $members;

        return View::make('staffs.Ajax.history_table', $data);
    }

    public function staffMemberCreate(Request $request) {

        $request->validate([
            'name' => 'required|max:120',
            'joining_date' => 'required'
        ]);

        $staff_id = $request->staff_id;

        $createTeam = StaffMember::create([
            'staff_id' => $staff_id,
            'name' => $request->name,
            'role' => $request->role,
            'join_date' => $request->joining_date != null ? date('Y-m-d', strtotime($request->joining_date)) : null,
            'end_date' => $request->resign_date != null ? date('Y-m-d', strtotime($request->resign_date)) : null
        ]);

        if($createTeam) {
            return redirect()->route('staff.teams', $staff_id)->with(['success' => true, 'message' => 'Staff member added successfully!']);
        } else {
            return redirect()->route('staff.teams', $staff_id)->with(['error'  => true, 'message' => 'Something went wrong!']);
        }
    }

    public function staffMemberUpdate(Request $request, $id) {

        $request->validate([
            'name' => 'required|max:120',
            'joining_date' => 'required'
        ]);

        $staff_id = $request->staff_id;
    
        $updateTeam = StaffMember::where('id', $id)->update([
            'name' => $request->name,
            'role' => $request->role,
            'join_date' => $request->joining_date != null ? date('Y-m-d', strtotime($request->joining_date)) : null,
            'end_date' => $request->resign_date != null ? date('Y-m-d', strtotime($request->resign_date)) : null
        ]);

        if($updateTeam) {
            return redirect()->route('staff.teams', $staff_id)->with(['success' => true, 'message' => 'Staff member updated successfully!']);
        } else {
            return redirect()->route('staff.teams', $staff_id)->with(['error'  => true, 'message' => 'Something went wrong!']);
        }
    }

    public function staffMemberDelete(string $id) {

        $deleteStaffMember = StaffMember::where('id', $id)->delete();

        if ($deleteStaffMember) {
            return response()->json(['status' => true, 'message' => 'Success', 'data' => []], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Error', 'data' => []], 201);
        }
    }

    public function generateAttendancePdf(Request $request) {
        
        $reportrange = $request->reportrange;
        $startDate = null;
        $endDate = null;
        if ($reportrange != '') {
            $reportrangeAr = explode(' - ', $reportrange);
            $startDate = $reportrangeAr[0];
            $endDate = $reportrangeAr[1];
        }

        $leader_id = $request->leader_id;
        $staff_member = $request->staff_member;

        $dates = [];
        $currentDate = strtotime($endDate);

        while ($currentDate >= strtotime($startDate)) {
            $dates[] = date('Y-m-d', $currentDate);
            $currentDate = strtotime('-1 day', $currentDate);
        }

        $attendanceQuery = DailyAttendance::with('staff')->whereIn('attendance_date', $dates);
        $membersQuery = StaffMember::orderBy('id', 'DESC');

        if($staff_member) {
            $attendanceQuery->where('staff_member_id', $staff_member);
            $membersQuery->where('id', $staff_member);
        }

        if($leader_id) {
            $attendanceQuery->where('staff_id', $leader_id);
            $membersQuery->where('staff_id', $leader_id);
            $leader = Staff::where('is_leader', 1)->where('id', $leader_id)->first();
            $data['leader'] = $leader;
        }

        $dailyAttendance = $attendanceQuery->get();
        $members = $membersQuery->get();

        $attendanceData = [];
        $staffTotal = [];
        $total = 0;
        foreach ($dailyAttendance as $attendance) {
            // Convert staff_member_id and attendance_date to string or another suitable type
            $memberId = (string)$attendance->staff_member_id;
            $date = date('Y-m-d', strtotime($attendance->attendance_date));

            if (!isset($staffTotal[$memberId])) {
                $staffTotal[$memberId] = 0;
            }

            if($attendance->status == 0) {
                $staffTotal[$memberId] += $attendance->staff->rate_per_day;
            }
            if($attendance->status == 2) {
                $staffTotal[$memberId] += $attendance->staff->rate_per_day / 2;
            }

            // Use the converted values as array keys
            $attendanceData[$date][$memberId] = $attendance->status;
        }

        $total = array_sum($staffTotal);
        $data['total'] = $total;

        $data['attendanceData'] = $attendanceData;
        $data['dates'] = $dates;
        $data['members'] = $members;
        $data['from'] = date('d-m-Y', strtotime($startDate));
        $data['to'] = date('d-m-Y', strtotime($endDate));
        $data['staffTotal'] = $staffTotal;

        $pdf = PDF::loadView('staffs.Pdf.attendance', $data);
        return $pdf->download('attendance_report.pdf');

        // return View::make('reports.Pdf.plant', $data);
        // return $pdf->stream();
    }
}
