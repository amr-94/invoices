<?php

namespace App\Http\Controllers;

use App\Models\product;
use App\Models\section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Nette\Utils\Json;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $sections = section::all();
        return view('sections.sectionindex', [
            'sections' => $sections
        ]);
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
        $request->validate([
            'section_name' => 'required|unique:sections,section_name',
        ],[
            'section_name.required' => 'يرجى ادخال اسم القسم',
            'section_name.unique' => 'هذا القسم موجود مسبقا'
        ]);
        // $exist = section::where('section_name', $request->section_name)->exists();
        // if ($exist) {
        //     return redirect(route('sections.index'))->with('danger', ' هذا القسم موجود مسبقا');
        // }
        // {


            $request->merge([
                'user_id' => Auth::user()->id
            ]);
            section::create($request->all());
            return redirect(route('sections.index'))->with('success', 'تم اضافة قسم جديد');
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\section  $section
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $section = section::findorfail($id);
        return view('sections.show',[
            'section'=>$section
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\section  $section
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\section  $section
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //

        $id = $request->id;
        $request->validate([
            'section_name' => "required|unique:sections,section_name,$id",
        ], [
            'section_name.required' => 'يرجى ادخال اسم القسم',
            'section_name.unique' => 'هذا القسم موجود مسبقا'
        ]);
        $section = section::findorfail($id);
        $section->update($request->all());
         return redirect(route('sections.show',$id))->with('success',"تم تحديث القسم ($section->section_name)");
        // return $request;
        }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\section  $section
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        $id = $request->id;
        $section = section::findorfail($id);
        $section->destroy($id);
        return redirect(route('sections.index'))->with('success',"تم حذف القسم بنجاح ($section->section_name)");
    }

    public function getproducts($id){
        // $section= section::findorfail($id);
        // $products = $section->products('name','id');
        $products = product::where('section_id',$id)->pluck('name','id');
        return json_encode($products);

    }
}
