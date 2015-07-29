<?php
/**
 * https://github.com/glamorous/TMDb-PHP-API
 * TMDb PHP API class - API 'themoviedb.org'
 * API Documentation: http://help.themoviedb.org/kb/api/
 * Documentation and usage in README file
 *
 * @author Jonas De Smet - Glamorous
 * @since 09.11.2009
 * @date 16.11.2012
 * @copyright Jonas De Smet - Glamorous
 * @version 1.5.1
 * @license BSD http://www.opensource.org/licenses/bsd-license.php
 */
class TMDb {
	const POST = 'post';
	const GET = 'get';
	const HEAD = 'head';
	const IMAGE_BACKDROP = 'backdrop';
	const IMAGE_POSTER = 'poster';
	const IMAGE_PROFILE = 'profile';
	const API_VERSION = '3';
	const API_URL = 'api.themoviedb.org';
	const API_SCHEME = 'http://';
	const API_SCHEME_SSL = 'http://';
	const VERSION = '1.5.0';
	
	/**
	 * The API-key
	 *
	 * @var string
	 */
	protected $_apikey;
	
	/**
	 * The default language
	 *
	 * @var string
	 */
	protected $_lang;
	
	/**
	 * The TMDb-config
	 *
	 * @var object
	 */
	protected $_config;
	
	/**
	 * Stored Session Id
	 *
	 * @var string
	 */
	protected $_session_id;
	
	/**
	 * API Scheme
	 *
	 * @var string
	 */
	protected $_apischeme;
	
	/**
	 * Default constructor
	 *
	 * @param string $apikey
	 *        	recieved from TMDb
	 * @param string $defaultLang
	 *        	language (ISO 3166-1)
	 * @param boolean $config
	 *        	the TMDb-config
	 * @return void
	 */
	public function __construct($apikey, $default_lang = 'en', $config = FALSE, $scheme = TMDb::API_SCHEME) {
		$this->_apikey = ( string ) $apikey;
		$this->_apischeme = ($scheme == TMDb::API_SCHEME) ? TMDb::API_SCHEME : TMDb::API_SCHEME_SSL;
		$this->setLang ( $default_lang );
		
		if ($config === TRUE) {
			$this->getConfiguration ();
		}
	}
	
	/**
	 * Search a movie by querystring
	 *
	 * @param string $text
	 *        	to search after in the TMDb database
	 * @param int $page
	 *        	of the page with results (default first page)
	 * @param bool $adult
	 *        	of not to include adult movies in the results (default FALSE)
	 * @param mixed $lang
	 *        	the result with a language (ISO 3166-1) other then default, use FALSE to retrieve results from all languages
	 * @return TMDb result array
	 */
	public function searchMovie($query, $page = 1, $adult = FALSE, $year = NULL, $lang = NULL) {
		$params = array (
				'query' => $query,
				'page' => ( int ) $page,
				'language' => ($lang !== NULL) ? $lang : $this->getLang (),
				'include_adult' => ( bool ) $adult,
				'year' => $year 
		);
		return $this->_makeCall ( 'search/movie', $params );
	}
	
	/**
	 * Search a person by querystring
	 *
	 * @param string $text
	 *        	to search after in the TMDb database
	 * @param int $page
	 *        	of the page with results (default first page)
	 * @param bool $adult
	 *        	of not to include adult movies in the results (default FALSE)
	 * @return TMDb result array
	 */
	public function searchPerson($query, $page = 1, $adult = FALSE) {
		$params = array (
				'query' => $query,
				'page' => ( int ) $page,
				'include_adult' => ( bool ) $adult 
		);
		return $this->_makeCall ( 'search/person', $params );
	}
	
	/**
	 * Search a company by querystring
	 *
	 * @param string $text
	 *        	to search after in the TMDb database
	 * @param int $page
	 *        	of the page with results (default first page)
	 * @return TMDb result array
	 */
	public function searchCompany($query, $page = 1) {
		$params = array (
				'query' => $query,
				'page' => $page 
		);
		return $this->_makeCall ( 'search/company', $params );
	}
	
	/**
	 * Retrieve information about a collection
	 *
	 * @param int $id
	 *        	from a collection (retrieved with getMovie)
	 * @param mixed $lang
	 *        	the result with a language (ISO 3166-1) other then default, use FALSE to retrieve results from all languages
	 * @return TMDb result array
	 */
	public function getCollection($id, $lang = NULL) {
		$params = array (
				'language' => ($lang !== NULL) ? $lang : $this->getLang () 
		);
		return $this->_makeCall ( 'collection/' . $id, $params );
	}
	
	/**
	 * Retrieve all basic information for a particular movie
	 *
	 * @param mixed $id
	 *        	or IMDB-id
	 * @param mixed $lang
	 *        	the result with a language (ISO 3166-1) other then default, use FALSE to retrieve results from all languages
	 * @return TMDb result array
	 */
	public function getMovie($id, $lang = NULL) {
		$params = array (
				'language' => ($lang !== NULL) ? $lang : $this->getLang () 
		);
		return $this->_makeCall ( 'movie/' . $id, $params );
	}
	
	/**
	 * Retrieve alternative titles for a particular movie
	 *
	 * @param mixed $id
	 *        	or IMDB-id
	 * @param
	 *        	s string $country			Only include titles for a particular country (ISO 3166-1)
	 * @return TMDb result array
	 */
	public function getMovieTitles($id, $country = NULL) {
		$params = array (
				'country' => $country 
		);
		return $this->_makeCall ( 'movie/' . $id . '/alternative_titles', $params );
	}
	
