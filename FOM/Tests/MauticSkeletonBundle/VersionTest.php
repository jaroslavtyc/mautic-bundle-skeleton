<?php
namespace FOM\Tests\MauticSkeletonBundle;

class VersionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function skeleton_git_tag_version_reflects_mautic_version()
    {
        self::assertSame($this->getGitTagHighestVersion(), $this->getIncludedMauticVersion());
    }

    private function getGitTagHighestVersion(): string
    {
        $tagsDir = __DIR__ . '/../../../.git/refs/tags/';
        self::assertFileExists($tagsDir);
        exec('cd ' . \escapeshellarg(__DIR__) . ' && git tag', $tags, $return);
        if ($return === 0) { // no error
            self::assertNotEmpty($tags, 'No GIT tags found by `cd ' . __DIR__ . ' && git tag`');

            return \max($tags);
        }
        foreach (scandir($tagsDir, SCANDIR_SORT_NONE) as $folder) { // fallback by scanning GIT dir itself
            if (preg_match('~^v?\d+\.\d+(\.\d+)?$~i', $folder)) {
                $tags[] = $folder;
            }
        }
        self::assertNotEmpty($tags, 'No GIT tags found in dir ' . \realpath($tagsDir));

        return \max($tags);
    }

    private function getIncludedMauticVersion(): string
    {
        $composerJson = __DIR__ . '/../../../composer.json';
        self::assertFileExists($composerJson);
        $composerSettings = \json_decode(\file_get_contents($composerJson), true /* as array */);
        self::assertNotEmpty($composerSettings['require']['mautic/core']);

        return $composerSettings['require']['mautic/core'];
    }
}
