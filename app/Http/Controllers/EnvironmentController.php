<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PosEnvironment;
use Illuminate\Support\Str;

class EnvironmentController extends Controller
{
    public function create()
    {
        if (auth()->user()->role !== 'admin' || auth()->user()->pos_environment_id) {
            return redirect()->route('dashboard')->with('error', 'You cannot create an environment.');
        }

        return view('environment.create');
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin' || auth()->user()->pos_environment_id) {
            return redirect()->route('dashboard');
        }

        $joinCode = strtoupper(Str::random(6));

        $environment = PosEnvironment::create([
            'admin_id' => auth()->id(),
            'join_code' => $joinCode,
            'code_updated_at' => now(),
        ]);

        $user = auth()->user();
        $user->pos_environment_id = $environment->id;
        $user->save();

        return redirect()->route('dashboard')->with('success', 'POS Environment created successfully. Your join code is ' . $joinCode);
    }

    public function join()
    {
        if (auth()->user()->pos_environment_id) {
            return redirect()->route('dashboard');
        }

        return view('environment.join');
    }

    public function processJoin(Request $request)
    {
        $request->validate([
            'join_code' => 'required|string|size:6'
        ]);

        $environment = PosEnvironment::where('join_code', strtoupper($request->join_code))->first();

        if (!$environment) {
            return back()->with('error', 'Invalid Join Code.');
        }

        $user = auth()->user();
        $user->pos_environment_id = $environment->id;
        $user->save();

        return redirect()->route('dashboard')->with('success', 'Successfully joined the environment.');
    }

    public function rotateCode(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            return back()->with('error', 'Unauthorized.');
        }

        $environment = PosEnvironment::find(auth()->user()->pos_environment_id);
        if ($environment && $environment->admin_id === auth()->id()) {
            $environment->join_code = strtoupper(Str::random(6));
            $environment->code_updated_at = now();
            $environment->save();
            return back()->with('success', 'Join code regenerated: ' . $environment->join_code);
        }

        return back()->with('error', 'Could not regenerate code.');
    }

    public function kickEmployee(\App\Models\User $user)
    {
        if (auth()->user()->role !== 'admin') {
            return back()->with('error', 'Unauthorized.');
        }

        if ($user->pos_environment_id !== auth()->user()->pos_environment_id) {
            return back()->with('error', 'User is not in your environment.');
        }

        $user->pos_environment_id = null;
        $user->save();

        return back()->with('success', 'Employee removed from environment.');
    }
}
