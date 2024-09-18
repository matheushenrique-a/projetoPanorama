<?php 
namespace App\Models;
use CodeIgniter\Model;
use App\Libraries\dbMaster;
use App\Models\M_http;

class M_meta extends Model {
    protected $dbMaster;
    protected $my_session;

    public function __construct()
    {
        $this->dbMaster = new dbMaster();
        $this->my_session = session();
    }

    public function changeStatusCpg($id, $status){
        $headers = $this->getHeader();
		$url = META_GRAPH_API . ($id) . "?access_token=" . META_TOKEN . "&status=" . $status;
		//echo $url;exit;
        //$url = urlencode($url);
		//echo $url;exit;
        $result =  $this->m_http->http_request('POST', $url, $headers);
        //echo '18:18:12 - <h3>Dump 26 </h3> <br><br>' . var_dump($result); exit;					//<-------DEBUG
		return $result;
	}
}


?>