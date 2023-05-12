<?php

namespace App\Http\Controllers;

use App\Exports\LabSheetExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Lab;
use App\User;
use App\Rider;
use Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\Response;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class LabController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::guest()) {
            //is a guest so redirect
            return redirect('/auth-login');
        }
        if (Gate::allows('isSuperAdmin')) {
            try {
                //code...
                $labs = Lab::orderBy('created_at', 'desc')->paginate(20);
                return view('pages.user.manage_lab')->with('labs', $labs);
            } catch (\Throwable $th) {
                //throw $th;
                return redirect()->back()->with(['error' => 'An error occur while loading this page']);
            }
        } else {
            return Response::deny('You must be a super administrator.');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::guest()) {
            //is a guest so redirect
            return redirect('/auth-login');
        }
        if (Gate::allows('isSuperAdmin')) {
            $role = 4;
            $Admins = User::where('role_id', $role)->orderBy('created_at', 'desc')->get();
            return view('pages.user.create_lab')->with('admins', $Admins);
        } else {
            return Response::deny('You must be a super administrator.');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'fullname' => 'required|max:50',
            'email' => 'required|email',
            'phoneNumber' => 'required|numeric',
            'state' => 'required',
            'country' => 'required',
            'address' => 'required',
            'region' => 'required',
            'city' => 'required',
            'admin' => 'required',
        ]);

        $data = $request->only(['fullname', 'email', 'phoneNumber', 'state', 'country', 'address', 'region', 'city', 'admin']);
        // Check if lab already exist
        if (Lab::where('email', $data['email'])->exists()) {
            return back()->with(['error' => ' Email already exist!']);
        } else {
            // Get rider id
            $admin = User::where('fullname', $data['admin'])->firstOrFail();
            $admin_id = $admin->id;
            $lab = new Lab();
            $lab->uuid = Uuid::uuid4();
            $lab->fullname = $data['fullname'];
            $lab->email = $data['email'];
            $lab->phoneNumber = $data['phoneNumber'];
            $lab->state = $data['state'];
            $lab->country = $data['country'];
            $lab->address = $data['address'];
            $lab->region = $data['region'];
            $lab->city = $data['city'];
            $lab->admin_id = $admin_id;
            $lab->save();
            // Redirect
            return redirect('/manage-lab')->with(['success' => ' lab successfully created.']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Lab  $lab
     * @return \Illuminate\Http\Response
     */
    public function show(lab $lab)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Lab  $lab
     * @return \Illuminate\Http\Response
     */
    public function edit($uuid)
    {
        if (Auth::guest()) {
            //is a guest so redirect
            return redirect('/auth-login');
        }
        if (Gate::allows('isSuperAdmin')) {
            try {
                //code...
                $labs = Lab::all();
                $riders = Rider::all();
                $lab = Lab::where('uuid', $uuid)->first();
                return view('pages.user.edit_lab', compact(['lab', $lab, 'labs', $labs, 'riders', $riders]));
            } catch (\Throwable $th) {
                //throw $th;
            }
        } else {
            return Response::deny('You must be a super administrator.');
        }
    }

    public function editLabDetials($uuid)
    {
        if (Auth::guest()) {
            //is a guest so redirect
            return redirect('/auth-login');
        }
        if (Gate::allows('isSuperAdmin')) {
            try {
                //code...
                $labs = Lab::all();
                $riders = Rider::all();
                $lab = Lab::where('uuid', $uuid)->with('admin')->first();
                $role = 4;
                $admins = User::where('role_id', $role)->orderBy('created_at', 'desc')->get();
                return view('pages.user.edit_lab_details', compact(['lab', $lab, 'labs', $labs, 'riders', $riders, 'admins', $admins]));
            } catch (\Throwable $th) {
                //throw $th;
            }
        } else {
            return Response::deny('You must be a super administrator.');
        }
    } //end method editLabDetails

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Lab  $lab
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $uuid)
    {
        $this->validate($request, [
            'fullname' => 'required|max:50',
            'email' => 'required|email',
            'phoneNumber' => 'required|numeric',
            'state' => 'required',
            'country' => 'required',
            'address' => 'required',
            'region' => 'required',
            'city' => 'required',
            'admin' => 'required',
        ]);

        $lab = Lab::where('uuid', $uuid)->first();

        if ($lab == null) return back()->with('error', "Lab not found");

        $data = $request->only(['fullname', 'email', 'phoneNumber', 'state', 'country', 'address', 'region', 'city', 'admin']);
        // Check if lab already exist
        if ($lab->email !== $data['email'] && Lab::where('email', $data['email'])->exists()) {
            return back()->with(['error' => ' Email already exist!']);
        } else {
            // Get rider id
            $admin = User::where('fullname', $data['admin'])->firstOrFail();
            $admin_id = $admin->id;
            $lab->fullname = $data['fullname'];
            $lab->email = $data['email'];
            $lab->phoneNumber = $data['phoneNumber'];
            $lab->state = $data['state'];
            $lab->country = $data['country'];
            $lab->address = $data['address'];
            $lab->region = $data['region'];
            $lab->city = $data['city'];
            $lab->admin_id = $admin_id;
            $lab->save();
            // Redirect
            return redirect("/edit-lab/{$uuid}")->with(['success' => ' lab successfully updated.']);
        }
    } //end method update

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Lab  $lab
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'uuid' => 'required|uuid'
        ]);
        $lab = Lab::where('uuid', $request->uuid)->first();

        if ($lab == null)
            return back()->with('error', "Lab not found");

        $lab->forceDelete();

        return redirect()->route('manage.lab')->with('success', 'Lab deleted.');
    }
    public function downloadLabExportSheet()
    {
        return Excel::download(new LabSheetExport, 'labSheet.xlsx');
    } //end method downloadLabExportSheet
}
