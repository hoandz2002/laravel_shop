<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $con=Contact::select('id','name','title','content','email')
        ->paginate(5);
        return view('admin.contact.list',[
            'contacts'=>$con,
        ]);
    }
    
    public function delete($contacts)
    {
        $data = Contact::find($contacts);
        $data->delete();
        return redirect()->route('admin.contacts.list');
    }
    public function updateAction($contacts)
    {
            $actionOld = Contact::find($contacts);
            if($actionOld->action === 0){
                $actionOld->action = 1;
            }else {
                $actionOld->action = 0;
            }
            // dd($actionOld);
            $actionOld->save();
            // session()->flash('success', 'Bạn đã cập nhật trạng thái thành công!');
            return redirect()->route('admin.contacts.list');
            // return redirect()->back();
    }
}
