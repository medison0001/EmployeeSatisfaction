<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;

class EmployeeController extends Controller
{
    // Mostrar la lista de empleados con paginación y búsqueda
public function index(Request $request)
{
    $query = Employee::query();

    if ($request->has('search')) {
        $search = $request->input('search');
        $query->where('name', 'like', "%$search%")
              ->orWhere('email', 'like', "%$search%")
              ->orWhere('area', 'like', "%$search%")
              ->orWhere('company', 'like', "%$search%")
              ->orWhere('category', 'like', "%$search%")
              ->orWhere('satisfaction_level', 'like', "%$search%");
    }

    if ($request->has('sortBy')) {
        $sortBy = $request->input('sortBy');
        $order = $request->input('order', 'asc');
        $query->orderBy($sortBy, $order);
    }

    $limit = $request->input('limit', 5); // default to 5
    $employees = $query->paginate($limit);

    return response()->json($employees);
}

    
    


    // Crear un nuevo empleado
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'email' => 'required|email|max:255',
            'area' => 'required|string|max:255',
            'category' => 'required|in:Empleado,Directivo,Contratista',
            'logo' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'satisfaction_level' => 'required|integer|between(0,100)',
        ]);

        $employee = Employee::create($validatedData);

        return response()->json($employee, 201);
    }

    // Mostrar un empleado específico
    public function show($id)
    {
        $employee = Employee::findOrFail($id);
        return response()->json($employee);
    }

    // Actualizar un empleado específico
    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'date' => 'sometimes|required|date',
            'email' => 'sometimes|required|email|max:255',
            'area' => 'sometimes|required|string|max:255',
            'category' => 'sometimes|required|in:Empleado,Directivo,Contratista',
            'company' => 'sometimes|required|string|max:255',
            'satisfaction_level' => 'sometimes|required|integer|between(0,100)',
        ]);

        $employee->update($validatedData);

        return response()->json($employee);
    }

    // Eliminar un empleado específico
    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();

        return response()->json(null, 204);
    }
}
