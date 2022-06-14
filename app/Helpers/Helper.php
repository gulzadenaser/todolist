<?php
/**
 * Generel custom php helpers to be used in all apps area
 */
//check if array exists in another array using array_intersect whether any array element exists in another array
if(!function_exists('arrayInArray'))
{
    function arrayInArray($srcArray = [], $targetArray = [])
    {
        //check if both parameters are array
        if(is_array($srcArray) && is_array($targetArray))
        {
            return !empty(array_intersect($srcArray, $targetArray));
        }
        return false;
    }

}
/**
 * This code gets request keys using Request only method, 
 * then puts it into collection, 
 * filters it using $value !== null so the 0 and other data should still be there.
 */
if(!function_exists('getRequestData'))
{
    function getRequestData($requestData)
    {
        // Put request values into collection
        $valid = collect($requestData);
        // Filter values
        $valid = $valid->filter(function ($value) {
            return $value !== null;
        });
        // We get it back as an array
        return $valid->all();
    }
}