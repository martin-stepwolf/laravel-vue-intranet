<?php

namespace App\Http\Controllers;

use App\Machine;
use App\Http\Requests\MachineRequest;

class MachineStateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $machines = Machine::orderBy('user_agent', 'asc')->get();;
        for ($i = 0; $i < count($machines); $i++) {
            $machines[$i]->machine_state;
        }
        return $machines;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\MachineRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MachineRequest $request, $id)
    {
        $machine = Machine::find($id);
        $machine->machine_state_id = $request->machine_state_id;
        $machine->update();
        $machine->machine_state;
        return $machine;
    }
}
