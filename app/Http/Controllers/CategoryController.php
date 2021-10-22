<?php

namespace App\Http\Controllers;

use App\Models\category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;


class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $category = [];
        if ($request->ajax()) {
            $data = category::get();
            return DataTables::of($data)
                   ->addIndexColumn()
                   ->addColumn('action', function ($row) {
                       if (Auth::user()->role_id == 2) {
                           if (Auth::user()->id == $row->user_id) {
                               $btn = '<div class="form-group">
                            <button type="button" class="btn btn-success category_edit" data-toggle="modal" data-target="#update_modal" data-id="' . $row->id . '" ><i class="fa fa-edit"></i></button>
                            <button type="button" class="btn btn-danger category_delete" data-toggle="modal" data-target="#modalConfirmDelete" data-id="' . $row->id . '" ><i class="fa fa-trash"></i></button></div>';
                               return $btn;
                           }
                       } elseif (Auth::user()->role_id == 1) {
                           $btn = '<div class="form-group">
                        <button type="button" class="btn btn-success category_edit" data-toggle="modal" data-target="#update_modal" data-id="' . $row->id . '" ><i class="fa fa-edit"></i></button>
                            <button type="button" class="btn btn-danger category_delete" data-toggle="modal" data-target="#modalConfirmDelete" data-id="' . $row->id . '"><i class="fa fa-trash"></i></button></div>';
                           return $btn;
                       }
                   })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('categories.index', compact('category'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
     

        // if ($request->hasFile('icon')) {
        //     //
        //     $icon = $request->file('icon');
        //     $path = public_path('icon');
        //     $name = time().rand(1, 99999) . "." . $icon->getClientOriginalExtension();
        //     $icon->move($path, $name);
        //     // dd($path);
        // }
     
        //
        $category = new Category();
        $category->c_name = $request->c_name;
        $category->created_by = Auth::user()->role_id;
        //dd($category);
        $save = $category->save();
        if ($save) {
            return redirect()->route('categories.index');
        }
    }
    


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $data = category::find($id);

        return response()->json($data);
    }
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $category = category::find($id);
        $category->c_name = $request->c_name;
        $save = $category->update();
        if ($category) {
            return redirect()->route('categories.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //   
        $category1 = category::find($id);
        $category1->Products()->detach();
        $category = category::where('id', $id)->delete();
        return redirect()->route('categories.index');
    }
}


