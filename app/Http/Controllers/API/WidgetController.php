<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Widget;
use Validator;
use App\Http\Resources\Widget as WidgetResource;

class WidgetController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Widgets = Widget::all();

        return $this->sendResponse(WidgetResource::collection($Widgets), 'Widgets retrieved successfully.');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'description' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $Widget = Widget::create($input);

        return $this->sendResponse(new WidgetResource($Widget), 'Widget created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Widget = Widget::find($id);

        if (is_null($Widget)) {
            return $this->sendError('Widget not found.');
        }

        return $this->sendResponse(new WidgetResource($Widget), 'Widget retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Widget $Widget)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'description' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $Widget->name = $input['name'];
        $Widget->description = $input['description'];
        $Widget->save();

        return $this->sendResponse(new WidgetResource($Widget), 'Widget updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Widget $Widget)
    {
        $Widget->delete();

        return $this->sendResponse([], 'Widget deleted successfully.');
    }
}