	/**
	 * Retrieve all of the movie cast information for a particular movie
	 *
	 * @param mixed $id
	 *        	or IMDB-id
	 * @return TMDb result array
	 */
	public function getMovieCast($id) {
		return $this->_makeCall ( 'movie/' . $id . '/credits' );
	}
	
	/**
	 * Retrieve all of the keywords for a particular movie
	 *
	 * @param mixed $id
	 *        	or IMDB-id
	 * @return TMDb result array
	 */
	public function getMovieKeywords($id) {
		return $this->_makeCall ( 'movie/' . $id . '/keywords' );
	}
	
	/**
	 * Retrieve all the release and certification data for a particular movie
	 *
	 * @param mixed $id
	 *        	or IMDB-id
	 * @return TMDb result array
	 */
	public function getMovieReleases($id) {
		return $this->_makeCall ( 'movie/' . $id . '/releases' );
	}
	
	/**
	 * Retrieve available translations for a particular movie
	 *
	 * @param mixed $id
	 *        	or IMDB-id
	 * @return TMDb result array
	 */
	public function getMovieTranslations($id) {
		return $this->_makeCall ( 'movie/' . $id . '/translations' );
	}
	
	/**
	 * Retrieve available trailers for a particular movie
	 *
	 * @param mixed $id
	 *        	or IMDB-id
	 * @param mixed $lang
	 *        	the result with a language (ISO 3166-1) other then default, use FALSE to retrieve results from all languages
	 * @return TMDb result array
	 */
	public function getMovieTrailers($id, $lang = NULL) {
		$params = array (
				'language' => ($lang !== NULL) ? $lang : $this->getLang () 
		);
		return $this->_makeCall ( 'movie/' . $id . '/trailers', $params );
	}
	
	/**
	 * Retrieve all images for a particular movie
	 *
	 * @param mixed $id
	 *        	or IMDB-id
	 * @param mixed $lang
	 *        	the result with a language (ISO 3166-1) other then default, use FALSE to retrieve results from all languages
	 * @return TMDb result array
	 */
	public function getMovieImages($id, $lang = NULL) {
		$params = array (
				'language' => ($lang !== NULL) ? $lang : $this->getLang () 
		);
		return $this->_makeCall ( 'movie/' . $id . '/images', $params );
	}
	
	/**
	 * Retrieve similar movies for a particular movie
	 *
	 * @param mixed $id
	 *        	or IMDB-id
	 * @param int $page
	 *        	of the page with results (default first page)
	 * @param mixed $lang
	 *        	the result with a language (ISO 3166-1) other then default, use FALSE to retrieve results from all languages
	 * @return TMDb result array
	 */
	public function getSimilarMovies($id, $page = 1, $lang = NULL) {
		$params = array (
				'page' => ( int ) $page,
				'language' => ($lang !== NULL) ? $lang : $this->getLang () 
		);
		return $this->_makeCall ( 'movie/' . $id . '/similar_movies', $params );
	}
	
	/**
	 * Retrieve newest movie added to TMDb
	 *
	 * @return TMDb result array
	 */
	public function getLatestMovie() {
		return $this->_makeCall ( 'movie/latest' );
	}
	
	/**
	 * Retrieve movies to discover
	 *
	 * @param int $page
	 *        	of the page with results (default first page)
	 * @param mixed $lang
	 *        	the result with a language (ISO 3166-1) other then default, use FALSE to retrieve results from all languages
	 * @return TMDb result array
	 */
	public function getDiscoverMovies($page = 1, $lang = NULL) {
		$params = array (
				'page' => ( int ) $page,
				'language' => ($lang !== NULL) ? $lang : $this->getLang () 
		);
		return $this->_makeCall ( 'discover/movie', $params );
	}
	
	/**
	 * Retrieve movies arriving to theatres within the next few weeks
	 *
	 * @param int $page
	 *        	of the page with results (default first page)
	 * @param mixed $lang
	 *        	the result with a language (ISO 3166-1) other then default, use FALSE to retrieve results from all languages
	 * @return TMDb result array
	 */
	public function getUpcomingMovies($page = 1, $lang = NULL) {
		$params = array (
				'page' => ( int ) $page,
				'language' => ($lang !== NULL) ? $lang : $this->getLang () 
		);
		return $this->_makeCall ( 'movie/upcoming', $params );
	}
	
	/**
	 * Retrieve movies currently in theatres
	 *
	 * @param int $page
	 *        	of the page with results (default first page)
	 * @param mixed $lang
	 *        	the result with a language (ISO 3166-1) other then default, use FALSE to retrieve results from all languages
	 * @return TMDb result array
	 */
	public function getNowPlayingMovies($page = 1, $lang = NULL) {
		$params = array (
				'page' => ( int ) $page,
				'language' => ($lang !== NULL) ? $lang : $this->getLang () 
		);
		return $this->_makeCall ( 'movie/now_playing', $params );
	}
	
	/**
	 * Retrieve popular movies (list is updated daily)
	 *
	 * @param int $page
	 *        	of the page with results (default first page)
	 * @param mixed $lang
	 *        	the result with a language (ISO 3166-1) other then default, use FALSE to retrieve results from all languages
	 * @return TMDb result array
	 */
	public function getPopularMovies($page = 1, $lang = NULL) {
		$params = array (
				'page' => ( int ) $page,
				'language' => ($lang !== NULL) ? $lang : $this->getLang () 
		);
		return $this->_makeCall ( 'movie/popular', $params );
	}
	
