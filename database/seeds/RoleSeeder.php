<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @param Role $model
     * @return void
     */
    public function run(Role $model)
    {
        /** @var array $roles */
        $roles = config('default.role');

        array_map(function ($item) use ($model) {
            $model->create($item);
        }, $roles);
    }
}
