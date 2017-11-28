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

    private function getGitTagHighestVersion()
    {
        $tagsDir = __DIR__ . '/../../../.git/refs/tags/';
        self::assertFileExists($tagsDir);
        \exec('cd ' . \escapeshellarg(__DIR__) . ' && git tag', $tags, $return);
        if ($return === 0) { // no error
            self::assertNotEmpty($tags, 'No GIT tags found by `cd ' . __DIR__ . ' && git tag`');

            return \max($tags);
        }
        foreach (\scandir($tagsDir, SCANDIR_SORT_NONE) as $folder) { // fallback by scanning GIT dir itself
            if (\preg_match('~^v?\d+\.\d+(\.\d+)?$~i', $folder)) {
                $tags[] = $folder;
            }
        }
        self::assertNotEmpty($tags, 'No GIT tags found in dir ' . \realpath($tagsDir));

        return \max($tags);
    }

    private function getIncludedMauticVersion()
    {
        return $this->getComposerRequireDirective(__DIR__ . '/../../../composer.json', 'mautic/core');
    }

    private function getComposerRequireDirective($composerJsonPath, $directiveName)
    {
        self::assertFileExists($composerJsonPath);
        $composerSettings = \json_decode(\file_get_contents($composerJsonPath), true /* as array */);
        self::assertNotEmpty($composerSettings['require'][$directiveName]);

        return $composerSettings['require'][$directiveName];
    }

    /**
     * @test
     */
    public function Php_version_of_skeleton_is_same_or_lesser_than_required_by_mautic()
    {
        $mauticPhpVersion = $this->getIncludedMauticRequiredPhpVersion();
        $skeletonPhpVersion = $this->getSkeletonRequiredPhpVersion();
        foreach ($mauticPhpVersion as $index => $mauticVersionPart) {
            $skeletonVersionPart = $skeletonPhpVersion[$index];
            self::assertLessThanOrEqual(
                $mauticVersionPart,
                $skeletonVersionPart,
                'Skeleton should require lesser PHP version than Mautic.'
                . 'Skeleton requires PHP ' . implode('.', $skeletonPhpVersion) . ', Mautic PHP ' . implode('.', $mauticPhpVersion)
            );
        }
    }

    private function getSkeletonRequiredPhpVersion()
    {
        return $this->parseVersion($this->getComposerRequireDirective(__DIR__ . '/../../../composer.json', 'php'));
    }

    /**
     * @param string $versionDefinition
     * @return array|string[]
     */
    private function parseVersion($versionDefinition)
    {
        self::assertGreaterThan(0, \preg_match_all('~(?<parts>\d+)\.?~', $versionDefinition, $matches));
        self::assertGreaterThanOrEqual(2, \count($matches['parts']));
        self::assertLessThanOrEqual(3, \count($matches['parts']));
        if (\count($matches['parts']) < 3) {
            $matches['parts'][] = 0; // minor version
        }

        return array_map(function ($part) {
            return (int)$part;
        }, $matches['parts']);
    }

    private function getIncludedMauticRequiredPhpVersion()
    {
        return $this->parseVersion(
            $this->getComposerRequireDirective(__DIR__ . '/../../../vendor/mautic/core/composer.json', 'php')
        );
    }

}