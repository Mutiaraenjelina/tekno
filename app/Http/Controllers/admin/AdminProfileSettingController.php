<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminProfileSettingController extends Controller
{
    private string $settingsPath;

    public function __construct()
    {
        $this->settingsPath = storage_path('app/admin_settings.json');
    }

    public function profile(): View
    {
        return view('admin.Settings.profile', [
            'user' => Auth::user(),
        ]);
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'username' => ['required', 'string', 'max:100', Rule::unique('users', 'username')->ignore($user->id)],
            'email' => ['nullable', 'email', 'max:150', Rule::unique('users', 'email')->ignore($user->id)],
        ], [
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
        ]);

        $user->username = $validated['username'];
        $user->email = $validated['email'] ?? null;
        $user->save();

        return redirect()->route('Admin.profile')->with('success', 'Profil admin berhasil diperbarui.');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'current_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'new_password.required' => 'Password baru wajib diisi.',
            'new_password.min' => 'Password baru minimal 8 karakter.',
            'new_password.confirmed' => 'Konfirmasi password baru tidak sesuai.',
        ]);

        if (! Hash::check($validated['current_password'], $user->password)) {
            return redirect()->route('Admin.profile')->with('error', 'Password saat ini tidak benar.');
        }

        $user->password = Hash::make($validated['new_password']);
        $user->save();

        return redirect()->route('Admin.profile')->with('success', 'Password berhasil diubah.');
    }

    public function settings(): View
    {
        $defaults = [
            'app_name' => config('app.name', 'Tapatupa'),
            'app_description' => 'Sistem informasi tagihan dan pembayaran.',
            'support_whatsapp' => '',
        ];

        return view('admin.Settings.settings', [
            'settings' => $this->readSettings($defaults),
        ]);
    }

    public function updateSettings(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'app_name' => ['required', 'string', 'max:120'],
            'app_description' => ['nullable', 'string', 'max:255'],
            'support_whatsapp' => ['nullable', 'string', 'max:30'],
        ], [
            'app_name.required' => 'Nama aplikasi wajib diisi.',
            'app_name.max' => 'Nama aplikasi maksimal 120 karakter.',
            'app_description.max' => 'Deskripsi maksimal 255 karakter.',
            'support_whatsapp.max' => 'Nomor WhatsApp maksimal 30 karakter.',
        ]);

        $payload = [
            'app_name' => $validated['app_name'],
            'app_description' => $validated['app_description'] ?? '',
            'support_whatsapp' => $validated['support_whatsapp'] ?? '',
            'updated_at' => now()->toDateTimeString(),
            'updated_by' => Auth::id(),
        ];

        File::put($this->settingsPath, json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        return redirect()->route('Admin.settings')->with('success', 'Pengaturan berhasil disimpan.');
    }

    private function readSettings(array $defaults): array
    {
        if (! File::exists($this->settingsPath)) {
            return $defaults;
        }

        $content = File::get($this->settingsPath);
        $decoded = json_decode($content, true);

        if (! is_array($decoded)) {
            return $defaults;
        }

        return [
            'app_name' => $decoded['app_name'] ?? $defaults['app_name'],
            'app_description' => $decoded['app_description'] ?? $defaults['app_description'],
            'support_whatsapp' => $decoded['support_whatsapp'] ?? $defaults['support_whatsapp'],
        ];
    }
}
