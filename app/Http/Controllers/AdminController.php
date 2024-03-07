<?php

namespace App\Http\Controllers;

use App\Models\message;
use App\Models\section;
use App\Models\User;
use App\Notifications\message_notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        if (view()->exists($id)) {
            return view($id);
        } else {
            return view('404');
        }

        //   return view($id);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $message = message::all()->where('to_user_id', Auth::user()->id);

        $user = User::findorfail($id);
        $sections = section::all();
        return view('user.profile', [
            'sections' => $sections,
            'user' => $user,
            'message' => $message
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $user = Auth::user();
        return view('user.edituer', [
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        if ($request->hasFile('user_photo')) {
            $filename = time() . '.' . $request->user_photo->extension();
            $request->user_photo->move(public_path('user/'), $filename);
            $request->merge([
                'profile_photo' => $filename
            ]);
        }
        $user = User::findorfail($id);
        $prev = $user->profile_photo;
        if ($prev && $prev !== $request->user_photo && $request->user_photo !== null) {
            File::delete(public_path('user/' . $prev));
        }
        $user->update($request->all());
        return redirect(route('admin.edit', $id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function send_message(Request $request, $id)
    {
        $request->merge([
            'to_user_id' => $id,
            'from_user_id' => Auth::user()->id
        ]);
        message::create($request->all());
        $tomessage = User::where('id', $id)->first();
        $tomessage->notify(new message_notification($tomessage, Auth::user()));

        return redirect(route('admin.allmessage'));
    }

    public function allmessage()
    {
        $message = message::all()->where('to_user_id', Auth::user()->id);
        return view('user.messages', [
            'message' => $message
        ]);
    }
    public function delete_message($id)
    {
        $message = message::findorfail($id);
        $message->destroy($id);
        return redirect(route('admin.allmessage'));
    }

    public function notify()
    {
        return view('user.all_notify', [
            'notifications' => Auth::user()->notifications
        ]);
    }
    public function show_notify($id)
    {
        $user = Auth::user();
        $notify = $user->notifications->find($id);
        if ($notify && $notify->unread()) {
            $notify->markAsread();
        }
        return redirect()->to($notify->data['url']);
    }
     public function delete_notify($id)
    {
        $notifications= Auth::user()->notifications()->find($id)->destroy($id);
        return redirect()->route('admin.notify');
        
    }
}
