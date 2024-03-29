<?php

/* 
 * Used to communicate with Pinterest
 * Inspired by https://github.com/dzafel/pinterest-pinner
 */

class Pinim_Bridge{
    
    /**
     * Pinterest.com base URL
     */
    private $pinterest_url = 'https://www.pinterest.com';
    private $pinterest_login_url = 'https://www.pinterest.com/login';
    
    /**
     * @var Pinterest App version loaded from pinterest.com
     */
    private $_app_version = null;
    
    private $login = null;
    private $password = null;
    
    /**
     * @var CSRF token loaded from pinterest.com
     */
    private $_csrftoken = null;
    
    private $cookies = array();
    
    protected $headers = array();
    
    public $is_logged_in = false;
    
    public $user_data = null;

    
    public function __construct(){
        // Default HTTP headers for requests

    }
    
    /**
     * Set Pinterest account login.
     *
     * @param string $login
     */
    public function set_login($login){
        $this->login = $login;
        return $this;
    }
    /**
     * Set Pinterest account password.
     *
     * @param string $password
     */
    public function set_password($password){
        $this->password = $password;
        return $this;
    }
    
    function get_headers($headers = array()){
        $default = array(
            'Host'              => str_replace('https://', '', $this->pinterest_url),
            'Origin'            => $this->pinterest_url,
            'Referer'           => $this->pinterest_url,
            'Connection'        => 'keep-alive',
            'Pragma'            => 'no-cache',
            'Cache-Control'     => 'no-cache',
            'Accept-Language'   => 'en-US,en;q=0.5',
            'User-Agent'        => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML => like Gecko) Iron/31.0.1700.0 Chrome/31.0.1700.0' 
        );
        
