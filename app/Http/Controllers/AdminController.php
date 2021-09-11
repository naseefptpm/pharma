<?php

namespace App\Http\Controllers;

use App\Models\Employees;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;


class AdminController extends Controller
{
    public function AdminLog(){
    
        return view('profile.adminlogin');
        }

        public function UserLog(){
    
            return view('profile.userlogin');
            }

        public function AdminSignIn(Request $request){
            $employees = Employees::all();
            $email = $request->adminemail;
            $password = $request->adminpassword;

            if($email == "admin@gmail.com" && $password == "admin1234"){
                return view('admin.admindashboard',compact('employees'));

            } else {
                return Redirect()->back()->with('error','Your Email and Password is incorrect');

            }

        }  

        public function Logout(){
            Auth::logout();
            return Redirect()->route('user.log');
    
        }
        
        public function EmployeeStore(Request $request){

            $validateData =$request->validate([
                'attach' => 'required|mimes:jpg,jpeg,png,pdf',
        
             ]);
        
            $attach = $request->file('attach');
        
            $name_gen = hexdec(uniqid());
            $image_ext = strtolower($attach->getClientOriginalExtension());
            $img_name = $name_gen.'.'.$image_ext;
            $up_location = 'file/attach/';
            $last_img = $up_location.$img_name;
            $attach->move($up_location,$img_name);

            Employees::insert([
                'name' => $request->name,
                'department' => $request->department,
                'week' => $request->week,
                'work' => $request->work,            
                'attach' => $last_img,
               
        
                'created_at' => Carbon::now()
    
    
    
            ]);
    
            return Redirect()->back()->with('success','Record Inserted Successfully');
        }
      
        public function Edit($id){
            $employees = Employees::find($id);
            return view('admin.employeeedit', compact('employees'));
     
         }


         
    public function UpdateEmployee(Request $request, $id){
        $employees = Employees::all();

        $validateData =$request->validate([
            'attach' => 'required|mimes:jpg,jpeg,png,pdf',
    
         ]);
    
        $attach = $request->file('attach');
    
        $name_gen = hexdec(uniqid());
        $image_ext = strtolower($attach->getClientOriginalExtension());
        $img_name = $name_gen.'.'.$image_ext;
        $up_location = 'file/attach/';
        $last_img = $up_location.$img_name;
        $attach->move($up_location,$img_name);

        Employees::find($id)->update([
        
            'name' => $request->name,
            'department' => $request->department,
            'week' => $request->week,
            'work' => $request->work,            
            'attach' => $last_img,
           
    
            'created_at' => Carbon::now()

        ]);

       return view('admin.admindashboard',compact('employees'));
       //return Redirect()->route('admin.dash')->with('success', 'employee updated successfully');

    } 
    public function DeleteEmployee($id){

        Employees::find($id)->delete();

        return Redirect()->back()->with('success','Record Deleted Successfully');


    }

    public function SearchEmployee(){
    
        $search_text = $_GET['query'];
        $employees = Employees::where('name','LIKE', '%'.$search_text.'%')
        ->orWhere('department','LIKE', '%'.$search_text.'%')
        ->orWhere('week','LIKE', '%'.$search_text.'%')
        ->orWhere('work','LIKE', '%'.$search_text.'%')
        ->get();
        return view('admin.admindashboard',compact('employees'));



    }
    
}
