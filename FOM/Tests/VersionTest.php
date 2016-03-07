<?php
namespace FOM\Tests\ApiBundle;

class VersionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function skeleton_git_tag_version_reflects_mautic_version()
    {
        self::assertSame($this->getGitTagHighestVersion(), $this->getIncludedMauticVersion());
    }

    private function getGitTagHighestVersion()
    {
        $tagsDir = __DIR__ . '/../../.git/refs/tags/';
        self::assertFileExists($tagsDir);
        $tags = [];
        foreach (scandir($tagsDir) as $folder) {
            if (preg_match('~^v?\d+\.\d+(\.\d+)?$~i', $folder)) {
                $tags[] = $folder;
            }
        }

        return max($tags);
    }

    private function getIncludedMauticVersion()
    {
        $composerJson = __DIR__ . '/../../composer.json';
        self::assertFileExists($composerJson);
        $composerSettings = json_decode(file_get_contents($composerJson), true /* as array */);
        self::assertNotEmpty($composerSettings['require']['mautic/core']);

        return $composerSettings['require']['mautic/core'];
    }
}
