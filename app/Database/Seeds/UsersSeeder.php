<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run()
    {
         $data = [
            'name'          => 'Admin',
            'email'         => 'admin@example.com',
            'password_hash' => password_hash('admin123', PASSWORD_DEFAULT),
            'role'          => 'admin',
            'is_active'     => 'active',
        ];

        $this->db->table('users')->insert($data);
    }
}
