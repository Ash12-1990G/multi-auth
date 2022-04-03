<?php

namespace App\Http\Controllers\Admin\Notifications;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index(Request $request){
        
        $data = Auth::user()->notifications()->latest()->paginate(2);
        
        return view('admin.notifications.index',compact('data'))
        ->with('i', ($request->input('page', 1) - 1) * 2);
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
