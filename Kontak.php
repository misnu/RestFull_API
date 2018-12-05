<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Kontak extends REST_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
		$this->load->library('form_validation');
    }

    //Menampilkan data kontak
    function index_get() {
        $id = $this->get('username');
        if ($id == '') {
            $kontak = $this->db->get('user')->result();
        } else {
            $this->db->where('username', $id);
            $kontak = $this->db->get('user')->result();
        }
        $this->response($kontak, 200);
    }

     //Mengirim atau menambah data kontak baru
    function index_post() {
		$user = $this->post('username');
		$q = $this->db->select('username')->where('username', $user)->get('user')->row();
		if(emty($q->username))
			{
				$note = 'TRUE';
			}else{
				$note ='FALSE';
			}
       		 $data = array(
                    'username' => $this->post('username'),
                    'email'    => $this->post('email'),
                    'image'    => $this->post('image'),
					'note'     => $note,	
					);
					
       		 $insert = $this->db->insert('user', $data);
        	if ($insert) {
           	 $this->response($data, 200);
        	} else {
           	 $this->response(array('status' => 'fail', 502));
       		}
		
		
    }
	
	   //Memperbarui data kontak yang telah ada
    function index_put() {
        $id = $this->put('username');
        $data = array(
                    'username' => $this->post('username'),
                    'email'    => $this->post('email'),
                    'image'    => $this->post('image'),
					'note'     => $this->post('note'),	
					);
        $this->db->where('username', $id);
        $update = $this->db->update('user', $data);
        if ($update) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }
	
	  //Menghapus salah satu data kontak
    function index_delete() {
        $id = $this->delete('username');
        $this->db->where('username', $id);
        $delete = $this->db->delete('user');
        if ($delete) {
            $this->response(array('status' => 'success'), 201);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }
}
?>