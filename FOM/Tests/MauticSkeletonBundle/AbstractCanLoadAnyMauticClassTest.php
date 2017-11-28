<?php
namespace FOM\Tests\MauticSkeletonBundle;

abstract class AbstractCanLoadAnyMauticClassTest extends \PHPUnit_Framework_TestCase
{
    /**
     * No extended-by
     * @test
     */
    public function I_can_load_any_mautic_class()
    {
        self::assertGreaterThan(0, \preg_match('~[\\\](?<basename>\w+)$~', __NAMESPACE__, $matches));
        $testedDir = __DIR__ . '/../../../vendor/mautic/core/app/bundles/' . $matches['basename'];
        $this->I_can_load_any_class_from($testedDir);
    }

    protected function I_can_load_any_class_from($testedDir)
    {
        self::assertTrue(\is_dir($testedDir), "Was searching for $testedDir");
        $subFolders = $this->filterSubFolders(\scandir($testedDir, SCANDIR_SORT_NONE));
        $subDirs = $this->filterDirs($subFolders, $testedDir);
        foreach ($subDirs as $subDir) {
            // recursively
            $this->I_can_load_any_class_from($testedDir . DIRECTORY_SEPARATOR . $subDir);
        }
        $classFiles = $this->filterPhpClassFiles($subFolders, $testedDir);
        $testedNamespace = \str_replace('/', '\\', \preg_replace('~^.+\w+[\\\/]mautic[\\\/]core[\\\/]app[\\\/]bundles[\\\/]~', 'Mautic\\', \realpath($testedDir)));
        foreach ($classFiles as $classFile) {
            $className = $testedNamespace . '\\' . \preg_replace('~\.php~', '', $classFile);
            self::assertFalse(\class_exists($className, false /* without autoload */));
            /** @noinspection PhpIncludeInspection */
            self::assertSame(1, include $testedDir . DIRECTORY_SEPARATOR . $classFile);
            self::assertTrue(\class_exists($className, false /* without autoload */), $className);
        }
    }

    private function filterSubFolders(array $folders)
    {
        return \array_filter(
            $folders,
            function ($file) {
                return $file !== '.' && $file !== '..';
            }
        );
    }

    private function filterPhpClassFiles(array $folders, $inDir)
    {
        return \array_filter(
            $folders,
            function ($file) use ($inDir) {
                return
                    \preg_match('~[A-Z]\w+\.php$~', $file)
                    && \is_file($inDir . DIRECTORY_SEPARATOR . $file);
            }
        );
    }

    private function filterDirs(array $folders, $inDir)
    {
        return \array_filter(
            $folders,
            function ($file) use ($inDir) {
                return \is_dir($inDir . DIRECTORY_SEPARATOR . $file);
            }
        );
    }
}