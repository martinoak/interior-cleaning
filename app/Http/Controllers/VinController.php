<?php

namespace App\Http\Controllers;

use App\Models\Vin;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use InvalidArgumentException;
use Sunrise\Vin\Vin as ParserVin;

class VinController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $cars = Vin::all();

        return view('admin.vin.index', compact('cars'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            $vin = new ParserVin($request->input('vin'));

            if (Vin::find($vin->getVin())) {
                return back()->with('error','VIN již existuje.')->withInput();
            }

            Vin::create([
                'vin' => $vin->getVin(),
                'name' => $request->input('name'),
                'manufacturer' => $vin->getManufacturer(),
                'model' => $request->input('model'),
                'engine' => $request->input('engine'),
                'year' => implode(',', $vin->getModelYear()),
                'note' => $request->input('note'),
            ]);

            return to_route('vin.index')->with('success','VIN byl úspěšně uložen.');
        } catch (InvalidArgumentException $e) {
           return back()->with('error','VIN není validný, zadej údaje ručně.')->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $vin): View
    {
        $car = Vin::find($vin);

        return view('admin.vin.edit', compact('car'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $vin): RedirectResponse
    {
        Vin::find($vin)->update($request->all());

        return to_route('vin.index')->with('success','VIN byl úspěšně upraven.');
    }

    public function destroy(string $vin): RedirectResponse
    {
        Vin::destroy($vin);

        return back()->with('success','VIN byl úspěšně smazán.');
    }
}
