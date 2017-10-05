<?php

namespace testing\User;

/**
 * Helper class to mock methods.
 */
class Helper
{

    /**
     * Mocking redirect method
     * @return boolean return true to pass test
     */
    public function redirect()
    {
        return true;
    }



    /**
     * Mocking add method
     * @return boolean return true to pass test
     */
    public function add()
    {
        return true;
    }



    /**
     * Mocking renderpage method
     * @return boolean return true to pass test
     */
    public function renderPage()
    {
        return true;
    }



    /**
     * Mocking getServer method
     * @return string return string "GET"
     */
    public function getServer()
    {
        return "GET";
    }



    /**
     * Mocking getPost method
     * @return boolean return true to pass test
     */
    public function getPost()
    {
        return true;
    }
}
