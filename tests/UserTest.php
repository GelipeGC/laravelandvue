<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
	use DatabaseTransactions;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        factory(\App\User::class)->create(['name' => 'Felipe']);

        $this->get('name')
            ->assertResponseOk();

            $this->seeText('Felipe');    }
}
