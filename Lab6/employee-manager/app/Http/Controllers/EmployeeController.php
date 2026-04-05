<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    // List all employees
    public function index() {
        return view('employees.index', ['employees' => Employee::all()]);
    }

    // Show the "Add" form
    public function create() {
        return view('employees.create');
    }

    public function edit(Employee $employee)
    {
        return view('employees.edit', compact('employee'));
    }

    // Update the database record
    public function update(Request $request, Employee $employee)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:employees,email,' . $employee->id,
            'position' => 'required',
            'salary' => 'required|numeric',
        ]);

        $employee->update($data);

        return redirect()->route('employees.index')->with('success', 'Employee updated!');
    }

    // Save the new employee
    public function store(Request $request) {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:employees',
            'position' => 'required',
            'salary' => 'required|numeric',
        ]);

        Employee::create($data);
        return redirect()->route('employees.index');
    }

    // Remove an employee
    public function destroy(Employee $employee) {
        $employee->delete();
        return redirect()->route('employees.index');
    }
}