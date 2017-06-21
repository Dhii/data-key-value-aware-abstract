<?php

namespace Dhii\Data\FuncTest;

use Dhii\Data\KeyAwareTrait;
use Xpmock\TestCase;

/**
 * Tests {@see Dhii\Data\KeyAwareTrait}.
 *
 * @since [*next-version*]
 */
class KeyAwareTraitTest extends TestCase
{
    /**
     * The name of the test subject.
     *
     * @since [*next-version*]
     */
    const TEST_SUBJECT_CLASSNAME = 'Dhii\\Data\\KeyAwareTrait';

    /**
     * Creates a new instance of the test subject.
     *
     * @since [*next-version*]
     *
     * @return KeyAwareTrait
     */
    public function createInstance()
    {
        return $this->getMockForTrait(static::TEST_SUBJECT_CLASSNAME);
    }

    /**
     * Tests the key getter and setter methods.
     *
     * @since [*next-version*]
     */
    public function testGetSetKey()
    {
        $subject = $this->createInstance();
        $reflect = $this->reflect($subject);

        $reflect->_setKey($expected = 'test-key-123');

        $this->assertEquals($expected, $reflect->_getKey());
    }
}
