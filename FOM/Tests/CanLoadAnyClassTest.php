<?php
namespace FOM\Tests\ApiBundle;

class CanLoadAnyClassTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function I_can_load_any_class()
    {
        $this->assertGreaterThan(0, preg_match('~[\\\](?<basename>\w+)$~', __NAMESPACE__, $matches));
        $testedDir = __DIR__ . '/../../cloned/' . $matches['basename'];
        $this->I_can_load_any_class_from($testedDir);
    }

    protected function I_can_load_any_class_from($testedDir)
    {
        $this->assertTrue(is_dir($testedDir), $testedDir);
        $subFolders = $this->filterSubFolders(scandir($testedDir));
        $subDirs = $this->filterDirs($subFolders, $testedDir);
        foreach ($subDirs as $subDir) {
            // recursively
            $this->I_can_load_any_class_from($testedDir . DIRECTORY_SEPARATOR . $subDir);
        }
        $classFiles = $this->filterPhpClassFiles($subFolders, $testedDir);
        $testedNamespace = str_replace('/', '\\', preg_replace('~^.+\w+[\\\/]cloned[\\\/]~', 'Mautic\\', realpath($testedDir)));
        foreach ($classFiles as $classFile) {
            $className = $testedNamespace . '\\' . preg_replace('~\.php~', '', $classFile);
            $this->assertFalse(class_exists($className, false /* without autoload */));
            $this->assertSame(1, include_once $testedDir . DIRECTORY_SEPARATOR . $classFile);
            $this->assertTrue(class_exists($className, false /* without autoload */), $className);
        }
    }

    private function filterSubFolders(array $folders)
    {
        return array_filter(
            $folders,
            function ($file) {
                return $file !== '.' && $file !== '..';
            }
        );
    }

    private function filterPhpClassFiles(array $folders, $inDir)
    {
        return array_filter(
            $folders,
            function ($file) use ($inDir) {
                return
                    preg_match('~[A-Z]\w+\.php$~', $file)
                    && is_file($inDir . DIRECTORY_SEPARATOR . $file);
            }
        );
    }

    private function filterDirs(array $folders, $inDir)
    {
        return array_filter(
            $folders,
            function ($file) use ($inDir) {
                return is_dir($inDir . DIRECTORY_SEPARATOR . $file);
            }
        );
    }
}