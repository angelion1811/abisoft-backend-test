<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterPersonRequest;
use App\Http\Requests\UpdatePersonRequest;
use App\Http\Requests\DeletePersonRequest;
use App\Models\Person;

class PersonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Person::paginate());
    }

    public function getAll(){
        return response()->json(Person::get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RegisterPersonRequest $request)
    {
      $data = $request->all();
      $item = Person::create($data);
      return response()->json($item);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Person::where('id', $id)->firstOrFail();
        if(!$item) return response()->json(['message'=>"not found"], 404);
        return response()->json($item);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePersonRequest $request, $id)
    {
        $item = Person::where('id', $id)->first();
        $item->update($request->all());
        return response()->json($item,201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeletePersonRequest $request, $id)
    {
        Person::where('id', $id)->delete();
        return response()->json(['message'=>'Ok']);
    }
}
