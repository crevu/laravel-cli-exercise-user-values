<?php

namespace Tests\Unit\app\Services\Searchers;

use App\Models\User;
use App\Services\Searchers\UserSearcher;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Mockery\Mock;

/**
 * class UserSearcherTest
 *
 * @package Tests\Unit\app\Services\Searchers
 */
class UserSearcherTest extends MockeryTestCase
{
    /** @var UserSearcher|Mock */
    private $userSearcher;

    public function setUp(): void
    {
        parent::mockeryTestSetUp();

        $user1 = Mockery::mock(User::class, ['1', 'horia.muntean@arnia.ro']);
        $user1->shouldReceive('getEmail')->andReturn('horia.muntean@arnia.ro');
        $user1->shouldReceive('getId')->andReturn('1');

        $user2 = Mockery::mock(User::class, ['2', 'gigi.carturescu@citesc.ro']);
        $user2->shouldReceive('getEmail')->andReturn('gigi.carturescu@citesc.ro');
        $user1->shouldReceive('getId')->andReturn('2');

        $users = [$user1, $user2];

        $this->userSearcher = Mockery::mock(UserSearcher::class, [$users])->makePartial();
    }

    /**
     * @return array[]
     */
    public function searchByEmailProvider(): array
    {
        return [
            'email exists'         => [
                'email'        => 'horia.muntean@arnia.ro',
                'expectedUserId' => '1',
            ],
            'email does not exist' => [
                'email'        => 'whatever',
                'expectedUserId' => null,
            ],
        ];
    }

    /**
     * @dataProvider searchByEmailProvider
     *
     * @param string      $email
     * @param string|null $expectedUserId
     *
     * @return void
     */
    public function testSearchByEmail(string $email, ?string $expectedUserId): void
    {
        $actualResult = $this->userSearcher->searchByEmail($email);

        if ($expectedUserId === null) {
            self::assertEquals($expectedUserId, $actualResult);
            return ;
        }

        self::assertEquals($expectedUserId, $actualResult->getId());
    }
}
