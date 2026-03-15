<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $services = Service::paginate(1);

         return view('dashboard', compact('services'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nome' => 'required|string|max:255',
            'valor' => 'required|numeric',
            'descricao' => 'nullable|string',
        ]);

        Service::create($validatedData);

           return redirect()
            ->route('dashboard')
            ->with('success', 'Serviço criado com sucesso!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $service = Service::findOrFail($id);
        $validatedData = $request->validate([
            'nome' => 'required|string|max:255',
            'valor' => 'required|numeric',
            'descricao' => 'nullable|string',
        ]);

        $service->update($validatedData);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Serviço atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $service = Service::findOrFail($id);
        $service->delete();

         return redirect()
            ->route('dashboard')
            ->with('success', 'Serviço excluído com sucesso!');
    }
}
