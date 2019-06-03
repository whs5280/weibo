<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $users = factory(User::class)->times(20)->make();
        User::insert($users->makeVisible(['password', 'remember_token'])->toArray());

        $user = User::find(1);
        $user->name = 'Tony';
        $user->email = 'whs@qq.com';
        $user->password = Hash::make('123456');
        $user->save();

        $user = User::find(2);
        $user->name = 'Money';
        $user->email = '123@qq.com';
        $user->password = Hash::make('123456');
        $user->save();
    }
}
