<?php

namespace Dhii\Data\FuncTest;

use Dhii\Data\KeyAwareTrait as TestSubject;
use Xpmock\TestCase;
use Exception as RootException;
use Dhii\Util\String\StringableInterface as Stringable;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use PHPUnit_Framework_MockObject_MockBuilder as MockBuilder;

/**
 * Tests {@see TestSubject}.
 *
 * @since [*next-version*]
 */
class KeyAwareTraitTest extends TestCase
{
    /**
     * The class name of the test subject.
     *
     * @since [*next-version*]
     */
    const TEST_SUBJECT_CLASSNAME = 'Dhii\Data\KeyAwareTrait';

    /**
     * Creates a new instance of the test subject.
     *
     * @since [*next-version*]
     *
     * @param array $methods The methods to mock.
     *
     * @return MockObject The new instance.
     */
    public function createInstance($methods = [])
    {
        is_array($methods) && $methods = $this->mergeValues($methods, [
            '__',
        ]);

        $mock = $this->getMockBuilder(static::TEST_SUBJECT_CLASSNAME)
            ->setMethods($methods)
            ->getMockForTrait();

        $mock->method('__')
                ->will($this->returnArgument(0));

        return $mock;
    }

    /**
     * Merges the values of two arrays.
     *
     * The resulting product will be a numeric array where the values of both inputs are present, without duplicates.
     *
     * @since [*next-version*]
     *
     * @param array $destination The base array.
     * @param array $source      The array with more keys.
     *
     * @return array The array which contains unique values
     */
    public function mergeValues($destination, $source)
    {
        return array_keys(array_merge(array_flip($destination), array_flip($source)));
    }

    /**
     * Creates a mock that both extends a class and implements interfaces.
     *
     * This is particularly useful for cases where the mock is based on an
     * internal class, such as in the case with exceptions. Helps to avoid
     * writing hard-coded stubs.
     *
     * @since [*next-version*]
     *
     * @param string $className      Name of the class for the mock to extend.
     * @param string $interfaceNames Names of the interfaces for the mock to implement.
     *
     * @return MockBuilder The builder for a mock of an object that extends and implements
     *                     the specified class and interfaces.
     */
    public function mockClassAndInterfaces($className, $interfaceNames = [])
    {
        $paddingClassName = uniqid($className);
        $definition = vsprintf('abstract class %1$s extends %2$s implements %3$s {}', [
            $paddingClassName,
            $className,
            implode(', ', $interfaceNames),
        ]);
        eval($definition);

        return $this->getMockForAbstractClass($paddingClassName);
    }

    /**
     * Creates a new exception.
     *
     * @since [*next-version*]
     *
     * @param string $message The exception message.
     *
     * @return RootException The new exception.
     */
    public function createException($message = '')
    {
        $mock = $this->getMockBuilder('Exception')
            ->setConstructorArgs([$message])
            ->getMock();

        return $mock;
    }

    /**
     * Creates a new stringable.
     *
     * @since [*next-version*]
     *
     * @param string $string The string for the stringable to represent.
     *
     * @return MockObject|Stringable The new stringable mock.
     */
    public function createStringable($string = '')
    {
        $mock = $this->getMockBuilder('Dhii\Util\String\StringableInterface')
            ->setMethods(['__toString'])
            ->getMock();

        $mock->method('__toString')
            ->will($this->returnValue($string));

        return $mock;
    }

    /**
     * Tests whether a valid instance of the test subject can be created.
     *
     * @since [*next-version*]
     */
    public function testCanBeCreated()
    {
        $subject = $this->createInstance();

        $this->assertInternalType(
            'object',
            $subject,
            'A valid instance of the test subject could not be created.'
        );
    }

    /**
     * Tests whether `_getKey()` is consistent with `_setKey()` when given a string.
     *
     * @since [*next-version*]
     */
    public function testSetGetKeyString()
    {
        $key = uniqid('key');
        $subject = $this->createInstance(['_normalizeString']);
        $_subject = $this->reflect($subject);

        $subject->expects($this->exactly(1))
            ->method('_normalizeString')
            ->with($key)
            ->will($this->returnValue($key));

        $_subject->_setKey($key);
        $result = $_subject->_getKey();
        $this->assertEquals($key, $result, 'Key retrieved is not the same as key set');
    }

    /**
     * Tests whether `_getKey()` is consistent with `_setKey()` when given a stringable.
     *
     * @since [*next-version*]
     */
    public function testSetGetKeyStringable()
    {
        $key = uniqid('key');
        $stringable = $this->createStringable($key);
        $subject = $this->createInstance();
        $_subject = $this->reflect($subject);

        $_subject->_setKey($stringable);
        $result = $_subject->_getKey();
        $this->assertEquals($key, $result, 'Key retrieved is not the same as key set');
    }

    /**
     * Tests whether `_getKey()` is consistent with `_setKey()` when given an integer.
     *
     * @since [*next-version*]
     */
    public function testSetGetKeyInt()
    {
        $key = rand(1, 99);
        $subject = $this->createInstance(['_normalizeString']);
        $_subject = $this->reflect($subject);

        $subject->expects($this->exactly(1))
            ->method('_normalizeString')
            ->with($key)
            ->will($this->returnValue((string) $key));

        $_subject->_setKey($key);
        $result = $_subject->_getKey();
        $this->assertEquals((string) $key, $result, 'Key retrieved is not consistent with key set');
    }

    /**
     * Tests whether `_getKey()` is consistent with `_setKey()` when given a null.
     *
     * @since [*next-version*]
     */
    public function testSetGetKeyNull()
    {
        $key = null;
        $subject = $this->createInstance();
        $_subject = $this->reflect($subject);

        $_subject->key = uniqid('key');
        $_subject->_setKey($key);
        $result = $_subject->_getKey();
        $this->assertEquals($key, $result, 'Key retrieved is not the same as key set');
    }
}