	/**
	 * Retrieve top-rated movies
	 *
	 * @param int $page
	 *        	of the page with results (default first page)
	 * @param mixed $lang
	 *        	the result with a language (ISO 3166-1) other then default, use FALSE to retrieve results from all languages
	 * @return TMDb result array
	 */
	public function getTopRatedMovies($page = 1, $lang = NULL) {
		$params = array (
				'page' => ( int ) $page,
				'language' => ($lang !== NULL) ? $lang : $this->getLang () 
		);
		return $this->_makeCall ( 'movie/top_rated', $params );
	}
	
	/**
	 * Retrieve changes for a particular movie
	 *
	 * @param mixed $id
	 *        	or IMDB-id
	 * @return TMDb result array
	 */
	public function getMovieChanges($id) {
		return $this->_makeCall ( 'movie/' . $id . '/changes' );
	}
	
	/**
	 * Retrieve all id's from changed movies
	 *
	 * @param int $page
	 *        	of the page with results (default first page)
	 * @param string $start_date
	 *        	start date as YYYY-MM-DD
	 * @param string $end_date
	 *        	end date as YYYY-MM-DD (not inclusive)
	 * @return TMDb result array
	 */
	public function getChangedMovies($page = 1, $start_date = NULL, $end_date = NULL) {
		$params = array (
				'page' => ( int ) $page,
				'start_date' => $start_date,
				'end_date' => $end_date 
		);
		return $this->_makeCall ( 'movie/changes', $params );
	}
	
	/**
	 * ************************************************Tv******************************************************
	 */
	
	/**
	 * Search a tv by querystring
	 *
	 * @param string $text
	 *        	to search after in the TMDb database
	 * @param int $page
	 *        	of the page with results (default first page)
	 * @param bool $adult
	 *        	of not to include adult movies in the results (default FALSE)
	 * @param mixed $lang
	 *        	the result with a language (ISO 3166-1) other then default, use FALSE to retrieve results from all languages
	 * @return TMDb result array
	 */
	public function searchTv($query, $page = 1, $adult = FALSE, $year = NULL, $lang = NULL) {
		$params = array (
				'query' => $query,
				'page' => ( int ) $page,
				'language' => ($lang !== NULL) ? $lang : $this->getLang (),
				'include_adult' => ( bool ) $adult,
				'year' => $year 
		);
		return $this->_makeCall ( 'search/tv', $params );
	}
	
	/**
	 * Retrieve all basic information for a particular tv
	 *
	 * @param mixed $id
	 *        	or IMDB-id
	 * @param mixed $lang
	 *        	the result with a language (ISO 3166-1) other then default, use FALSE to retrieve results from all languages
	 * @return TMDb result array
	 */
	public function getTv($id, $lang = NULL) {
		$params = array (
				'language' => ($lang !== NULL) ? $lang : $this->getLang () 
		);
		return $this->_makeCall ( 'tv/' . $id, $params );
	}
	
	/**
	 * Retrieve alternative titles for a particular tv
	 *
	 * @param mixed $id
	 *        	or IMDB-id
	 * @param
	 *        	s string $country			Only include titles for a particular country (ISO 3166-1)
	 * @return TMDb result array
	 */
	public function getTvTitles($id, $country = NULL) {
		$params = array (
				'country' => $country 
		);
		return $this->_makeCall ( 'tv/' . $id . '/alternative_titles', $params );
	}
	
	/**
	 * Retrieve all of the movie cast information for a particular tv
	 *
	 * @param mixed $id
	 *        	or IMDB-id
	 * @return TMDb result array
	 */
	public function getTvCast($id) {
		return $this->_makeCall ( 'tv/' . $id . '/credits' );
	}
	
	/**
	 * Retrieve all of the keywords for a particular tv
	 *
	 * @param mixed $id
	 *        	or IMDB-id
	 * @return TMDb result array
	 */
	public function getTvKeywords($id) {
		return $this->_makeCall ( 'tv/' . $id . '/keywords' );
	}
	
	/**
	 * Retrieve available translations for a particular tv
	 *
	 * @param mixed $id
	 *        	or IMDB-id
	 * @return TMDb result array
	 */
	public function getTvTranslations($id) {
		return $this->_makeCall ( 'tv/' . $id . '/translations' );
	}
	
	/**
	 * Retrieve available trailers for a particular tv
	 *
	 * @param mixed $id
	 *        	or IMDB-id
	 * @param mixed $lang
	 *        	the result with a language (ISO 3166-1) other then default, use FALSE to retrieve results from all languages
	 * @return TMDb result array
	 */
	public function getTvTrailers($id, $lang = NULL) {
		$params = array (
				'language' => ($lang !== NULL) ? $lang : $this->getLang () 
		);
		return $this->_makeCall ( 'tv/' . $id . '/videos', $params );
	}
	
	/**
	 * Retrieve all images for a particular tv
	 *
	 * @param mixed $id
	 *        	or IMDB-id
	 * @param mixed $lang
	 *        	the result with a language (ISO 3166-1) other then default, use FALSE to retrieve results from all languages
	 * @return TMDb result array
	 */
	public function getTvImages($id, $lang = NULL) {
		$params = array (
				'language' => ($lang !== NULL) ? $lang : $this->getLang () 
		);
		return $this->_makeCall ( 'tv/' . $id . '/images', $params );
	}
	
