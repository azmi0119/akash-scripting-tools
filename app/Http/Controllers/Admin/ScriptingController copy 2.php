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
        $scripts = Script::orderBy('id', 'desc')->get();
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
            'domain' => 'required',
            'cart_addon' => 'required',
            'name' => 'required',
            'host' => 'required',
            'tracking_time' => 'required|integer',
            'convert_click' => 'required|integer',
            'device_type' => 'required|array',
            'social_media' => 'nullable|array',
            'tracking_one_url' => 'required|url',
            'main_domain' => 'required',
            'off_location' => 'required',
            'country' => 'required|array',
        ]);

        // Map device type values to readable names
        $deviceMap = ['0' => 'Mobile', '1' => 'Tablet', '2' => 'Desktop'];
        $selectedDevices = array_map(fn($v) => $deviceMap[$v] ?? $v, $request->device_type);

        // Map social media values to domain names
        $socialMediaMap = [
            '1' => 'facebook.com',
            '2' => 'instagram.com',
            '3' => 'pinterest.com',
            '4' => 'twitter.com',
            '5' => 'linkedin.com',
            '6' => 'snapchat.com',
            '7' => 'tiktok.com'
        ];
        $excludedSocialMedia = $request->social_media ? array_map(fn($v) => $socialMediaMap[$v] ?? $v, $request->social_media) : [];

        // Get country ISO2 codes from country IDs
        $countries = Country::whereIn('id', $request->country)->pluck('iso2')->map(fn($c) => strtoupper($c))->toArray();

        // Generate the JavaScript
        $javascriptScript = $this->generateRedirectionScript([
            'host' => $request->host,
            'tracking_time' => $request->tracking_time,
            'daily_limit' => $request->convert_click,
            'target_devices' => $selectedDevices,
            'excluded_social_media' => $excludedSocialMedia,
            'target_countries' => $countries,
            'tracking_url' => $request->tracking_one_url,
            'main_domain' => $request->main_domain,
            'off_location' => $request->off_location == '1'
        ]);

        // Save to database
        Script::create([
            'domain' => $request->domain,
            'cart_addon' => $request->cart_addon,
            'name' => $request->name,
            'host' => $request->host,
            'tracking_time' => $request->tracking_time,
            'convert_click' => $request->convert_click,
            'device_type' => json_encode($request->device_type),
            'social_media' => json_encode($request->social_media),
            'tracking_one_url' => $request->tracking_one_url,
            'main_domain' => $request->main_domain,
            'off_location' => $request->off_location,
            'country' => json_encode($request->country),
            'generated_script' => $javascriptScript,
            'status' => 'active'
        ]);

        // Create JS file inside public/assets/scripts
        $scriptPath = public_path('assets/scripts/' . $request->domain . '.js');
        if (!file_exists(public_path('assets/scripts'))) mkdir(public_path('assets/scripts'), 0755, true);
        file_put_contents($scriptPath, $javascriptScript);

        return redirect()->route('admin.script.index')->with('success', 'Script created successfully!');
    }

    private function generateRedirectionScript($config)
    {
        $socialMediaSites = json_encode($config['excluded_social_media']);
        $targetDevices = json_encode($config['target_devices']);
        $targetCountries = json_encode($config['target_countries']);
        $offLocation = $config['off_location'] ? 'true' : 'false';

        return "// IntelliRedirect Pro - Advanced Redirection System
            (function() {
                var targetWebsites = [\"{$config['host']}\"];

                var redirectTo = \"{$config['tracking_url']}\";
                var trackingTime = {$config['tracking_time']};

                var excludeSocialMedia = true;
                var socialMediaSites = {$socialMediaSites};
                var targetDevices = {$targetDevices};
                var targetCountries = {$targetCountries};
                var dailyLimit = {$config['daily_limit']};
                var mainDomain = \"{$config['main_domain']}\";
                var offLocation = {$offLocation};

                var currentHostname = window.location.hostname.toLowerCase();
                var normalizedHostname = currentHostname.replace(/^www\\./, '');
                var isLocalFile = (window.location.protocol === 'file:');

                var isTargetWebsite = isLocalFile || targetWebsites.some(function(site) {
                    return normalizedHostname === site.toLowerCase();
                });
                if (!isTargetWebsite) return;

                var isSocialMedia = normalizedHostname && socialMediaSites.some(function(site) {
                    return normalizedHostname.includes(site.toLowerCase());
                });
                if (excludeSocialMedia && isSocialMedia) return;

                var userDevice = getDeviceType();
                if (targetDevices.indexOf(userDevice) === -1) return;

                var userCountry = getUserCountry();
                if (!isLocalFile && targetCountries.length > 0 && targetCountries.indexOf(userCountry) === -1) return;

                if (!isLocalFile && isDailyLimitReached(dailyLimit)) return;

                if (!isLocalFile && offLocation && !isOnTargetLocation()) return;

                var storageKey = 'visitCount_' + (normalizedHostname || 'localfile');
                var visitCount = parseInt(localStorage.getItem(storageKey)) || 0;
                visitCount++;
                localStorage.setItem(storageKey, visitCount);

                setTimeout(function() {
                    if (!isLocalFile) incrementDailyConversions();
                    window.location.href = redirectTo;
                }, trackingTime * 1000);

                function getDeviceType() {
                    if (window.innerWidth <= 768) return 'Mobile';
                    if (window.innerWidth <= 1024) return 'Tablet';
                    return 'Desktop';
                }

                function getUserCountry() {
                    var lang = navigator.language || navigator.userLanguage || 'en-US';
                    return (lang.split('-')[1] || 'US').toUpperCase();
                }

                function isDailyLimitReached(limit) {
                    var today = new Date().toDateString();
                    var conversions = parseInt(localStorage.getItem('dailyConversions_' + today)) || 0;
                    return conversions >= limit;
                }

                function incrementDailyConversions() {
                    var today = new Date().toDateString();
                    var conversions = parseInt(localStorage.getItem('dailyConversions_' + today)) || 0;
                    localStorage.setItem('dailyConversions_' + today, conversions + 1);
                }

                function isOnTargetLocation() {
                    var mainHost = mainDomain.replace(/^https?:\\/\\//, '').replace(/\\/$/, '');
                    return normalizedHostname === mainHost;
                }
            })();";
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

        // decode JSON string to PHP array
        $script->device_type  = json_decode($script->device_type, true);
        $script->social_media = json_decode($script->social_media, true);
        $script->country      = json_decode($script->country, true);

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
