<?php

namespace App\Http\Controllers;

use App\Models\admin\OptionController;
use Illuminate\Http\Request;

class OptionControllerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // select all options
        $model = OptionController::all();
        return view("layouts.option.index", compact("model"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("layouts.option.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $model = new OptionController();
        $model->title = $request->title;
        $model->type = $request->type;
        // return $request->option;
        $options = implode(',', $request->option);
        $model->options = $options;
        $model->save();
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(OptionController $optionController)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $model = OptionController::find($id);
        $options = $model->options;
        $options = explode(',', $options);
        return view('layouts.option.edit', compact(['model', 'options']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $model = OptionController::findOrFail($id);
        $model->title = $request->title;
        $model->type = $request->type;
        // convert string to array for options that is saved in service
        $options = implode(',', $request->option);
        $model->options = $options;
        $model->save();
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OptionController $optionController)
    {
        //
    }
}