	/**
	 * Retrieve similar movies for a particular tv
	 *
	 * @param mixed $id
	 *        	or IMDB-id
	 * @param int $page
	 *        	of the page with results (default first page)
	 * @param mixed $lang
	 *        	the result with a language (ISO 3166-1) other then default, use FALSE to retrieve results from all languages
	 * @return TMDb result array
	 */
	public function getSimilarTv($id, $page = 1, $lang = NULL) {
		$params = array (
				'page' => ( int ) $page,
				'language' => ($lang !== NULL) ? $lang : $this->getLang () 
		);
		return $this->_makeCall ( 'tv/' . $id . '/similar', $params );
	}
	
	/**
	 * Retrieve newest movie added to TMDb
	 *
	 * @return TMDb result array
	 */
	public function getLatestTv() {
		return $this->_makeCall ( 'tv/latest' );
	}
	
	/**
	 * Retrieve top-rated tv
	 *
	 * @param int $page
	 *        	of the page with results (default first page)
	 * @param mixed $lang
	 *        	the result with a language (ISO 3166-1) other then default, use FALSE to retrieve results from all languages
	 * @return TMDb result array
	 */
	public function getTopRatedTv($page = 1, $lang = NULL) {
		$params = array (
				'page' => ( int ) $page,
				'language' => ($lang !== NULL) ? $lang : $this->getLang () 
		);
		return $this->_makeCall ( 'tv/top_rated', $params );
	}
	
	/**
	 * Retrieve popular tv
	 *
	 * @param int $page
	 *        	of the page with results (default first page)
	 * @param mixed $lang
	 *        	the result with a language (ISO 3166-1) other then default, use FALSE to retrieve results from all languages
	 * @return TMDb result array
	 */
	public function getPopularTv($page = 1, $lang = NULL) {
		$params = array (
				'page' => ( int ) $page,
				'language' => ($lang !== NULL) ? $lang : $this->getLang () 
		);
		return $this->_makeCall ( 'tv/popular', $params );
	}
	
	/**
	 * Retrieve on the air tv
	 *
	 * @param int $page
	 *        	of the page with results (default first page)
	 * @param mixed $lang
	 *        	the result with a language (ISO 3166-1) other then default, use FALSE to retrieve results from all languages
	 * @return TMDb result array
	 */
	public function getOnTheAirTv($page = 1, $lang = NULL) {
		$params = array (
				'page' => ( int ) $page,
				'language' => ($lang !== NULL) ? $lang : $this->getLang () 
		);
		return $this->_makeCall ( 'tv/on_the_air', $params );
	}
	
	/**
	 * Retrieve airing today tv
	 *
	 * @param int $page
	 *        	of the page with results (default first page)
	 * @param mixed $lang
	 *        	the result with a language (ISO 3166-1) other then default, use FALSE to retrieve results from all languages
	 * @return TMDb result array
	 */
	public function getAiringTodayTv($page = 1, $lang = NULL) {
		$params = array (
				'page' => ( int ) $page,
				'language' => ($lang !== NULL) ? $lang : $this->getLang () 
		);
		return $this->_makeCall ( 'tv/airing_today', $params );
	}
	
	/**
	 * Retrieve a list of genres used on TMDb
	 *
	 * @param mixed $lang
	 *        	the result with a language (ISO 3166-1) other then default, use FALSE to retrieve results from all languages
	 * @return TMDb result array
	 */
	public function getTvGenres($lang = NULL) {
		$params = array (
				'language' => ($lang !== NULL) ? $lang : $this->getLang () 
		);
		return $this->_makeCall ( 'genre/tv/list', $params );
	}
	
	/**
	 * Retrieve tv for a particular genre
	 *
	 * @param int $id
	 *        	genre-id
	 * @param int $page
	 *        	of the page with results (default first page)
	 * @param mixed $lang
	 *        	the result with a language (ISO 3166-1) other then default, use FALSE to retrieve results from all languages
	 * @return TMDb result array
	 */
	public function getTvByGenre($id, $page = 1, $lang = NULL) {
		$params = array (
				'page' => ( int ) $page,
				'language' => ($lang !== NULL) ? $lang : $this->getLang () 
		);
		return $this->_makeCall ( 'genre/' . $id . '/tv', $params );
	}
	
	/**
	 * Retrieve Tv to discover
	 *
	 * @param int $page
	 *        	of the page with results (default first page)
	 * @param mixed $lang
	 *        	the result with a language (ISO 3166-1) other then default, use FALSE to retrieve results from all languages
	 * @return TMDb result array
	 */
	public function getDiscoverTv($page = 1, $lang = NULL) {
		$params = array (
				'page' => ( int ) $page,
				'language' => ($lang !== NULL) ? $lang : $this->getLang () 
		);
		return $this->_makeCall ( 'discover/tv', $params );
	}
	
	/*
	 * ***************************************************season ***********************************************
	 */
	
	/**
	 * Retrieve tv seasion info
	 *
	 * @param int $showid
	 *        	id of the show
	 * @param int $season
	 *        	season number
	 * @param mixed $lang
	 *        	the result with a language (ISO 3166-1) other then default, use FALSE to retrieve results from all languages
	 * @return TMDb result array
	 */
	public function getTvSeason($showid, $seasson, $lang = NULL) {
		$params = array (
				'language' => ($lang !== NULL) ? $lang : $this->getLang () 
		);
		return $this->_makeCall ( 'tv/' . $showid . '/season/' . $seasson, $params );
	}
	
