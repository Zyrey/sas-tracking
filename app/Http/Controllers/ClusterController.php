<?php

namespace App\Http\Controllers;

use App\Cluster;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ClusterController extends Controller
{
    public function index()
    {
        // $clusters = Cluster::orderBy('cluster', 'asc')->paginate(10);
        return view('clusters.index');
        // $cluster = Cluster::all();
        // dd($cluster);
        // return view('cluster.index', compact('cluster'));
        // return response()->json($cluster);
        // return $cluster;
    }

    public function list(){
        $clusters = Cluster::orderBy('cluster', 'asc')->get();
        return $clusters;
    }

    public function create(Cluster $cluster)
    {
        return view('cluster.create', compact('cluster'));
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'cluster' => [
                'required', 'string', 'min:3', 'max:225', 'unique:clusters,cluster', 'regex:/^[A-Za-z\s]+$/',
            ]
        ]);

        $cluster = Cluster::create($validatedData);

        return redirect(route('clusters.show', $cluster->id))
            ->with('message', 'Cluster created successfully.');
    }


    public function show(Cluster $cluster)
    {
        return view('cluster.show', compact('cluster'));
    }


    public function edit(Cluster $cluster)
    {
        return view('cluster.edit', compact('cluster'));
    }


    public function update(Request $request, Cluster $cluster)
    {
        $validatedData = $request->validate([
            'cluster' => [
                'required', 'string', 'min:3', 'max:225', 'regex:/^[A-Za-z\s]+$/',
                Rule::unique('clusters')->ignore($cluster->id)
            ]
        ]);

        $cluster->update($validatedData);

        return redirect(route('clusters.show', $cluster->id))
            ->with('message', 'Cluster updated successfully.');
    }

}
