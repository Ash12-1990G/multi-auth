<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Notifiable_Reciepient;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Notification as FacadesNotification;
use App\Models\Notification;
use App\Models\Student;
use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Notifications\PostNotice;
use Illuminate\Database\Query\Builder;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;


class NotificationController extends Controller
{
    public function index(Request $request){
    
        $role = Role::select('id')->where('name','Franchise-Admin')->first();
        $user = auth()->user();
        $user_id = $user->id;
       
        if(request()->ajax()){
           
            $data = Notification::select('notifications.*')->leftJoin('notifiable_reciepients',function ($join) use ($user_id) {
                $join->on('notifications.id', '=', 'notifiable_reciepients.notification_id')->where('notifiable_reciepients.user_id', $user_id);
            })->where('notifiable_reciepients.notification_id','=',NULL)->where('notifications.notifiable_type','Spatie\Permission\Models\Role')->where('notifications.notifiable_id',$role->id)
            ->orWhere(function ($query) use ($user_id,$role) {
                $query->where('notifiable_type','Spatie\Permission\Models\Role')->where('notifiable_id',$role->id)->doesnthave('notifiable_reciepients');
            })
            ->orWhere(function ($query) use ($user_id,$role) {
                $query->where('notifiable_type','Spatie\Permission\Models\Role')->where('notifiable_id',$role->id)->whereHas('notifiable_reciepients', function($query) use ($user_id){
                        $query->where('notifiable_reciepients.user_id',$user_id)->where('notifiable_reciepients.delete_at','=',NULL);
                    });
            })
            ->orWhere(function ($query) use ($user_id) {
                $query->customerIndividualNotice($user_id);
            })
            ->get();
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
        
        ->editColumn('read', function($row){
            if($row->notifiable_type=='Spatie\Permission\Models\Role'){
              //return $row->availableNotice;
                if($row->availableNotice()->count()){
                   
                    return '<i class="fa fa-book-reader text-primary"></i>'; 
                }
                else{
                return '<i class="fa fa-book text-danger"></i>'; 
                }
            }
            else{
                if($row->read_at!=NULL){
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
                    
                    
                    $btn .= '<a class="btn btn-success btn-sm mb-1" href="'.route('customer.notifications.view',$row->id).'"><i class="fas fa-folder-open"></i></a> ';
                   
                    
                } 
                
                if ($user->can('notification-delete')) {
                    
                    
                        $route_url = 'customer.notifications.destroy';
                        if($row->notifiable_type=='Spatie\Permission\Models\Role'){
                            if($row->notifiable_reciepients->count()){
                                $btn .= \Form::open(['method' => 'DELETE','route' => ['customer.notifications.destroy',['notification'=> $row->id,'type'=>'group']],'style'=>'display:inline']) .
                                \Form::button('<i class="fas fa-trash"></i>', ['type' => 'submit','class'=>'btn btn-danger btn-sm mb-1']).
                                \Form::close();
                            }
                        }
                        else{
                            $btn .= \Form::open(['method' => 'DELETE','route' => ['customer.notifications.destroy', ['notification'=> $row->id,'type'=>'single']],'style'=>'display:inline']) .
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

    public function sentNotification(){
        
        
        if(request()->ajax()){
            $data = Notification::where('type','App\Notifications\PostNotice')->where('notifiable_type','Spatie\Permission\Models\Role')->select('id as ntid','created_at as deliver','data->subject as subject','data->message as message','data->sender as sender','data->message_id as ids')->where('data->sender',Auth::id())->get()->groupBy('ids');
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
                        $btn .= '<a class="btn btn-success btn-sm mb-1" href="'.route('customer.notifications.sent.view',$row[0]->ntid).'"><i class="fas fa-folder-open"></i></a> ';
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
    public function create(){
        return view('customer.notification.create');
    }
    public function store(Request $request){
        $notice = Notification::orderBy('created_at','desc')->first();
        
        if($notice){
            $msg_id = 'NT0'.str_pad($notice->id, 1, '0', STR_PAD_LEFT);
        }
        else{
            $msg_id = 'NT0'.str_pad(1, 1, '0', STR_PAD_LEFT);
        }
        
        $this->validate($request, [
            
            'subject' =>['required'],
            'message' =>['required'],
        ]);
        
        $details =[
            'subject' => $request->input('subject'),
            'message' => $request->input('message'),
            'sender' => Auth::id(),
            'message_id' => $msg_id,
        ];
      
        $roles = Role::where('name','Student-Admin')->get();
        $customer = auth()->user()->customers->id;
        //dd($customer);
        $students = Student::where('customer_id',$customer)->get();
        //dd($students->count());
        if($students->count()==0){
                
            return redirect()->back()->with('warning','There are not any students.');
        }
        FacadesNotification::send($roles, new PostNotice($details));
        return redirect()->route('customer.notifications.create')->with('success','Nofication has sent');
    }
    public function show($id){
        $notice = Notification::findOrFail($id);
        if($notice->notifiable_type=='Spatie\Permission\Models\Role'){
            $notice_user = Notifiable_Reciepient::where('notification_id',$id)->where('user_id',auth()->user()->id)->get();
            if($notice_user->count()==0){
                Notifiable_Reciepient::create(['notification_id'=>$id,'user_id'=>Auth::id(),'read_at'=>now()]); 
            }
        }
        else{
            Auth::user()->unreadNotifications()->where('id',$id)->update(['read_at' => now()]);
        }
                
        $sender = 'ACTI-INDIA ADMIN';
        return view('admin.notifications.show',compact('notice','sender'));
    }
    public function read($id){
        $user_id = auth()->user()->id;
        $data = Notification::findOrFail($id);
        
        if($data->count()){
            if($data->notifiable_type=='Spatie\Permission\Models\Role'){
                if($data->notifiable_reciepients()->count()==0){
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
            else if($data->notifiable_type=='App\Models\User'){
                if($data->read_at==NULL){
                    Auth::user()->unreadNotifications()->where('id',$data->id)->update(['read_at' => now()]);
                    return redirect()->back()->with('success','Notification has marked read successfully');
                }
                return redirect()->back()->with('warning','Selected notification has already been read');
            }
            
            return redirect()->back()->with('warning','Selected notification has already been read');
        }
        
        return redirect()->back()->with('warning','Selected notification do not exist.');
    }
    public function readAll(Request $request){
       
        $user_id = auth()->user()->id;
        if($request->has('arr') && !empty($request->has('arr'))){
            $arr = $request->arr;
            $data = Notification::where(function ($query) use ($user_id,$arr) {
                    $query->doesnthave('notifiable_reciepients')->where('notifiable_type','Spatie\Permission\Models\Role')->whereIn('id',$arr);
            
            })->orWhere(function ($query) use ($user_id,$arr) {
                $query->where('notifiable_type','App\Models\User')->where('read_at',NULL)->where('notifiable_id',$user_id)->whereIn('id',$arr);
            })->get();
            
            $msg = 'no';
            if($data->count()){
                foreach($data as $items){
                    if($items->notifiable_type=='Spatie\Permission\Models\Role'){
                        $notice['notification_id'] = $items->id;
                        $notice['user_id'] = $user_id;
                        $notice['read_at'] = now();
                        $notice_flag = Notifiable_Reciepient::create($notice);
                        
                        if($notice_flag){
                            $msg = "yes";
                            
                        }
                        
                    }
                    if($items->notifiable_type=='App\Models\User'){
                        Auth::user()->unreadNotifications()->where('id',$items->id)->update(['read_at' => now()]);
                        $msg = "yes";
                    }
                }
                if($msg=='yes'){
                    return response()->json(['status'=>'success','msg'=>'Notification has marked read successfully']);
                }
                return response()->json(['status'=>'warning','msg'=>'Selected notification has already been read']);
            }
            return response()->json(['status'=>'warning','msg'=>'Selected notification either not exist or has already been read.']);
        }
        return response()->json(['status'=>'warning','msg'=>'Sorry, nothing has selected.']);
    }
    public function showNotice($id){
        $notice = Notification::find($id);
           
        return view('admin.notifications.show',compact('notice'));
    }
    public function destroyAll(Request $request){
        if(request()->ajax()){
            $user = Notification::whereIn('id',$request->arr)->where('notifiable_type','App\Models\User')->pluck('id')->toArray();
            if(!empty($user)){
                $flag_check = Notification::whereIn('id',$user)->update(['delete_at'=>now()]);
            }
            $role = Notification::whereIn('id',$request->arr)->where('notifiable_type','Spatie\Permission\Models\Role')->pluck('id')->toArray();
            if(!empty($role)){
                $flag_check = Notifiable_Reciepient::where('user_id',auth()->user()->id)->whereIn('notification_id',$role)->update(['delete_at'=>now()]);
            }
            if($flag_check){
                return response()->json(['status'=>'success','msg'=>'Notification has deleted successfully']);
            }
        }
         return response()->json(['status'=>'warning','msg'=>'Notification error']);
     
     }
     public function destroy($notification,$type)
     {
        if($type=='group'){
            $data = Notifiable_Reciepient::where('notification_id',$notification)->where('user_id',auth()->user()->id)->update(['delete_at'=>now()]);
            return redirect()->route('customer.notifications.index')
            ->with('success','User deleted successfully');
        }
        else if($type=='single'){
            Notification::where('notifiable_type','App\Models\User')->findOrFail($notification)->delete();
            return redirect()->route('customer.notifications.index')
            ->with('success','User deleted successfully');

        }
        return; 
     }
}
