<?php

// app/Http/Controllers/EmployeeController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;

class EmployeeNewController extends Controller
{
    public function index()
    {
        return Employee::all();
    }

    public function show($id)
    {
        return Employee::find($id);
    }

    public function store(Request $request)
    {
        return $request;
        return Employee::create($request->all());
    }

    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);
        $employee->update($request->all());
        return $employee;
    }

    public function destroy($id)
    {
        Employee::findOrFail($id)->delete();
        return response()->json(['message' => 'Employee deleted successfully']);
    }
}