	/**
	 * Retrieve tv seasion images
	 *
	 * @param int $showid
	 *        	id of the show
	 * @param int $season
	 *        	season number
	 * @param mixed $lang
	 *        	the result with a language (ISO 3166-1) other then default, use FALSE to retrieve results from all languages
	 * @return TMDb result array
	 */
	public function getTvSeasonImages($showid, $seasson, $lang = NULL) {
		$params = array (
				'language' => ($lang !== NULL) ? $lang : $this->getLang () 
		);
		return $this->_makeCall ( 'tv/' . $showid . '/season/' . $seasson . '/images', $params );
	}
	
	/**
	 * Retrieve tv seasion videos
	 *
	 * @param int $showid
	 *        	id of the show
	 * @param int $season
	 *        	season number
	 * @param mixed $lang
	 *        	the result with a language (ISO 3166-1) other then default, use FALSE to retrieve results from all languages
	 * @return TMDb result array
	 */
	public function getTvSeasonVideos($showid, $seasson, $lang = NULL) {
		$params = array (
				'language' => ($lang !== NULL) ? $lang : $this->getLang () 
		);
		return $this->_makeCall ( 'tv/' . $showid . '/season/' . $seasson . '/videos', $params );
	}
	
	/*
	 * ***************************************************episode***********************************************
	 */
	
	/**
	 * Retrieve tv Episode info
	 *
	 * @param int $showid
	 *        	id of the show
	 * @param int $season
	 *        	season number
	 * @param int $episode
	 *        	episode number
	 * @param mixed $lang
	 *        	the result with a language (ISO 3166-1) other then default, use FALSE to retrieve results from all languages
	 * @return TMDb result array
	 */
	public function getTvEpisode($showid, $seasson, $episode, $lang = NULL) {
		$params = array (
				'language' => ($lang !== NULL) ? $lang : $this->getLang () 
		);
		return $this->_makeCall ( 'tv/' . $showid . '/season/' . $seasson . '/episode/' . $episode, $params );
	}
	
	/**
	 * Retrieve tv Episode images
	 *
	 * @param int $showid
	 *        	id of the show
	 * @param int $season
	 *        	season number
	 * @param int $episode
	 *        	episode number
	 * @param mixed $lang
	 *        	the result with a language (ISO 3166-1) other then default, use FALSE to retrieve results from all languages
	 * @return TMDb result array
	 */
	public function getTvEpisodeImages($showid, $seasson, $episode, $lang = NULL) {
		$params = array (
				'language' => ($lang !== NULL) ? $lang : $this->getLang () 
		);
		return $this->_makeCall ( 'tv/' . $showid . '/season/' . $seasson . '/episode/' . $episode . '/images', $params );
	}
	
	/**
	 * Retrieve tv Episode videos
	 *
	 * @param int $showid
	 *        	id of the show
	 * @param int $season
	 *        	season number
	 * @param int $episode
	 *        	episode number
	 * @param mixed $lang
	 *        	the result with a language (ISO 3166-1) other then default, use FALSE to retrieve results from all languages
	 * @return TMDb result array
	 */
	public function getTvEpisodeVideos($showid, $seasson, $episode, $lang = NULL) {
		$params = array (
				'language' => ($lang !== NULL) ? $lang : $this->getLang () 
		);
		return $this->_makeCall ( 'tv/' . $showid . '/season/' . $seasson . '/episode/' . $episode . '/videos', $params );
	}
	
	/**
	 * ******************************************************Person**********************************************
	 */
	
	/**
	 * Retrieve all basic information for a particular person
	 *
	 * @param int $id
	 *        	person-id
	 * @return TMDb result array
	 */
	public function getPerson($id) {
		return $this->_makeCall ( 'person/' . $id );
	}
	
	/**
	 * Retrieve all cast and crew information for a particular person
	 *
	 * @param int $id
	 *        	person-id
	 * @param mixed $lang
	 *        	the result with a language (ISO 3166-1) other then default, use FALSE to retrieve results from all languages
	 * @return TMDb result array
	 */
	public function getPersonCredits($id, $lang = NULL) {
		$params = array (
				'language' => ($lang !== NULL) ? $lang : $this->getLang () 
		);
		return $this->_makeCall ( 'person/' . $id . '/credits', $params );
	}
	
	/**
	 * Retrieve all images for a particular person
	 *
	 * @param mixed $id
	 *        	person-id
	 * @return TMDb result array
	 */
	public function getPersonImages($id) {
		return $this->_makeCall ( 'person/' . $id . '/images' );
	}
	
	/**
	 * Retrieve changes for a particular person
	 *
	 * @param mixed $id
	 *        	person-id
	 * @return TMDb result array
	 */
	public function getPersonChanges($id) {
		return $this->_makeCall ( 'person/' . $id . '/changes' );
	}
	
	/**
	 * Retrieve all id's from changed persons
	 *
	 * @param int $page
	 *        	of the page with results (default first page)
	 * @param string $start_date
	 *        	start date as YYYY-MM-DD
	 * @param string $end_date
	 *        	end date as YYYY-MM-DD (not inclusive)
	 * @return TMDb result array
	 */
	public function getChangedPersons($page = 1, $start_date = NULL, $end_date = NULL) {
		$params = array (
				'page' => ( int ) $page,
				'start_date' => $start_date,
				'start_date' => $end_date 
		);
		return $this->_makeCall ( 'person/changes', $params );
	}

