<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\DiscordBot;

use Courage\CoString;
use Domain\DiscordBot\BotCommand;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BotCommandTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @dataProvider displayNameProvider
     * @return void
     */
    public function testDisplayName(CoString $displayName, BotCommand $command)
    {
        $this->assertEquals(
            $displayName,
            $command->displayName(),
        );
    }

    public function displayNameProvider() :array
    {
        return [
            'hello' => [
                new CoString('hello'),
                BotCommand::HELLO
            ],
            'registerDrug' => [
                new CoString('薬物登録'),
                BotCommand::REGISTER_DRUG,
            ],
            'medication' => [
                new CoString('のんだ'),
                BOtCommand::MEDICATION,
            ],
        ];
    }

    /**
     * @dataProvider makeFromDisplayNameProvider
     * @return void
     */
    public function testMakeFromDisplayName(string $displayName, BotCommand $command)
    {
        $this->assertEquals(
            $command,
            BotCommand::makeFromDisplayName($displayName),
        );
    }

    public function makeFromDisplayNameProvider(): array
    {
        return [
            [
                'hello',
                BotCommand::HELLO,
            ],
            [
                '薬物登録',
                BotCommand::REGISTER_DRUG,
            ],
            [
                'のんだ',
                BotCommand::MEDICATION,
            ]
        ];
    }
}
