<?php

namespace App\Http\Controllers\Web\Backend;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SettingController extends Controller
{
    public function appSettingEdit()
    {
        $setting = Setting::first();
        return view('backend.layouts.settings.app_setting', compact('setting'));
    }

    public function appSettingUpdate(Request $request)
    {
        // ✅ Validate incoming request
        $request->validate([
            'app_name'           => 'required|string|max:255',
            'tagline'            => 'nullable|string|max:255',
            'logo'               => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg',
            'footer_logo'        => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg',
            'favicon'            => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg',
            'phone'              => 'nullable|string|max:255',
            'email'              => 'nullable|email|max:255',
            'address'            => 'nullable|string|max:255',
            'footer_description' => 'nullable|string',
            'copy_right_text'    => 'nullable|string|max:255',
            'meta_keywords'      => 'nullable|string|max:255',
            'meta_description'   => 'nullable|string',
        ]);

        try {
            // 🔍 Try to get the setting or initialize a new one
            $setting = Setting::first() ?? new Setting();

            // 🗂️ Prepare data for update/create
            $data = $request->only([
                'tagline',
                'phone',
                'email',
                'address',
                'footer_description',
                'copy_right_text',
                'meta_keywords',
                'meta_description',
            ]);

            // 📤 Handle image fields
            foreach (['logo', 'footer_logo', 'favicon'] as $field) {
                if ($request->hasFile($field)) {
                    // Delete old image if it exists (for update case)
                    if ($setting->exists && $setting->$field && file_exists(public_path($setting->$field))) {
                        Helper::fileDelete($setting->$field);
                    }

                    // Upload new image
                    $randomName = Str::random(10);
                    $data[$field] = Helper::fileUpload($request->file($field), 'settings', $randomName);
                }
            }

            // ✅ Update APP_NAME in .env
            if ($request->has('app_name')) {
                $this->updateEnvVariable('APP_NAME', $request->app_name);
            }


            // 💾 Save the record (create or update)
            $setting->fill($data)->save();

            return redirect()->back()->with('t-success', 'App settings saved successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('t-error', $e->getMessage());
        }
    }



    protected function updateEnvVariable($key, $value)
    {
        $path = base_path('.env');

        if (!file_exists($path)) {
            return false;
        }

        $env = file_get_contents($path);

        $pattern = "/^{$key}=.*/m";

        $line = "{$key}=\"{$value}\"";

        if (preg_match($pattern, $env)) {
            // Replace existing key
            $env = preg_replace($pattern, $line, $env);
        } else {
            // Append to end of file if key doesn't exist
            $env .= "\n{$line}";
        }

        file_put_contents($path, $env);

        // Optional: update config at runtime for immediate effect
        if ($key === 'APP_NAME') {
            config(['app.name' => $value]);
        }

        return true;
    }


}
