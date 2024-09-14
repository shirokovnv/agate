<?php

declare(strict_types=1);

namespace Tests\Unit\Gateway\Routing;

use App\Gateway\Contracts\Routing\PatternMatcherInterface;
use Tests\TestCase;

class PatternMatcherTest extends TestCase
{
    protected PatternMatcherInterface $patternMatcher;

    protected function setUp(): void
    {
        parent::setUp();
        $this->patternMatcher = $this->app->make(PatternMatcherInterface::class);
    }

    protected function tearDown(): void
    {
        unset($this->patternMatcher);
        parent::tearDown();
    }

    /**
     * @dataProvider patternProvider
     */
    public function testMatchesWithPath(string $path, array $patterns, array $matches): void
    {
        $matchResult = [];
        foreach ($patterns as $pattern) {
            [$match, $params] = $this->patternMatcher->matchWithPath($pattern, $path);

            $matchResult[] = $match;
        }

        $this->assertEquals($matches, $matchResult);
    }

    public static function patternProvider(): array
    {
        return [
            'have-exact-one-match' => [
                '/test/1',
                [
                    '/test',
                    '/test/{ID}',
                    '/bla-bla',
                ],
                [
                    false, true, false,
                ],
            ],
            'dont-have-any-matches' => [
                '/test/1',
                [
                    '/comments/{ID}',
                    '/testing/{ID}',
                    '/test/{ID}/todos',
                ],
                [false, false, false],
            ],
        ];
    }
}
