<?php
namespace Test\Feature\CleanRegex\Match\Detail\group;

use PHPUnit\Framework\TestCase;
use TRegx\CleanRegex\Pattern;

/**
 * @covers \TRegx\CleanRegex\Internal\GroupKey\GroupKey
 * @covers \TRegx\CleanRegex\Internal\GroupKey\Group
 */
class GroupIdentifierTest extends TestCase
{
    /**
     * @test
     */
    public function shouldBeValidGroup()
    {
        // given
        $detail = Pattern::of($pattern)->match('Foo')->first();
        // when
        $identifier = $detail->group($groupIdentifier)->usedIdentifier();
        // then
        $this->assertSame($identifier, $groupIdentifier);
    }
}
