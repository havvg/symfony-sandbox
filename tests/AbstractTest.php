<?php

namespace Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class AbstractTest extends WebTestCase
{
    /**
     * A flag whether this test case is a functional test case.
     *
     * @var bool
     */
    protected static $isWebTestCase = false;

    public static function getFixturesRootDirectory()
    {
        return __DIR__.'/fixtures';
    }

    /**
     * Apply expectations for an \Iterator on a mock object.
     *
     * @see http://php.net/Iterator
     *
     * @param object $mock    A mock object to apply expectations to.
     * @param array  $content The content the mock will contain and return while iteraring.
     * @param bool   $withKey Whether to add expectations on the key of the iterator.
     *                        Set this to true if you expect a key based loop:
     *                        foreach ($foo as $key => $value)
     * @param int    $counter The method invocation start counter.
     *                        This parameter should be altered when using additional
     *                        expectations before the actual iteration.
     *
     * @return int            The next method invocation counter to add further expectations.
     */
    public function expectIterator($mock, array $content, $withKey = false, $counter = 0)
    {
        $mock
            ->expects($this->at($counter))
            ->method('rewind')
        ;

        foreach ($content as $key => $value) {
            $mock
                ->expects($this->at(++$counter))
                ->method('valid')
                ->will($this->returnValue(true))
            ;

            $mock
                ->expects($this->at(++$counter))
                ->method('current')
                ->will($this->returnValue($value))
            ;

            if ($withKey) {
                $mock
                    ->expects($this->at(++$counter))
                    ->method('key')
                    ->will($this->returnValue($key))
                ;
            }

            $mock
                ->expects($this->at(++$counter))
                ->method('next')
            ;
        }

        $mock
            ->expects($this->at(++$counter))
            ->method('valid')
            ->will($this->returnValue(false))
        ;

        return ++$counter;
    }

    /**
     * Apply expectations for a \Countable on a mock object.
     *
     * @see http://php.net/Countable
     *
     * @param object $mock    A mock object to apply expectations to.
     * @param int    $count   The count to return.
     * @param int    $counter The method invocation start counter.
     *                        This parameter should be altered when using additional
     *                        expectations before the actual count.
     *
     * @return int            The next method invocation counter to add further expectations.
     */
    public function expectCountable($mock, $count, $counter = 0)
    {
        $mock
            ->expects($this->at($counter))
            ->method('count')
            ->will($this->returnValue($count))
        ;

        return ++$counter;
    }
}
