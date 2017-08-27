<?php

namespace HelpMeAbstract\Test\Unit\Transformer;

use HelpMeAbstract\Entity\User;
use HelpMeAbstract\Transformer\UserTransformer;
use Refinery29\Test\Util\TestHelper;

class UserTransformerTest extends \PHPUnit_Framework_TestCase
{
    use TestHelper;

    public function testTransform()
    {
        $faker = $this->getFaker();
        $user = $this->createMock(User::class);

        $id = $this->expectGetter($user, 'getId', $faker->uuid);
        $firstName = $this->expectGetter($user, 'getFirstName', $faker->word);
        $lastName = $this->expectGetter($user, 'getLastName', $faker->word);
        $email = $this->expectGetter($user, 'getEmail', $faker->email);
        $twitterHandle = $this->expectGetter($user, 'getTwitterHandle', $faker->word);
        $githubHandle = $this->expectGetter($user, 'getGithubHandle', $faker->word);
        $timesPreviouslySpoken = $this->expectGetter($user, 'getTimesPreviouslySpoken', $faker->randomDigitNotNull);
        $primarySpokenLanguage = $this->expectGetter($user, 'getPrimarySpokenLanguage', $faker->word);
        $primaryTechnicalLanguage = $this->expectGetter($user, 'getPrimaryTechnicalLanguage', $faker->word);
        $location = $this->expectGetter($user, 'getLocation', $faker->word);
        $gender = $this->expectGetter($user, 'getGender', $faker->word);
        $ageRange = $this->expectGetter($user, 'getAgeRange', $faker->word);

        $transformer = new UserTransformer();

        $expected = [
            'id' => $id,
            'firstName' => $firstName,
            'lastName' => $lastName,
            'email' => $email,
            'twitterHandle' => $twitterHandle,
            'githubHandle' => $githubHandle,
            'timesPreviouslySpoken' => $timesPreviouslySpoken,
            'primaryTechnicalLanguage' => $primaryTechnicalLanguage,
            'primarySpokenLanguage' => $primarySpokenLanguage,
            'location' => $location,
            'gender' => $gender,
            'ageRange' => $ageRange,
        ];

        $this->assertEquals($expected, $transformer->transform($user));
    }

    /**
     * @param \PHPUnit_Framework_MockObject_MockObject $subject
     * @param string                                   $function
     * @param $value
     *
     * @return $value
     */
    private function expectGetter(\PHPUnit_Framework_MockObject_MockObject $subject, string $function, $value)
    {
        $subject->expects($this->once())
            ->method($function)
            ->willReturn($value);

        return $value;
    }
}
