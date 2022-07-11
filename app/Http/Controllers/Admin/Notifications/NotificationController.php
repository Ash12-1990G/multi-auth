<?php

namespace App\Http\Controllers\Admin\Notifications;

use App\Http\Controllers\Controller;
use App\Models\Notification as ModelsNotification;
use App\Models\User;
use App\Notifications\PostNotice;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Notifications\Events\NotificationSent;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\Support\Facades\Notification;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class NotificationController extends Controller
{
    public function index(Request $request){
     
        
        if(request()->ajax()){
            $data = Auth::user()->notifications()->get();
            $user = auth()->user();
            return self::getDatatable($data,$user);
        };
        
        return view('admin.notifications.index');
    }
    public function sentNotification(){
        
        
        if(request()->ajax()){
            $data = ModelsNotification::where('type','App\Notifications\PostNotice')->select('id as ntid','created_at as deliver','data->subject as subject','data->message as message','data->sender as sender','data->message_id as ids')->where('data->sender',Auth::id())->get()->groupBy('ids');
            $user = auth()->user();
            return DataTables::of($data)
        
            ->addIndexColumn()
        ->editColumn('subject', function($row)  {
            $val = '';
            
                $val .=  '<p class="text-primary" >'.$row[0]->subject.'</p>';
            
            return $val;
        })
        ->editColumn('message', function($row) {
            return '<div class="text-truncate">'.$row[0]->message.'</div>';
        })
        
        ->editColumn('delivered at', function($row){
            return Carbon::parse($row[0]->deliver)->diffForHumans();
        })
        
        ->addColumn('action', function($row) use ($user){
            $btn = '';
                if ($user->can('notification-show')) {
                    if($user->hasRole('super-admin')){
                        $btn .= '<a class="btn btn-success btn-sm mb-1" href="'.route('notifications.sent.view',$row[0]->ntid).'"><i class="fas fa-folder-open"></i></a> ';
                    }
                    else{
                        $btn .= '<a class="btn btn-success btn-sm mb-1" href="'.route('customer.notifications.sent.view',$row[0]->ntid).'"><i class="fas fa-folder-open"></i></a> ';
                    }
                } 
                
                
            return $btn;
        })
        ->setRowId(function ($row) {
            return $row[0]->ntid;
        })
        
        
        ->rawColumns(['DT_RowIndex','subject','message','delivered at','action'])
        ->make(true);
        
         }  
         
     
        return view('admin.notifications.sent');
    }
    
    public function getDatatable($data,$user){
        
        return DataTables::of($data)
        
       ->editColumn('DT_RowIndex',function($row){
        return '<div class="icheck-primary">
        <input type="checkbox" name="read[]" value="'.$row->id.'" id="check'.$row->id.'">
        <label for="check'.$row->id.'"></label>
      </div>';
       })
        ->editColumn('subject', function($row)  {
            $val = '';
            if($row->type=='App\Notifications\FailedJobsNotice'){
                $val .= '<p class="text-primary" >Registration Mail Failure</p>';
            }
            else if($row->type=='App\Notifications\PostNotice'){
                $val .=  '<p class="text-primary" >'.$row->data['subject'].'</p>';
            }
            $val .=  '<p class="text-primary" > </p>';
            return $val;
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
                    if($user->hasRole('super-admin')){
                        $btn .= '<a class="btn btn-success btn-sm mb-1" href="'.route('notifications.view',$row->id).'"><i class="fas fa-folder-open"></i></a> ';
                    }
                    elseif($user->hasRole('Franchise-Admin')){
                        $btn .= '<a class="btn btn-success btn-sm mb-1" href="'.route('customer.notifications.view',$row->id).'"><i class="fas fa-folder-open"></i></a> ';
                    }
                    elseif($user->hasRole('Student-Admin')){
                        $btn .= '<a class="btn btn-success btn-sm mb-1" href="'.route('student.notifications.view',$row->id).'"><i class="fas fa-folder-open"></i></a> ';
                    }
                    else{
                        $btn .= '<a class="btn btn-success btn-sm mb-1" href="'.route('notifications.view',$row->id).'"><i class="fas fa-folder-open"></i></a> ';
                    }
                } 
                if ($user->can('notification-delete')) {
                    if($user->hasRole('super-admin')){
                        $route_url = 'notifications.destroy';
                    }
                    elseif($user->hasRole('Franchise-Admin')){
                        $route_url = 'customer.notifications.destroy';
                    }
                    elseif($user->hasRole('Student-Admin')){
                        $route_url = 'student.notifications.destroy';
                    }
                    else{
                        $route_url = 'notifications.destroy';
                    }
                    $btn .= \Form::open(['method' => 'DELETE','route' => [$route_url, $row->id],'style'=>'display:inline']) .
                    \Form::button('<i class="fas fa-trash"></i>', ['type' => 'submit','class'=>'btn btn-danger btn-sm mb-1']).
                    \Form::close();
                }
                
            return $btn;
        })
        ->setRowId(function ($row) {
            return $row->id;
        })
        
        
        ->rawColumns(['DT_RowIndex','subject','message','read','arrive at','action'])
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
        else if($request->has('itemselect')){
            $itemselect = $request->itemselect;
            $data = User::role('Franchise-Admin')->whereIn('id', $itemselect)->with('customers:id,user_id,center_code,cust_name')->get();
            
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
        $notice = ModelsNotification::orderBy('created_at','desc')->first();
        if($notice){
            $msg_id = 'NT0'.str_pad($notice->id, 1, '0', STR_PAD_LEFT);
        }
        else{
            $msg_id = 'NT0'.str_pad(1, 1, '0', STR_PAD_LEFT);
        }
       
        $this->validate($request, [
            'customers' => ['required_without:students','exists:users,id'],
            'students' => 'required_without:customers|nullable',
            'subject' =>['required'],
            'message' =>['required'],
        ]);
        $details =[
            'subject' => $request->input('subject'),
            'message' => $request->input('message'),
            'sender' => Auth::id(),
            'message_id' => $msg_id,
        ];
        if($request->input('students')==true){
            $students = Role::where('name','Student-Admin')->get();
            
            if($students[0]->users()->count()>0){
                
                return redirect()->back()->with('warning','There are not any students.');
            }
            Notification::send($students, new PostNotice($details));
            
        }
        if(!empty($request->input('customers')) && count($request->input('customers'))>0){
            if(head($request->input('customers'))==1){
                $customers = Role::where('name','Franchise-Admin')->get();  
            }
            else{
                $customers = User::role('Franchise-Admin')->whereIn('id', $request->input('customers'))->get();
                
            }
            Notification::send($customers, new PostNotice($details));
        }
        
        return redirect()->route('notifications.create')->with('success','Nofication has sent');
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
            return redirect()->back()->with('success','Notification has marked read successfully');
        }
        return redirect()->back()->with('warning','Selected notification has already been read');
    }
    public function show($id){
        $notice = Auth::user()->notifications()->where('id',$id)->first();
        if($notice->read_at==NULL){
            $notice->markAsRead(); 
        }
        
        return view('admin.notifications.show',compact('notice'));
    }
    public function showNotice($id){
        $notice = ModelsNotification::find($id);
           
        return view('admin.notifications.show',compact('notice'));
    }
    public function destroyAll(Request $request){
       if(request()->ajax()){
          
        $flag_check = Auth::user()->unreadNotifications()->whereIn('id',$request->arr)->delete();
        if($flag_check){
            return response()->json(['status'=>'success','msg'=>'Notification has deleted successfully']);
        }
       }
        return response()->json(['status'=>'warning','msg'=>'Notification error']);
    
    }
    public function destroy($id)
    {
        Auth::user()->notifications()->where('id',$id)->delete();
        if(Auth::user()->hasRole('Student-Admin')){
            return redirect()->route('student.notifications.index')
            ->with('success','User deleted successfully');
        }
        elseif(Auth::user()->hasRole('Franchise-Admin')){
            return redirect()->route('customer.notifications.index')
            ->with('success','User deleted successfully');
        }
        return redirect()->route('student.notifications.index')
            ->with('success','User deleted successfully');
        
    }
}