	/**
	 * Retrieve all popular persons
	 *
	 * @param int $page
	 *        	of the page with results (default first page)
	 * @return TMDb result array
	 */
	public function getPopularPersons($page = 1) {
		$params = array (
				'page' => ( int ) $page
		);
		return $this->_makeCall ( 'person/popular', $params );
	}
	
	/**
	 * Retrieve all basic information for a particular production company
	 *
	 * @param int $id
	 *        	company-id
	 * @return TMDb result array
	 */
	public function getCompany($id) {
		return $this->_makeCall ( 'company/' . $id );
	}
	
	/**
	 * Retrieve movies for a particular production company
	 *
	 * @param int $id
	 *        	company-id
	 * @param int $page
	 *        	of the page with results (default first page)
	 * @param mixed $lang
	 *        	the result with a language (ISO 3166-1) other then default, use FALSE to retrieve results from all languages
	 * @return TMDb result array
	 */
	public function getMoviesByCompany($id, $page = 1, $lang = NULL) {
		$params = array (
				'page' => ( int ) $page,
				'language' => ($lang !== NULL) ? $lang : $this->getLang () 
		);
		return $this->_makeCall ( 'company/' . $id . '/movies', $params );
	}
	
	/**
	 * Retrieve a list of genres used on TMDb
	 *
	 * @param mixed $lang
	 *        	the result with a language (ISO 3166-1) other then default, use FALSE to retrieve results from all languages
	 * @return TMDb result array
	 */
	public function getGenres($lang = NULL) {
		$params = array (
				'language' => ($lang !== NULL) ? $lang : $this->getLang () 
		);
		return $this->_makeCall ( 'genre/movie/list', $params );
	}
	
	/**
	 * Retrieve movies for a particular genre
	 *
	 * @param int $id
	 *        	genre-id
	 * @param int $page
	 *        	of the page with results (default first page)
	 * @param mixed $lang
	 *        	the result with a language (ISO 3166-1) other then default, use FALSE to retrieve results from all languages
	 * @return TMDb result array
	 */
	public function getMoviesByGenre($id, $page = 1, $lang = NULL) {
		$params = array (
				'page' => ( int ) $page,
				'language' => ($lang !== NULL) ? $lang : $this->getLang () 
		);
		return $this->_makeCall ( 'genre/' . $id . '/movies', $params );
	}
	
	/**
	 * Authentication: retrieve authentication token
	 * More information about the authentication process: http://help.themoviedb.org/kb/api/user-authentication
	 *
	 * @return TMDb result array
	 */
	public function getAuthToken() {
		$result = $this->_makeCall ( 'authentication/token/new' );
		
		if (! isset ( $result ['request_token'] )) {
			if ($this->getDebugMode ()) {
				throw new TMDbException ( 'No valid request token from TMDb' );
			} else {
				return FALSE;
			}
		}
		
		return $result;
	}
	
	/**
	 * Authentication: retrieve authentication session and set it to the class
	 * More information about the authentication process: http://help.themoviedb.org/kb/api/user-authentication
	 *
	 * @param string $token        	
	 * @return TMDb result array
	 */
	public function getAuthSession($token) {
		$params = array (
				'request_token' => $token 
		);
		
		$result = $this->_makeCall ( 'authentication/session/new', $params );
		
		if (isset ( $result ['session_id'] )) {
			$this->setAuthSession ( $result ['session_id'] );
		}
		
		return $result;
	}
	
	/**
	 * Authentication: set retrieved session id in the class for authenticated requests
	 * More information about the authentication process: http://help.themoviedb.org/kb/api/user-authentication
	 *
	 * @param string $session_id        	
	 */
	public function setAuthSession($session_id) {
		$this->_session_id = $session_id;
	}
	
	/**
	 * Retrieve basic account information
	 *
	 * @param string $session_id
	 *        	session_id for the account you want to retrieve information from
	 * @return TMDb result array
	 */
	public function getAccount($session_id = NULL) {
		$session_id = ($session_id === NULL) ? $this->_session_id : $session_id;
		return $this->_makeCall ( 'account', NULL, $session_id );
	}
	
	/**
	 * Retrieve favorite movies for a particular account
	 *
	 * @param int $account_id
	 *        	account-id
	 * @param string $session_id
	 *        	session_id for the account you want to retrieve information from
	 * @param int $page
	 *        	of the page with results (default first page)
	 * @param mixed $lang
	 *        	result in other language then default for this user account (ISO 3166-1)
	 * @return TMDb result array
	 */
	public function getAccountFavoriteMovies($account_id, $session_id = NULL, $page = 1, $lang = FALSE) {
		$session_id = ($session_id === NULL) ? $this->_session_id : $session_id;
		$params = array (
				'page' => ( int ) $page,
				'language' => ($lang !== NULL) ? $lang : '' 
		);
		return $this->_makeCall ( 'account/' . $account_id . '/favorite_movies', $params, $session_id );
	}
	
	/**
	 * Retrieve rated movies for a particular account
	 *
	 * @param int $account_id
	 *        	account-id
	 * @param string $session_id
	 *        	session_id for the account you want to retrieve information from
	 * @param int $page
	 *        	of the page with results (default first page)
	 * @param mixed $lang
	 *        	result in other language then default for this user account (ISO 3166-1)
	 * @return TMDb result array
	 */
	public function getAccountRatedMovies($account_id, $session_id = NULL, $page = 1, $lang = FALSE) {
		$session_id = ($session_id === NULL) ? $this->_session_id : $session_id;
		$params = array (
				'page' => ( int ) $page,
				'language' => ($lang !== NULL) ? $lang : '' 
		);
		return $this->_makeCall ( 'account/' . $account_id . '/rated_movies', $params, $session_id );
	}
	
