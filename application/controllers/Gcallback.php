<?phpdefined('BASEPATH') OR exit('No direct script access allowed');class Gcallback extends CI_Controller {	 function __construct()    {      parent::__construct();//      parent::__construct();            $this->load->database();    }	public function index()	{     require_once APPPATH."config/Googleconfig.php";     if(isset($_GET['code']))     {       $token = $gClient->fetchAccessTokenWithAuthCode($_GET['code']);       $_SESSION['access_token'] = $token;     }     $Auth = new Google_Service_Oauth2($gClient);     $userData = $Auth->userinfo_v2_me->get();     $_SESSION['id']  = $userData['id'];     $_SESSION['email']  = $userData['email'];     $_SESSION['gender']  = $userData['gender'];     $_SESSION['picture']  = $userData['picture'];     $_SESSION['first_name']  = $userData['givenName'];     $_SESSION['last_name']  = $userData['familyName'];     $data['oauth_provider'] = 'google';     $data['oauth_uid']      = $userData['id'];     $data['email']=$_SESSION['email'];     $data['gender']=!empty($_SESSION['gender'])?$_SESSION['gender']:'';     $data['picture']=!empty($_SESSION['picture'])?$_SESSION['picture']:'';     $data['locale']         = !empty($userData['locale'])?$userData['locale']:'';    $data['link']    = !empty($userData['link'])?$userData['link']:'';         $data['first_name']=$_SESSION['first_name'];     $data['last_name']=$_SESSION['last_name'];          $this->load->model('Auth_user_model');     //insert or update user data to the database$userId = $this->Auth_user_model->checkUser($data);if($userId>0){    //store status & user info in session            $this->session->set_userdata('loggedIn', true);            $this->session->set_userdata('userData', $userData);             $this->session->set_userdata('gUserId', $userId);     $this->load->view('Table_select');}	}}?>