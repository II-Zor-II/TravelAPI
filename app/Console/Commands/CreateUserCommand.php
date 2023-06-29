<?php

namespace App\Console\Commands;

use App\Models\Role;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;

class CreateUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates new User';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $user['name'] = $this->ask('Name: ');

        $user['email'] = $this->ask('Email: ');

        $user['password'] = $this->secret('Password: ');

        $roleName = $this->choice('User Role: ', ['admin', 'editor'], 1);

        $validator = Validator::make($user, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', Password::defaults()],
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            return;
        }

        $role = Role::where('name', $roleName)->first();
        if (!$role) {
            $this->error('Role not found');

            return;
        }

        DB::transaction(function () use ($user, $role) {
            $user = User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => Hash::make($user['password']),
            ]);
            $user->roles()->attach($role->id);
        });

        $this->info('User: ' . $user['email'] . ' created successfully.');

        return Command::SUCCESS;
    }
}