	/**
	 * Retrieve movies that have been marked in a particular account watchlist
	 *
	 * @param int $account_id
	 *        	account-id
	 * @param string $session_id
	 *        	session_id for the account you want to retrieve information from
	 * @param int $page
	 *        	of the page with results (default first page)
	 * @param mixed $lang
	 *        	result in other language then default for this user account (ISO 3166-1)
	 * @return TMDb result array
	 */
	public function getAccountWatchlistMovies($account_id, $session_id = NULL, $page = 1, $lang = FALSE) {
		$session_id = ($session_id === NULL) ? $this->_session_id : $session_id;
		$params = array (
				'page' => ( int ) $page,
				'language' => ($lang !== NULL) ? $lang : '' 
		);
		return $this->_makeCall ( 'account/' . $account_id . '/movie_watchlist', $params, $session_id );
	}
	
	/**
	 * Add a movie to the account favorite movies
	 *
	 * @param int $account_id
	 *        	account-id
	 * @param string $session_id
	 *        	session_id for the account you want to retrieve information from
	 * @param int $movie_id
	 *        	movie-id
	 * @param bool $favorite
	 *        	to favorites or remove from favorites (default TRUE)
	 * @return TMDb result array
	 */
	public function addFavoriteMovie($account_id, $session_id = NULL, $movie_id = 0, $favorite = TRUE) {
		$session_id = ($session_id === NULL) ? $this->_session_id : $session_id;
		$params = array (
				'movie_id' => ( int ) $movie_id,
				'favorite' => ( bool ) $favorite 
		);
		return $this->_makeCall ( 'account/' . $account_id . '/favorite', $params, $session_id, TMDb::POST );
	}
	
	/**
	 * Add a movie to the account watchlist
	 *
	 * @param int $account_id
	 *        	account-id
	 * @param string $session_id
	 *        	session_id for the account you want to retrieve information from
	 * @param int $movie_id
	 *        	movie-id
	 * @param bool $watchlist
	 *        	to watchlist or remove from watchlist (default TRUE)
	 * @return TMDb result array
	 */
	public function addMovieToWatchlist($account_id, $session_id = NULL, $movie_id = 0, $watchlist = TRUE) {
		$session_id = ($session_id === NULL) ? $this->_session_id : $session_id;
		$params = array (
				'movie_id' => ( int ) $movie_id,
				'movie_watchlist' => ( bool ) $watchlist 
		);
		return $this->_makeCall ( 'account/' . $account_id . '/movie_watchlist', $params, $session_id, TMDb::POST );
	}
	
	/**
	 * Add a rating to a movie
	 *
	 * @param string $session_id
	 *        	session_id for the account you want to retrieve information from
	 * @param int $movie_id
	 *        	movie-id
	 * @param float $value
	 *        	between 1 and 10
	 * @return TMDb result array
	 */
	public function addMovieRating($session_id = NULL, $movie_id = 0, $value = 0) {
		$session_id = ($session_id === NULL) ? $this->_session_id : $session_id;
		$params = array (
				'value' => is_numeric ( $value ) ? floatval ( $value ) : 0 
		);
		return $this->_makeCall ( 'movie/' . $movie_id . '/rating', $params, $session_id, TMDb::POST );
	}
	
	/**
	 * Get configuration from TMDb
	 *
	 * @return TMDb result array
	 */
	public function getConfiguration() {
		$config = $this->_makeCall ( 'configuration' );
		
		if (! empty ( $config )) {
			$this->setConfig ( $config );
		}
		
		return $config;
	}
	
	/**
	 * Get Image URL
	 *
	 * @param string $filepath
	 *        	to image
	 * @param const $imagetype
	 *        	type: TMDb::IMAGE_BACKDROP, TMDb::IMAGE_POSTER, TMDb::IMAGE_PROFILE
	 * @param string $size
	 *        	size for the image
	 * @return string
	 */
	public function getImageUrl($filepath, $imagetype, $size) {
		$config = $this->getConfig ();
		
		if (isset ( $config ['images'] )) {
			$base_url = $config ['images'] ['base_url'];
			$available_sizes = $this->getAvailableImageSizes ( $imagetype );
			
			if (in_array ( $size, $available_sizes )) {
				return $base_url . $size . $filepath;
			} else {
				throw new TMDbException ( 'The size "' . $size . '" is not supported by TMDb' );
			}
		} else {
			throw new TMDbException ( 'No configuration available for image URL generation' );
		}
	}
	
	/**
	 * Get available image sizes for a particular image type
	 *
	 * @param const $imagetype
	 *        	type: TMDb::IMAGE_BACKDROP, TMDb::IMAGE_POSTER, TMDb::IMAGE_PROFILE
	 * @return array
	 */
	public function getAvailableImageSizes($imagetype) {
		$config = $this->getConfig ();
		
		if (isset ( $config ['images'] [$imagetype . '_sizes'] )) {
			return $config ['images'] [$imagetype . '_sizes'];
		} else {
			throw new TMDbException ( 'No configuration available to retrieve available image sizes' );
		}
	}
	
