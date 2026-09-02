<?php

namespace App\Http\Controllers;

use App\Models\Auditoria;
use Inertia\Inertia;

class AuditoriaController extends Controller
{
    public function index()
    {
        $auditorias = Auditoria::with('usuario:id,name')
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return Inertia::render('Auditorias/Index', [
            'auditorias' => $auditorias,
        ]);
    }
}