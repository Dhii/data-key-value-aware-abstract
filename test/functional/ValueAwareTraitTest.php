<?php

namespace Dhii\Data\FuncTest;

use Dhii\Data\ValueAwareTrait;
use Xpmock\TestCase;

/**
 * Tests {@see Dhii\Data\ValueAwareTrait}.
 *
 * @since [*next-version*]
 */
class ValueAwareTraitTest extends TestCase
{
    /**
     * The name of the test subject.
     *
     * @since [*next-version*]
     */
    const TEST_SUBJECT_CLASSNAME = 'Dhii\\Data\\ValueAwareTrait';

    /**
     * Creates a new instance of the test subject.
     *
     * @since [*next-version*]
     *
     * @return ValueAwareTrait
     */
    public function createInstance()
    {
        return $this->getMockForTrait(static::TEST_SUBJECT_CLASSNAME);
    }

    /**
     * Tests the value getter and setter methods.
     *
     * @since [*next-version*]
     */
    public function testGetSetKey()
    {
        $subject = $this->createInstance();
        $reflect = $this->reflect($subject);

        $reflect->_setValue($expected = 'test-value-123');

        $this->assertEquals($expected, $reflect->_getValue());
    }
}