	/**
	 * Get ETag to keep track of state of the content
	 *
	 * @param string $uri
	 *        	an URI to know the version of it. For example: 'movie/550'
	 * @return string
	 */
	public function getVersion($uri) {
		$headers = $this->_makeCall ( $uri, NULL, NULL, TMDb::HEAD );
		return isset ( $headers ['Etag'] ) ? $headers ['Etag'] : '';
	}
	
	/**
	 * Makes the call to the API
	 *
	 * @param string $function
	 *        	specific function name for in the URL
	 * @param array $params
	 *        	parameters for in the URL
	 * @param string $session_id
	 *        	for authentication to the API for specific API methods
	 * @param const $method
	 *        	or TMDb:POST (default TMDb::GET)
	 * @return TMDb result array
	 */
	private function _makeCall($function, $params = NULL, $session_id = NULL, $method = TMDb::GET) {
		$params = (! is_array ( $params )) ? array () : $params;
		$auth_array = array (
				'api_key' => $this->_apikey 
		);
		
		if ($session_id !== NULL) {
			$auth_array ['session_id'] = $session_id;
		}
		
		$url = $this->_apischeme . TMDb::API_URL . '/' . TMDb::API_VERSION . '/' . $function . '?' . http_build_query ( $auth_array, '', '&' );
		
		if ($method === TMDb::GET) {
			if (isset ( $params ['language'] ) and $params ['language'] === FALSE) {
				unset ( $params ['language'] );
			}
			
			$url .= (! empty ( $params )) ? '&' . http_build_query ( $params, '', '&' ) : '';
		}
		
		$results = '{}';
		
		if (extension_loaded ( 'curl' )) {
			$headers = array (
					'Accept: application/json' 
			);
			
			$ch = curl_init ();
			
			if ($method == TMDB::POST) {
				$json_string = json_encode ( $params );
				curl_setopt ( $ch, CURLOPT_POST, 1 );
				curl_setopt ( $ch, CURLOPT_POSTFIELDS, $json_string );
				$headers [] = 'Content-Type: application/json';
				$headers [] = 'Content-Length: ' . strlen ( $json_string );
			} elseif ($method == TMDb::HEAD) {
				curl_setopt ( $ch, CURLOPT_CUSTOMREQUEST, 'HEAD' );
				curl_setopt ( $ch, CURLOPT_NOBODY, 1 );
			}
			
			curl_setopt ( $ch, CURLOPT_URL, $url );
			curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
			curl_setopt ( $ch, CURLOPT_HEADER, 1 );
			curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
			
			$response = curl_exec ( $ch );
			
			$header_size = curl_getinfo ( $ch, CURLINFO_HEADER_SIZE );
			$header = substr ( $response, 0, $header_size );
			$body = substr ( $response, $header_size );
			
			$error_number = curl_errno ( $ch );
			$error_message = curl_error ( $ch );
			
			if ($error_number > 0) {
				throw new TMDbException ( 'Method failed: ' . $function . ' - ' . $error_message );
			}
			
			curl_close ( $ch );
		} else {
			throw new TMDbException ( 'CURL-extension not loaded' );
		}
		
		$results = json_decode ( $body, TRUE );
		
		if (strpos ( $function, 'authentication/token/new' ) !== FALSE) {
			$parsed_headers = $this->_http_parse_headers ( $header );
			$results ['Authentication-Callback'] = $parsed_headers ['Authentication-Callback'];
		}
		
		if ($results !== NULL) {
			return $results;
		} elseif ($method == TMDb::HEAD) {
			return $this->_http_parse_headers ( $header );
		} else {
			throw new TMDbException ( 'Server error on "' . $url . '": ' . $response );
		}
	}
	
	/**
	 * Setter for the default language
	 *
	 * @param string $lang
	 *        	3166-1)
	 * @return void
	 */
	public function setLang($lang) {
		$this->_lang = $lang;
	}
	
	/**
	 * Setter for the TMDB-config
	 *
	 * $param array $config
	 *
	 * @return void
	 */
	public function setConfig($config) {
		$this->_config = $config;
	}
	
	/**
	 * Getter for the default language
	 *
	 * @return string
	 */
	public function getLang() {
		return $this->_lang;
	}
	
	/**
	 * Getter for the TMDB-config
	 *
	 * @return array
	 */
	public function getConfig() {
		if (empty ( $this->_config )) {
			$this->_config = $this->getConfiguration ();
		}
		
		return $this->_config;
	}
	
	/*
	 * Internal function to parse HTTP headers because of lack of PECL extension installed by many
	 *
	 * @param string $header
	 * @return array
	 */
	protected function _http_parse_headers($header) {
		$return = array ();
		$fields = explode ( "\r\n", preg_replace ( '/\x0D\x0A[\x09\x20]+/', ' ', $header ) );
		foreach ( $fields as $field ) {
			if (preg_match ( '/([^:]+): (.+)/m', $field, $match )) {
				$match [1] = preg_replace ( '/(?<=^|[\x09\x20\x2D])./e', 'strtoupper("\0")', strtolower ( trim ( $match [1] ) ) );
				if (isset ( $return [$match [1]] )) {
					$return [$match [1]] = array (
							$return [$match [1]],
							$match [2] 
					);
				} else {
					$return [$match [1]] = trim ( $match [2] );
				}
			}
		}
		return $return;
	}
}

/**
 * TMDb Exception class
 *
 * @author Jonas De Smet - Glamorous
 */
class TMDbException extends Exception {
}

?>