<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()['cache']->forget('spatie.permission.cache');
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();


        //creating two roles admin and mod
        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $mod = Role::firstOrCreate(['name' => 'mod', 'guard_name' => 'web']);
        $normal = Role::firstOrCreate(['name' => 'normal', 'guard_name' => 'web']);

        //creating admin user with higher privellege
        if (!Role::where('name', 'admin')->exists()) {
            Role::create(['name' => 'admin']);
        }

        if (!Role::where('name', 'mod')->exists()) {
            Role::create(['name' => 'mod']);
        }
        $adminUser = User::firstOrCreate(
            ['email' => 'hass@swansea.ac.uk'],
            [
                'username' => 'Hassan bin Ali',
                'first_name' => 'Hassan',
                'last_name' => 'Bin Ali',
                'phone_number' => '0937647433',

                'password' => Hash::make('Swansea123@')
            ]
        );
        $adminUser->assignRole('admin');

        // Create moderator user with some privillege
        $modUser = User::firstOrCreate(
            ['email' => 'projectmy32@gmail.com'],
            [
                'username' => 'Hussein bin ali',
                'first_name' => 'Hussein',
                'last_name' => 'Bin Ali',
                'phone_number' => '0937647433',
                
                'password' => Hash::make('Swansea123@')
            ]
        );
        $modUser->assignRole('mod');
        
        //creating normal user
        $normal = User::firstOrCreate(
            ['email' => 'aminah.alzahra@example.com'],
            [
                'username' => 'AminahZahra',
                'first_name' => 'Aminah',
                'last_name' => 'Al Zahra',
                'phone_number' => '0921000001',
                'password' => Hash::make('UniquePass1@')
            ]
        );

        $normal = User::firstOrCreate(
            ['email' => 'basim.fayyad@example.com'],
            [
                'username' => 'BasimFayyad',
                'first_name' => 'Basim',
                'last_name' => 'Fayyad',
                'phone_number' => '0921000002',
                'password' => Hash::make('UniquePass2@')
            ]
        );

        $normal = User::firstOrCreate(
            ['email' => 'chirine.najem@example.com'],
            [
                'username' => 'ChirineNajem',
                'first_name' => 'Chirine',
                'last_name' => 'Najem',
                'phone_number' => '0921000003',
                'password' => Hash::make('UniquePass3@')
            ]
        );

        $normal = User::firstOrCreate(
            ['email' => 'daoud.khalid@example.com'],
            [
                'username' => 'DaoudKhalid',
                'first_name' => 'Daoud',
                'last_name' => 'Khalid',
                'phone_number' => '0921000004',
                'password' => Hash::make('UniquePass4@')
            ]
        );

        $normal = User::firstOrCreate(
            ['email' => 'elias.mourad@example.com'],
            [
                'username' => 'EliasMourad',
                'first_name' => 'Elias',
                'last_name' => 'Mourad',
                'phone_number' => '0921000005',
                'password' => Hash::make('UniquePass5@')
            ]
        );

        $normal = User::firstOrCreate(
            ['email' => 'fadwa.ramzi@example.com'],
            [
                'username' => 'FadwaRamzi',
                'first_name' => 'Fadwa',
                'last_name' => 'Ramzi',
                'phone_number' => '0921000006',
                'password' => Hash::make('UniquePass6@')
            ]
        );

        $normal = User::firstOrCreate(
            ['email' => 'ghassan.karam@example.com'],
            [
                'username' => 'GhassanKaram',
                'first_name' => 'Ghassan',
                'last_name' => 'Karam',
                'phone_number' => '0921000007',
                'password' => Hash::make('UniquePass7@')
            ]
        );

        $normal = User::firstOrCreate(
            ['email' => 'hani.mansour@example.com'],
            [
                'username' => 'HaniMansour',
                'first_name' => 'Hani',
                'last_name' => 'Mansour',
                'phone_number' => '0921000008',
                'password' => Hash::make('UniquePass8@')
            ]
        );

        $normal = User::firstOrCreate(
            ['email' => 'ismail.fayad@example.com'],
            [
                'username' => 'IsmailFayad',
                'first_name' => 'Ismail',
                'last_name' => 'Fayad',
                'phone_number' => '0921000009',
                'password' => Hash::make('UniquePass9@')
            ]
        );

        $normal = User::firstOrCreate(
            ['email' => 'jumana.nassar@example.com'],
            [
                'username' => 'JumanaNassar',
                'first_name' => 'Jumana',
                'last_name' => 'Nassar',
                'phone_number' => '0921000010',
                'password' => Hash::make('UniquePass10@')
            ]
        );
      
        $normal->assignRole('normal');


    }
}
