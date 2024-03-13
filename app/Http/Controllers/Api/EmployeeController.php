<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeRequest;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //return Employee::all();

        return Employee::select('firstname', 'lastname')->get();

        // return Employee::paginate(10);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(EmployeeRequest $request)
    {
        $validated = $request->validated();

        $employee = Employee::create($validated);

        return $employee;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
