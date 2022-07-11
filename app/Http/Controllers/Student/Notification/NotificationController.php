<?php

namespace App\Http\Controllers\Student\Notification;

use App\Http\Controllers\Controller;
use App\Models\Notifiable_Reciepient;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class NotificationController extends Controller
{
    public function index(Request $request){
        
        if(request()->ajax()){
            $role = Role::select('id')->where('name','Student-Admin')->first();
            $user = auth()->user();
            $user_id = $user->id;
           
        $data = Notification::select('notifications.*')->leftJoin('notifiable_reciepients',function ($join) use ($user_id) {
            $join->on('notifications.id', '=', 'notifiable_reciepients.notification_id')->where('notifiable_reciepients.user_id', $user_id);
        })->where('notifiable_reciepients.notification_id','=',NULL)->where('notifications.notifiable_type','Spatie\Permission\Models\Role')->orWhere(function ($query) use ($user_id,$role) {
            $query->where('notifiable_type','Spatie\Permission\Models\Role')->where('notifiable_id',$role->id)->doesnthave('notifiable_reciepients');
        })
        ->orWhere(function ($query) use ($user_id,$role) {
            $query->where('notifiable_type','Spatie\Permission\Models\Role')->where('notifiable_id',$role->id)->whereHas('notifiable_reciepients', function($query) use ($user_id){
                    $query->where('notifiable_reciepients.user_id',$user_id)->where('notifiable_reciepients.delete_at','=',NULL);
                });
        })
        ->where('data->sender',1)
        ->orWhere('data->sender',$user->students->customer_id)
        ->orderBy('created_at','desc')->get();
       
        //dd($data);
            return self::getDatatable($data,$user);
        };
        
        return view('admin.notifications.index');
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
           if($row->type=='App\Notifications\PostNotice'){
                $val .=  '<p class="text-primary" >'.$row->data['subject'].'</p>';
            }
            $val .=  '<p class="text-primary" > </p>';
            return $val;
        })
        ->editColumn('message', function($row) {
            return $row->data['message'];
        })
        
        ->editColumn('read', function($row) use ($user) {
            if($row->notifiable_type=='Spatie\Permission\Models\Role'){
               //return $row->notifiable_reciepients;
                if($row->availableNotice()->count()){
                        return '<i class="fa fa-book-reader text-primary"></i>'; 
                    
                }
                else{
                return '<i class="fa fa-book text-danger"></i>'; 
                }
            }
            
           
        })
        ->editColumn('arrive at', function($row){
            return $row->created_at->diffForHumans();
        })
        
        ->addColumn('action', function($row) use ($user){
            $btn = '';
            $roles = $user->getRoleNames(); 
            
                if ($user->can('notification-show') || $user->can('notification-view')) {
                    
                    
                    $btn .= '<a class="btn btn-success btn-sm mb-1" href="'.route('student.notifications.view',$row->id).'"><i class="fas fa-folder-open"></i></a> ';
                   
                    
                } 
                
                if ($user->can('notification-delete')) {
                    
                    
                        $route_url = 'student.notifications.destroy';
                        if($row->notifiable_reciepients->count()){
                            $btn .= \Form::open(['method' => 'DELETE','route' => [$route_url, $row->id],'style'=>'display:inline']) .
                            \Form::button('<i class="fas fa-trash"></i>', ['type' => 'submit','class'=>'btn btn-danger btn-sm mb-1']).
                            \Form::close();
                        }
                }
                
            return $btn;
        })
        ->setRowId(function ($row) {
            return $row->id;
        })
        
        
        ->rawColumns(['DT_RowIndex','subject','message','read','arrive at','action'])
        ->make(true);
    }
    public function show($id){
        $customer = auth()->user()->students->customer_id;
        $notice = Notification::where('data->sender',1)->orWhere('data->sender',$customer)->findOrFail($id);
        $notice_user = Notifiable_Reciepient::where('notification_id',$id)->where('user_id',auth()->user()->id)->get();
       
        if($notice_user->count()==0){
            Notifiable_Reciepient::create(['notification_id'=>$id,'user_id'=>Auth::id(),'read_at'=>now()]); 
        }
        // $user = User::findOrFail($notice->data['sender']);
        // if($user->hasRole('super-admin')){
        //     $sender = 'ACTI-INDIA ADMIN';
        // }
        // else{
        //     $sender = $user->name;
        // }
        return view('admin.notifications.show',compact('notice'));
    }
    public function read($id){
        $user_id = auth()->user()->id;
        $customer = auth()->user()->students->customer_id;
        $data = Notification::with(['notifiable_reciepients'=>function($query) use ($user_id){
            $query->where('user_id',$user_id)->get();
        }])->where('notifiable_type','Spatie\Permission\Models\Role')->where('id',$id)
        ->where('data->sender',1)->orWhere('data->sender',$customer)
        ->get();
        if($data->count()){
            if($data->notifiable_reciepients->count()==0){
                $notice['notification_id'] = $id;
                $notice['user_id'] = $user_id;
                $notice['read_at'] = now();
                $notice_flag = Notifiable_Reciepient::create($notice);
                if($notice_flag){
                    return redirect()->back()->with('success','Notification has marked read successfully');
                }
            }
            return redirect()->back()->with('warning','Selected notification has already been read');
        }
        
        return redirect()->back()->with('warning','Selected notification do not exist.');
    }
    public function readAll(Request $request){
       
        $user_id = auth()->user()->id;
        $data = Notification::with(['notifiable_reciepients'=>function($query) use ($user_id){
            $query->where('user_id',$user_id)->get();
        }])->where('notifiable_type','Spatie\Permission\Models\Role')->whereIn('id',$request->arr)->get();
        $msg = 'no';
        if($data->count()){
            foreach($data as $items){
                if($items->notifiable_reciepients->count()==0){
                    $notice['notification_id'] = $items->id;
                    $notice['user_id'] = $user_id;
                    $notice['read_at'] = now();
                    $notice_flag = Notifiable_Reciepient::create($notice);
                    
                    if($notice_flag){
                        $msg = "yes";
                        
                    }
                    
                }
            }
            if($msg=='yes'){
                return redirect()->back()->with('success','Notification has marked read successfully');
            }
            return redirect()->back()->with('warning','Selected notification has already been read');
        }
        
        return redirect()->back()->with('warning','Selected notification do not exist.');
    }
    public function destroyAll(Request $request){
        if(request()->ajax()){
            $flag_check = Notifiable_Reciepient::where('user_id',auth()->user()->id)->whereIn('notification_id',$request->arr)->update(['delete_at'=>now()]);
            if($flag_check){
                return response()->json(['status'=>'success','msg'=>'Notification has deleted successfully']);
            }
        }
         return response()->json(['status'=>'warning','msg'=>'Notification error']);
     
     }
     public function destroy($id)
     {
        
        $data = Notifiable_Reciepient::where('notification_id',$id)->where('user_id',auth()->user()->id)->update(['delete_at'=>now()]);
        return redirect()->route('student.notifications.index')
        ->with('success','User deleted successfully');
         
     }
}
