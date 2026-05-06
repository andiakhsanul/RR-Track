<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use InvalidArgumentException;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = config('rrtrack.admin');
        $password = (string) $admin['password'];

        $this->ensureStrongPassword($password);

        if (app()->isProduction() && hash_equals((string) $admin['default_password'], $password)) {
            throw new InvalidArgumentException('ADMIN_PASSWORD wajib diganti untuk environment production.');
        }

        User::updateOrCreate(
            ['email' => $admin['email']],
            [
                'name' => $admin['name'],
                'password' => Hash::make($password),
            ]
        );
    }

    private function ensureStrongPassword(string $password): void
    {
        $isStrong = strlen($password) >= 12
            && preg_match('/[A-Z]/', $password)
            && preg_match('/[a-z]/', $password)
            && preg_match('/[0-9]/', $password)
            && preg_match('/[^A-Za-z0-9]/', $password);

        if (! $isStrong) {
            throw new InvalidArgumentException(
                'ADMIN_PASSWORD minimal 12 karakter dan wajib berisi huruf besar, huruf kecil, angka, dan simbol.'
            );
        }
    }
}
