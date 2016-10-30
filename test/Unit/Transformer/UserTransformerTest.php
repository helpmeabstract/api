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
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'twitter_handle' => $twitterHandle,
            'github_handle' => $githubHandle,
            'times_previously_spoken' => $timesPreviouslySpoken,
            'primary_technical_language' => $primaryTechnicalLanguage,
            'primary_spoken_language' => $primarySpokenLanguage,
            'location' => $location,
            'gender' => $gender,
            'age_range' => $ageRange,
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
