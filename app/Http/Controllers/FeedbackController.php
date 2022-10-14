<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index()
    {
        $feedback = Feedback::select('feedback.*')
            ->paginate(10);
        return view('admin.feedbacks.list', compact('feedback'));
    }
    //feddback
    public function create($id_Order)
    {
        $id_donhang = $id_Order;
        return view('KH.feedback', compact('id_donhang'));
    }
    //  
    public function storeFeedback(Request $request)
    {
        $data = new Feedback();
        $data->fill($request->all());
        // dd($request->all());
        // dd($data);
        $data->save();
        session()->flash('success', 'bạn đã gửi thành công');  
        return redirect()->back();
    }
}
