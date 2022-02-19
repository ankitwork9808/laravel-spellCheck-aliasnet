<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    // use DatabaseMigrations;
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testExample()
    {
        $user = User::factory()->create();

        $this->browse(function ($browser) use ($user) {
            $browser->visit('/login')
                    ->type('email', 'admin@gmail.com')
                    ->type('password', 'dev@2000')
                    ->press('Login')
                    ->assertPathIs('/admin/dashboard');
        });
    }
}
