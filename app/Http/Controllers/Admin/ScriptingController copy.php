<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Master\City;
use App\Models\Master\State;
use Illuminate\Http\Request;
use App\Models\Master\Country;
use App\Http\Requests\CreateUser;
use Spatie\Permission\Models\Role;
use App\Models\Models\Admin\Script;
use Flasher\Prime\FlasherInterface;
use App\Http\Controllers\Controller;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Session;

class ScriptingController extends Controller
{

    use HasRoles;

    function __construct()
    {
        $this->middleware('role_or_permission:SuperAdmin|User access|User create|User edit|User delete', ['only' => ['index', 'show']]);
        $this->middleware('role_or_permission:SuperAdmin|User create', ['only' => ['create', 'store']]);
        $this->middleware('role_or_permission:SuperAdmin|User edit', ['only' => ['edit', 'update']]);
        $this->middleware('role_or_permission:SuperAdmin|User delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $scripts = Script::all();
        return view('admin.scripting.index', compact('scripts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::all();
        $states = State::all();
        $cities = City::all();
        return view('admin.scripting.create', compact('countries', 'states', 'cities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',

            // all other fields optional
            'domain'           => 'nullable|string|max:255',
            'cart_addon'       => 'nullable|integer',
            'host'             => 'nullable|string|max:255',
            'tracking_time'    => 'nullable|integer',
            'convert_click'    => 'nullable|integer',
            'device_type'      => 'nullable|array',
            'social_media'     => 'nullable|array',
            'tracking_one_url' => 'nullable|string',
            'main_domain'      => 'nullable|string|max:255',
            'off_location'     => 'nullable|boolean',
            'country'          => 'nullable|array',
        ]);

        $script = new Script();
        $script->name             = $validated['name'];
        $script->domain           = $validated['domain'] ?? null;
        $script->cart_addon       = $validated['cart_addon'] ?? null;
        $script->host             = $validated['host'] ?? null;
        $script->tracking_time    = $validated['tracking_time'] ?? null;
        $script->convert_click    = $validated['convert_click'] ?? null;
        $script->device_type      = isset($validated['device_type']) ? json_encode($validated['device_type']) : null;
        $script->social_media     = isset($validated['social_media']) ? json_encode($validated['social_media']) : null;
        $script->tracking_one_url = $validated['tracking_one_url'] ?? null;
        $script->main_domain      = $validated['main_domain'] ?? null;
        $script->off_location     = $validated['off_location'] ?? 0;
        $script->country          = isset($validated['country']) ? json_encode($validated['country']) : null;
        $script->save();

        return redirect()->route('admin.script.index')->with('success', 'Script created successfully!');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $script = Script::findOrFail($id);
        $countries = Country::all();
        return view('admin.scripting.edit', compact('script', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'domain'           => 'nullable|string|max:255',
            'cart_addon'       => 'nullable|integer',
            'host'             => 'nullable|string|max:255',
            'tracking_time'    => 'nullable|integer',
            'convert_click'    => 'nullable|integer',
            'device_type'      => 'nullable|array',
            'social_media'     => 'nullable|array',
            'tracking_one_url' => 'nullable|string',
            'main_domain'      => 'nullable|string|max:255',
            'off_location'     => 'nullable|boolean',
            'country'          => 'nullable|array',
        ]);

        $script = Script::findOrFail($id);
        $script->fill([
            'name'             => $validated['name'],
            'domain'           => $validated['domain'] ?? null,
            'cart_addon'       => $validated['cart_addon'] ?? null,
            'host'             => $validated['host'] ?? null,
            'tracking_time'    => $validated['tracking_time'] ?? null,
            'convert_click'    => $validated['convert_click'] ?? null,
            'device_type'      => isset($validated['device_type']) ? json_encode($validated['device_type']) : null,
            'social_media'     => isset($validated['social_media']) ? json_encode($validated['social_media']) : null,
            'tracking_one_url' => $validated['tracking_one_url'] ?? null,
            'main_domain'      => $validated['main_domain'] ?? null,
            'off_location'     => $validated['off_location'] ?? 0,
            'country'          => isset($validated['country']) ? json_encode($validated['country']) : null,
        ]);
        $script->save();

        return redirect()->route('admin.script.index')->with('success', 'Script updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
