<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ShopSetting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Get all shop settings
     */
    public function index()
    {
        try {
            $settings = ShopSetting::getSettings();
            return response()->json([
                'success' => true,
                'data' => $settings,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching settings: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update shop settings
     */
    public function update(Request $request)
    {
        try {
            $validated = $request->validate([
                'shop_name' => 'nullable|string|max:255',
                'logo_url' => 'nullable|string|url',
                'phone' => 'nullable|string|max:20',
                'email' => 'nullable|email',
                'address' => 'nullable|string|max:255',
                'city' => 'nullable|string|max:255',
                'state' => 'nullable|string|max:255',
                'postal_code' => 'nullable|string|max:20',
                'description' => 'nullable|string',
                'facebook_url' => 'nullable|string|url',
                'twitter_url' => 'nullable|string|url',
                'instagram_url' => 'nullable|string|url',
                'linkedin_url' => 'nullable|string|url',
            ]);

            $settings = ShopSetting::first();
            if (!$settings) {
                $settings = ShopSetting::create($validated);
            } else {
                $settings->update($validated);
            }

            return response()->json([
                'success' => true,
                'message' => 'Settings updated successfully',
                'data' => $settings,
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating settings: ' . $e->getMessage(),
            ], 500);
        }
    }
}
