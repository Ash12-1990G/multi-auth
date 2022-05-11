<?php

namespace App\Http\Controllers\Admin\Notifications;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\PostNotice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Notification;
use Yajra\DataTables\Facades\DataTables;

class NotificationController extends Controller
{
    public function index(Request $request){
        // $data = Auth::user()->notifications()->latest()->get();
        // foreach($data as $item){
        //     dd($item->data);
        // }
        
        if(request()->ajax()){
            return self::getDatatable();
        };
        
        return view('admin.notifications.index');
    }

    public function getDatatable(){
        $data = Auth::user()->notifications()->get();
        $user = auth()->user();
        return DataTables::of($data)
        ->addIndexColumn()
        ->editColumn('subject', function($row)  {
            if($row->type=='App\Notifications\FailedJobsNotice'){
                return '<p class="text-primary" >Registration Mail Failure</p>';
            }
            else if($row->type=='App\Notifications\PostNotice'){
                return '<p class="text-primary" >'.$row->data['subject'].'</p>';
            }
            return '<p class="text-primary" > </p>';
        })
        ->editColumn('message', function($row) {
            return $row->data['message'];
        })
        
        ->editColumn('read', function($row){
            if($row->read_at!=NULL){
                return '<i class="fa fa-book-reader text-primary"></i>'; 
            }
            else{
               return '<i class="fa fa-book text-danger"></i>'; 
            }
           
        })
        ->editColumn('arrive at', function($row){
            return $row->created_at->diffForHumans();
        })
        
        ->addColumn('action', function($row) use ($user){
            $btn = '';
                if ($user->can('notification-show')) {
                    $btn .= '<a class="btn btn-success btn-sm" href="'.route('notifications.view',$row->id).'">Show</a> ';
                } 
                
            return $btn;
        })
        ->setRowId(function ($row) {
            return $row->id;
        })
        
        
        ->rawColumns(['subject','message','read','arrive at','action'])
        ->make(true);
    }
    public function searchByUser(Request $request){
        $data = [];//->role('Franchise-Admin')
        if($request->has('q')){
            $search = $request->input('q');
            $data = User::role('Franchise-Admin')->with('customers:id,user_id,center_code,cust_name')->whereHas('customers', function ($query) use ($search) {
                    $query->where('cust_name','like','%'.$search.'%')->orWhere('center_code','like','%'.$search.'%');
                })->orWhere('name', 'LIKE', "%$search%")->get();
                
        }
        else{
            $data = User::role('Franchise-Admin')
            ->with('customers:id,user_id,center_code,cust_name')->limit(6)->get();
        } 
        
        return response()->json($data);
    }
    public function create(){
        return view('admin.notifications.create');
    }
    public function store(Request $request){
        // $messages = [
        //     'customers.*.exists' => 'The address field is required.',
        // ];
        //dd($request);

        $this->validate($request, [
            'customers' => ['required_without:students','exists:users,id'],
            'students' => 'required_without:customers|nullable',
            'subject' =>['required'],
            'message' =>['required'],
        ]);
        $details =[
            'subject' => $request->input('subject'),
            'message' => $request->input('message'),
        ];
        if($request->input('students')==true){
            $students = User::role('Student-Admin')->get();
            Notification::send($students, new PostNotice($details));
        }
        if(count($request->input('customers'))>0){
            if(head($request->input('customers'))==1){
                $customers = User::role('Franchise-Admin')->get();  
            }
            else{
                $customers = User::role('Franchise-Admin')->whereIn('id', $request->input('customers'))->get();
            }
            
            
           Notification::send($customers, new PostNotice($details));
        }
        
        return redirect()->route('notifications.index')->with('success','Nofication has sent');
    }
    public function readAll(Request $request){
       
        $flag_check = Auth::user()->unreadNotifications()->whereIn('id',$request->arr)->update(['read_at' => now()]);
        if($flag_check){
            return response()->json(['status'=>'success','msg'=>'Notification has marked read successfully']);
        }
        return response()->json(['status'=>'warning','msg'=>'Selected notification has already been read']);
    
    }
    public function read($id){
        $flag_check = Auth::user()->unreadNotifications()->where('id',$id)->update(['read_at' => now()]);
        if($flag_check){
            return redirect()->route('notifications')->with('success','Notification has marked read successfully');
        }
        return redirect()->route('notifications')->with('warning','Selected notification has already been read');
    }
    public function show($id){
        $notice = Auth::user()->notifications()->where('id',$id)->first();
        if($notice->read_at==NULL){
            $notice->markAsRead(); 
        }
        
        return view('admin.notifications.show',compact('notice'));
    }
    public function destroyAll(Request $request){
       
        $flag_check = Auth::user()->unreadNotifications()->whereIn('id',$request->arr)->delete();
        
        return response()->json(['status'=>'success','msg'=>'Notification has deleted successfully']);
    
    }
    public function destroy($id)
    {
        Auth::user()->notifications()->where('id',$id)->delete();
        return redirect()->route('notifications.index')
                        ->with('success','User deleted successfully');
    }
}
