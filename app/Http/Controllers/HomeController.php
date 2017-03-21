<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use TwitterSearch\Twitter;
use Cache;
use Session;
use GuzzleHttp\Client;

class HomeController extends Controller
{	
	/**
	 * Show tweets
	 *
	 * @return view 
	 */
    public function index(Request $request)
    {	
    	$response = $this->getTweets();

       	//Get current page form url e.g. &page=6
        $current_page = LengthAwarePaginator::resolveCurrentPage();

        //Create a new Laravel collection from the array data
        $collection = collect($response);

        //Define how many items we want to be visible in each page
        $per_page = 10;

        //Slice the collection to get the items to display in current page
        $current_page_search_results = $collection->slice(($current_page - 1) * $per_page, $per_page)->all();

        //Create our paginator and pass it to the view
        $paginated_search_results= new LengthAwarePaginator($current_page_search_results, count($collection), $per_page);
 		
 		return view('tweets', ['tweets' => $paginated_search_results]);
     }


     /**
      * Get data either from cache or from Twitter
      *
      * @return mixed 	Error string or array of tweets
      */
     public function getTweets()
     {
        // Check cache first
        $tweets = Cache::get('tweets');
        if ($tweets != null) {
        	Session::forget('success');
        	Session::flash('warning', 'Pulling tweets from Cache');
            return $tweets;
        }

        return $this->pullFromAPI();
     }


     /**
      * Make a request to Twitter and pull tweets
      *
      * @return mixed 	Error string or array of tweets
      */
     public function pullFromAPI()
     {	
     	$client =  new \GuzzleHttp\Client();

     	$twitter = new Twitter($client, 'OKC7PjsjeFEmAZh6GyaCjX5L4', '9BvI0AsKElcfvFKTU5vr9EObRvNEXOrq8pBKrGw2vzwchCBGkU');
    	$twitter->searchTweets('#London filter:safe', 50);
    	$response = $twitter->getResponse();

    	// Only store the proper result
    	if ($twitter->getStatusCode() == 200) {
    		Cache::put('tweets', $response, 60);
    	}

    	Session::flash('success', 'Pulling tweets from Twitter');
    	Session::forget('warning');

    	return $response;
     }
}
