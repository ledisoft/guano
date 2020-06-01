<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(User $model)
    {
        /** @var array $users */
        $users = config('default.user');

        array_map(function ($item) use ($model) {

            /** @var array $roles */
            $roles = $item['roles'];

            unset($item['roles']);

            $user = $model->create($item);

            array_map(function ($role) use ($user) {
                $user->assignRole($role);
            }, $roles);

        }, $users);
    }
}
