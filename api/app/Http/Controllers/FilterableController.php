<?php

namespace App\Http\Controllers;
//header('Access-Control-Allow-Origin','*');
//header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
use App\Utils\XMLUtils;
use Error;
use Illuminate\Http\Request;
use App\Http\Controllers\Filtering;


/**
 * {
    startWith : {},
 *  endsWith : {},
 *  contains : {},
 *  equals : {},
 * }
 *
 */
class FilterableController extends Controller
{
    //Filtering keys
    private $string_args = ['name'];
    private $number_args = ['pvp'];

    /**
     * A function that will filter an array of string depands on the provided arg
     * @param array $arg the provided args (start with , end with ...etc)
     * @param array $data the total data
     * @param string $key the key that needed to be filtered
     * @return array Return the filtered array of string
     */
    private function string_filter(array $arg,array $data,string $key) : array
    {
        //convert to lower case to prevent typo
        $filter_arg = strtolower(key($arg));
        switch ($filter_arg)
        {
            case 'contains':
                return Filtering\StringFiltering::Contains($data, $arg[key($arg)],$key);
            case 'start_with':
                return Filtering\StringFiltering::StartsWith($data, $arg[key($arg)],$key);
            case 'end_with':
                return Filtering\StringFiltering::EndWith($data, $arg[key($arg)],$key);
            case 'equals':
                return Filtering\StringFiltering::Equals($data, $arg[key($arg)],$key);
            default:
                //If the arg is not yet supported
                //TODO improve error handling
                throw new Error('The argument '. $filter_arg . ' is not supported in filtering',400);

        }
    }

    /**
     * A function that filters a number array according to provided args
     * @param array $arg
     * @param array $data total data
     * @param string $key The key that needed to be filtered
     * @return array The filtered array
     */
    private function int_filter(array $arg,array $data,string $key)
    {
        $filter_arg = strtolower(key($arg));
        switch ($filter_arg)
        {
            case 'gte':
                return Filtering\NumberFiltering::Gte($data, floatval($arg[key($arg)]),$key);
            case 'lte':
                return Filtering\NumberFiltering::Lte($data, floatval($arg[key($arg)]),$key);
            case 'equals':
                return Filtering\NumberFiltering::Equals($data, floatval($arg[key($arg)]),$key);
            default:
                throw new Error('The argument '. $filter_arg . ' is not supported in filtering',400);

        }
    }

    /**
     * A function that accepts a file path and returns a JSON array
     * @param string $path
     * @return array return array as JSON
     */
    private function read_json(string $path) : array
    {
        $json = file_get_contents($path);
        return json_decode($json,true);
    }

    /**
     * The main post handler
     * @param Request $request
     * @return string
     */
    public function post(Request  $request)
    {
        //Preparing variables
        $json_file_path = resource_path() .'\\json\\data.json';
        //Get our json file contents
        $json_file_contents = $this->read_json($json_file_path);
        //Get the form data from the request
        $data = $request->json()->all();
        //If there is a filter key in the provided form data
        //Then the controller will try to filter the data
        if(array_key_exists('filter',$data)) {
                $req_data = $data['filter'];
                //Get the first key
                $first_key = array_key_first($req_data);
                //If the key within the string arguments . So filter the array using the string filter method
                if (in_array( $first_key, $this->string_args)) {
                    $data = $this->string_filter($req_data[$first_key], $json_file_contents, $first_key);
                    // Return the data as XML
                    return XMLUtils::convert_xml($data);
                } else if (in_array($first_key, $this->number_args)) {
                    $data = $this->int_filter($req_data[$first_key], $json_file_contents, $first_key);
                    return XMLUtils::convert_xml($data);
                } else {
                    //If the filter key is not yet implemented
                    return response('The argument ' . $first_key . ' is not supported', 400);
                }
        }
        // if there is no filter option , Return all of JSON file content as XML
        return XMLUtils::convert_xml($json_file_contents);

    }
}
