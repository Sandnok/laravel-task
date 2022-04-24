<?php

declare(strict_types=1);

namespace Tests\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

/**
 * Class UserControllerTest
 *
 * @package \Tests\Http\Controllers
 * @coversDefaultClass \App\Http\Controllers\UserController
 */
class UserControllerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @covers ::index
     *
     * @return void
     */
    public function testIndexStructure(): void
    {
        $users = User::factory()->count(5)->create();

        $response = $this->getJson(route('users.index'));

        $response->assertOk();
        $response->assertJsonStructure([
            [
                'id',
                'name',
                'created_at',
                'updated_at',
            ],
        ]);

        $this->assertCount($users->count(), $response->json());
    }

    /**
     * @covers ::store
     *
     * @return void
     */
    public function testStoreSuccess(): void
    {
        $data = [
            'name' => 'hoge',
        ];

        $response = $this->postJson(route('users.store'), $data);

        $response->assertOk();
        $response->assertJsonStructure([
            'id',
            'name',
            'created_at',
            'updated_at',
        ]);

        $this->assertDatabaseHas((new User())->getTable(), $data);
    }

    /**
     * @covers ::store
     *
     * @dataProvider storeIfNameIsValidationErrorDataProvider
     *
     * @param $name
     *
     * @return void
     */
    public function testStoreIfNameIsValidationError($name): void
    {
        $data = [
            'name' => $name,
        ];

        $response = $this->postJson(route('users.store'), $data);

        $response->assertUnprocessable();
    }

    /**
     * @return array
     */
    public function storeIfNameIsValidationErrorDataProvider(): array
    {
        return [
            'required' => [null],
            'string'   => [1],
        ];
    }

    /**
     * @covers ::show
     *
     * @return void
     */
    public function testShowStructure(): void
    {
        /** @var \App\Models\User $user */
        $user = user::factory()->create();

        $response = $this->getjson(route('users.show', $user->id));

        $response->assertOk();
        $response->assertjsonstructure([
            'id',
            'name',
            'created_at',
            'updated_at',
        ]);
    }

    /**
     * @covers ::update
     *
     * @return void
     */
    public function testUpdateSuccess(): void
    {
        $data = [
            'name' => 'fuga',
        ];

        /** @var \App\Models\User $user */
        $user = user::factory()->create([
            'name' => 'hoge',
        ]);

        $response = $this->putJson(route('users.update', $user->id), $data);

        $response->assertOk();
        $response->assertjsonstructure([
            'id',
            'name',
            'created_at',
            'updated_at',
        ]);

        $this->assertDatabaseHas((new User())->getTable(), $data);
    }

    /**
     * @covers ::update
     *
     * @dataProvider updateIfNameIsValidationErrorDataProvider
     *
     * @param $name
     *
     * @return void
     */
    public function testUpdateIfNameIsValidationError($name): void
    {
        $data = [
            'name' => $name,
        ];

        /** @var \App\Models\User $user */
        $user = user::factory()->create();

        $response = $this->putJson(route('users.update', $user->id), $data);

        $response->assertUnprocessable();
    }

    /**
     * @return array
     */
    public function updateIfNameIsValidationErrorDataProvider(): array
    {
        return [
            'required' => [null],
            'string'   => [1],
        ];
    }

    /**
     * * @covers ::destroy
     *
     * @return void
     */
    public function testDestroySuccess(): void
    {
        /** @var \App\Models\User $user */
        $user = user::factory()->create();

        $response = $this->deleteJson(route('users.destroy', $user->id));

        $response->assertNoContent();

        $this->assertDatabaseMissing((new User())->getTable(), [
            'name' => $user->name,
        ]);
    }
}