        return wp_parse_args($headers,$default);
    }
    
    function get_logged_headers($headers = array()){
        
        $app_version = $this->_getAppVersion();
        
        if ( is_wp_error($app_version) ) {
            return $app_version;
        }
        
        $login_headers = array(
                'X-NEW-APP'             => 1,
                //'X-Requested-With'      => 'XMLHttpRequest',
                'Accept'                => 'application/json, text/javascript, */*; q=0.01',
                'X-APP-VERSION'         => $app_version,
                'X-CSRFToken'           => $this->_csrftoken,
                'X-Pinterest-AppState'  => 'active',
                'X-Requested-With'  => 'XMLHttpRequest',
        );
        
        $default = wp_parse_args(
                $this->get_headers(),
                $login_headers
        );
        
        return wp_parse_args($headers,$default);
        
    }
    
    public function maybe_decode_response($response){
        if (substr($response, 0, 1) === '{') {
            $response = json_decode($response, true);
        }
        return $response;
    }
    
    public function set_auth($response){
        
        if (is_wp_error($response)) return false;

        $this->cookies = $response['cookies'];

        foreach ((array)$this->cookies as $cookie){
            if ($cookie->name !='csrftoken') continue;
            $this->_csrftoken = $cookie->value;
        }
    }
    
    private function refresh_token($url = null){
        
        $extra_headers = array();
        
        $headers = $this->get_logged_headers($extra_headers);
        
        $args = array(
            'headers'       => $headers,
            'cookies'       => $this->cookies
        );
        
        $response = wp_remote_get( $this->pinterest_url.$url, $args );
        $this->set_auth($response); //udpate token & cookies for further requests
        return $this->_csrftoken;
    }
    
    /**
     * Try to log in to Pinterest.
     * @return \WP_Error
     */
    public function do_login(){
        
        $api_error = null;

        if ($this->is_logged_in) return $this->is_logged_in;
        
        if (!isset($this->login) or !isset($this->password)) {
            return new WP_Error('pinim',__('Missing login and/or passwordAA','pinim'));
        }
        
        $refresh_token = $this->refresh_token();

        $data = array(
            'data' => json_encode(array(
                'options' => array(
                    'username_or_email' => $this->login,
                    'password' => $this->password,
                ),
                'context' => new \stdClass,
            )),
            'source_url' => '/login/',
            'module_path' => 'App()>LoginPage()>Login()>Button(class_name=primary, text=Log In, type=submit, size=large)',
        );
        
        $url = $this->pinterest_url.'/resource/UserSessionResource/create/';

        $extra_headers = array(
            'Referer'           => $this->pinterest_login_url,
            //'Content-Type'      => 'application/x-www-form-urlencoded; charset=UTF-8'
        );

        $headers = $this->get_logged_headers($extra_headers);

        if (is_wp_error($headers)){
            return $headers;
        }

        $args = array(
            'headers'       => $headers,
            'body'          => http_build_query($data),
            'cookies'       => $this->cookies
        );

        $response = wp_remote_post( $url, $args );
        $body = wp_remote_retrieve_body($response);

        if ( is_wp_error($body) ){
            return $body;
        }

        $this->set_auth($response); //udpate token & cookies for further requests
        $body = $this->maybe_decode_response($body);

        if (isset($body['resource_response']['error']) and $body['resource_response']['error']) {
            $api_error = $body['resource_response']['error'];
        }

        if (!isset($body['resource_response']['data']) or !$body['resource_response']['data']) {
            return new WP_Error('pinim',__('Unknown error while logging in.','pinim'),$api_error);
        }

        $this->is_logged_in = true;
        return $this->is_logged_in;
    }

    /**
     * Get Pinterest App Version.
     * @return \WP_Error
     */
    private function _getAppVersion(){
        
        if ($this->_app_version) return $this->_app_version;
        
        $url = $this->pinterest_login_url;
        
        $args = array(
            'headers'       => $this->get_headers()
        );

        $response = wp_remote_get( $url, $args );
        $body = wp_remote_retrieve_body($response);
        
        if ( is_wp_error($body) ){
            return $body;
        }

        if (is_string($body)){

            preg_match('/P\.scout\.init\((\{.+\})\);/isU', $body, $match);

            if (isset($match[1]) and $match[1]) {

                $app_json = @json_decode($match[1], true);
                
                if (isset($app_json['context']['app_version'])){
                    $this->_app_version = $app_json['context']['app_version'];
                    return $this->_app_version;
                }
            }
        }
        
        return new WP_Error('pinim',__('Error getting App Version','pinim'));
    }
    
    /**
     * Get logged in user data.
     * @return \WP_Error
     */
    public function get_user_datas(){
        
        if ($this->user_data) return $this->user_data;
        
        $login = $this->do_login();

        if (is_wp_error($login)){
            return $login;
        }

        $extra_headers = array(
            //'Referer'   => '/'
        );

        $headers = $this->get_logged_headers($extra_headers);
        
        
        
        if (is_wp_error($headers)) return $headers;

        $args = array(
            'headers'       => $headers,
            'cookies'       => $this->cookies
        );

        $response = wp_remote_get( $this->pinterest_url.'/me/', $args );
        $this->set_auth($response); //udpate token & cookies
        
        $body = wp_remote_retrieve_body($response);

        if ( is_wp_error($body) ){
            return $body;
        }

        $body = $this->maybe_decode_response($body);

        if (isset($body['resource_data_cache'][0]['data'])) {
            $data = $body['resource_data_cache'][0]['data'];
            if (isset($data['repins_from'])) {
                unset($data['repins_from']);
            }
            $this->user_data = array_filter($data);
            return $this->user_data;
        }

        return new WP_Error('pinim',__('Unknown error while getting user data','pinim'));
    }
    
    /**
     * 
     * @return \WP_Error
     */
    
    public function get_user_boards(){
        
        if ( empty($this->user_boards) ) {

            $bookmark = array();
            $board_page = 0;
            $boards = array();

            while ($bookmark != '-end-') { //end loop when bookmark "-end-" is returned by pinterest

                $query = $this->get_user_boards_page($bookmark);

                if ( is_wp_error($query) ){
                    return new WP_Error( 'pinim', $query->get_error_message(), $boards ); //return already loaded boards with error
                }

                $bookmark = $query['bookmark'];

                if (isset($query['boards'])){

                    $page_boards = $query['boards'];

                    $boards = array_merge($boards,$page_boards);

                }

                $board_page++;

            }
            
            $this->user_boards = $boards;
            
        }
        
        return $this->user_boards;
        
    }

    /**
     * 
     * @param type $bookmark
     * @return \WP_Error
     */
    
    public function get_user_boards_page($bookmark = null){
        
        $page_boards = array();
        
        $user_datas = $this->get_user_datas();
        
        if (is_wp_error($user_datas)){
            return __('You are not logged in.  Unable to get boards !','pinim');
        }

        $data_options = array(
            'field_set_key'     => 'grid_item',
            'username'          => $user_datas['username'],
            'sort'              => 'profile'
        );
        
        if ($bookmark){ //used for pagination. Bookmark is defined when it is not the first page.
            $data_options['bookmarks'] = (array)$bookmark;
        }
        
        $data = array(
            'data' => json_encode(array(
                'options' => $data_options,
                'context' => new \stdClass,
            )),
            'source_url' => '/'.$user_datas['username'].'/',
            '_' => time()*1000 //js timestamp
        );
        
        $extra_headers = array(
            //'Referer'   => '/'
        );
        
        $headers = $this->get_logged_headers($extra_headers);
        
        if (is_wp_error($headers)) return $headers;

        $args = array(
            'headers'       => $headers,
            'cookies'       => $this->cookies,
            'body'          => $data,
        );

        $response = wp_remote_post( $this->pinterest_url.'/resource/BoardsResource/get/', $args );
        //$this->set_auth($response); //udpate token & cookies
        
        $body = wp_remote_retrieve_body($response);

        if ( is_wp_error($body) ){
            return $body;
        }

        $body = $this->maybe_decode_response($body);
        
        
        
        if (isset($body['resource_data_cache'][0]['data'])){

            $page_boards = $body['resource_data_cache'][0]['data'];
            
            

            //remove items that have not the "pin" type (like module items)
            $page_boards = array_filter(
                $page_boards,
                function ($e) {
                    return $e['type'] == 'board';
                }
            );  
            $page_boards = array_values($page_boards); //reset keys

            //bookmark (pagination)
            if (isset($body['resource']['options']['bookmarks'][0])){
                $bookmark = $body['resource']['options']['bookmarks'][0];
            }
            
            return array('boards'=>$page_boards,'bookmark'=>$bookmark);

        }

        return new WP_Error('pinim',__('Error getting user boards','pinim'));

    }
    
    /**
     * Get all pins for a board.
     * @param type $board
     * @param type $bookmark
     * @param type $max
     * @param type $stop_at_pin_id
     * @return \WP_Error
     */

    public function get_board_pins($board,$bookmark=null,$max=0,$stop_at_pin_id=null){
        $board_page = 0;
        $board_pins = array();
        //$bookmark = null; //TO FIX, the bookmark thing seems not to work.

        while ($bookmark != '-end-') { //end loop when bookmark "-end-" is returned by pinterest

            $query = $this->get_board_pins_page($board,$bookmark);
            
            if ( is_wp_error($query) ){
                
                if(empty($board_pins)){
                    $message = $query->get_error_message();
                }else{
                    $message = sprintf(__('Error getting some of the pins for board #%1$s','pinim'),$board->board_id);
                }
                
                return new WP_Error( 'pinim', $message, array('pins'=>$board_pins,'bookmark'=>$bookmark) ); //return already loaded pins with error
            }

            $bookmark = $query['bookmark'];

            if (isset($query['pins'])){

                $page_pins = $query['pins'];

                //stop if this pin ID is found
                if ($stop_at_pin_id){
                    foreach($page_pins as $key=>$pin){
                        if (isset($pin['id']) && $pin['id']==$stop_at_pin_id){
                            $page_pins = array_slice($page_pins, 0, $key+1);
                            $bookmark = '-end-';
                            break;
                        }
                    }
                }
                
                $board_pins = array_merge($board_pins,$page_pins);

                //limit reached
                if ( ($max) && ( count($board_pins)> $max) ){
                    $board_pins = array_slice($board_pins, 0, $max);
                    $bookmark = '-end-';
                    break;
                }

            }

            $board_page++;
            
        }
        
        return array('pins'=>$board_pins,'bookmark'=>$bookmark);

    }
    
    /**
     * 
     * @param type $board
     * @param type $bookmark
     * @return \WP_Error
     */
    private function get_board_pins_page($board, $bookmark = null){

        $page_pins = array();
        $data_options = array();
        $url = null;
        
        $user_datas = $this->get_user_datas();

        if (is_wp_error($user_datas)){
            return $user_datas;
        }
        
        if ($board->board_id == 'likes'){
            
            $data_options = array(
                'username'                  => $user_datas['username']
            );
            
            
        }else{
            
            $data_options = array(
                'board_id'                  => $board->board_id,
                'add_pin_rep_with_place'    => null,
                'board_url'                 => $board->get_datas('url'),
                'page_size'                 => null,
                'prepend'                   => true,
                'access'                    => array('write','delete'),
                'board_layout'              => 'default',

            );
            
        }


        
        if ($bookmark){ //used for pagination. Bookmark is defined when it is not the first page.
            $data_options['bookmarks'] = (array)$bookmark;
        }
        
        $data = array(
            'data' => json_encode(array(
                'options' => $data_options,
                'context' => new \stdClass,
            )),
            'source_url' => $board->get_datas('url'),
            '_' => time()*1000 //js timestamp
        );
        
        /*
        if ($board->board_id == 'likes'){
            
            $data['module_path'] = sprintf('App()>UserProfilePage(resource=UserResource(username=%1$s))>UserInfoBar(tab=likes, spinner=[object Object], resource=UserResource(username=%1$s, invite_code=null))',
                        $user_datas['username'],
                        $board->board_id
            );
            
        }else{
            
            $data['module_path'] = sprintf('UserProfilePage(resource=UserResource(username=%1$s, invite_code=null))>UserProfileContent(resource=UserResource(username=%1$s, invite_code=null))>UserBoards()>Grid(resource=ProfileBoardsResource(username=%1$s))>GridItems(resource=ProfileBoardsResource(username=%1$s))>Board(show_board_context=false, show_user_icon=false, view_type=boardCoverImage, component_type=1, resource=BoardResource(board_id=%2$d))',
                        $user_datas['username'],
                        $board->board_id
            );
            
        }
         */

        $extra_headers = array(
            //'Referer'   => '/'
            'X-Pinterest-AppState'  => 'background'
        );
        
        $headers = $this->get_logged_headers($extra_headers);

        if (is_wp_error($headers)) return $headers;

        $args = array(
            'headers'       => $headers,
            'cookies'       => $this->cookies,
            'body'          => $data,
        );
        
        if ($board->board_id == 'likes'){
            $url = $this->pinterest_url.'/resource/UserLikesResource/get/';
        }else{
            $url = $this->pinterest_url.'/resource/BoardFeedResource/get/';
        }

        $response = wp_remote_post( $url, $args );        
        $body = wp_remote_retrieve_body($response);

        if ( is_wp_error($body) ){
            return $body;
        }

        $body = $this->maybe_decode_response($body);

        if (isset($body['resource_data_cache'][0]['data'])){

            $page_pins = $body['resource_data_cache'][0]['data'];

            //remove items that have not the "pin" type (like module items)
            $page_pins = array_filter(
                $page_pins,
                function ($e) {
                    return $e['type'] == 'pin';
                }
            );  
            $page_pins = array_values($page_pins); //reset keys

            //bookmark (pagination)
            if (isset($body['resource']['options']['bookmarks'][0])){
                $bookmark = $body['resource']['options']['bookmarks'][0];
            }

            return array('pins'=>$page_pins,'bookmark'=>$bookmark);
            
        }

        return new WP_Error('pinim',sprintf(__('Error getting pins for board #%1$s','pinim'),$board->board_id));

    }
    /*
     * Converts an array to a string with keys and values
     
    private function implode_api_error($input){
        if (!is_array($input)) return $input;
        $input = array_filter($input);
        return implode('; ', array_map(function ($v, $k) { return sprintf('%s="%s"', $k, $v); }, $input, array_keys($input)));
    }
    */
    
}
