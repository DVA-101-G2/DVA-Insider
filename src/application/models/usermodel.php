<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Usermodel extends CI_Model {
	var $userid;
	var $salt = '$2a$07$';
	var $select = array(
		'user_id',
		'user_type',
		'user_email',
		'user_ranks',
		'user_firstname',
		'user_surname',
		'user_registered',
		'user_last_login',
		'user_online'
	);

	public function Usermodel() {
		parent::__construct();
		$this->userid = $this->session->userdata('user_id');

		//Activity constants
		define("ACTIVITY_LOGIN", "login");
		define("ACTIVITY_REGISTER", "register");
		define("ACTIVITY_EMAIL_AUTHENCATION", "email_authentication");
		define("ACTIVITY_PAGE_LOAD", "page_load");
	}

	/**
	 * Denna metod används för att hämta information om en specifik användare.<br>
	 * Exempel: get_user()->user_email evalueras till användares email.
	 *
	 * @param integer $userid Användarid (user_id) för användaren (default session)
	 * @return stdclass|bool Ett object med alla kommunerna eller bool false om inte användaren fanns.
	 */
	public function get_user($userid = null) {
		if($userid == null)
			$userid = $this->userid;

		if(!$userid || !is_numeric($userid))
			return false;

		$this->db->where('user_id', $userid);
		$this->db->select($this->select);
		$query = $this->db->get('users');

		if($query->num_rows == 0)
			return false;

		$user = $query->row();

		$user->user_ranks = $this->explode_ranks($user->user_ranks);

		return $user;
	}

	public function get_user_image($userid = null) {
		if($userid == null)
			$userid = $this->userid;

		if(!$userid || !is_numeric($userid))
			return false;

		$this->db->where('user_id', $userid);
		$this->db->select('user_image');
		$query = $this->db->get('users');

		if($query->num_rows == 0)
			return false;
			
		$image = $query->row()->user_image;
		
		if(empty($image)) {
			$h = fopen(APPPATH."views/user/default_user.png", 'r');
			$image = fread($h, 10000000);
		}
		
		return $image;
	}

	/**
	 * Updatera vissa fält i databasen. Denna metod är samma som $this->db->update('users', $fields) fast serializar fält som behövs.
	 *
	 * @param array $fields Fältet som ska updateras.
	 * @param integer $userid Användarid (user_id) för användaren (default session)
	 * @return array Tolkade rankerna
	 */
	public function update_user($fields, $userid = null) {
		if($userid == null)
			$userid = $this->userid;

		if(!$userid || !is_numeric($userid))
			return false;

		if(array_key_exists('user_ranks', $fields))
			$fields['user_ranks'] = $this->implode_ranks($fields['user_ranks']);

		if(array_key_exists('user_password', $fields))
			$fields['user_password'] = crypt($fields['user_password'], $this->salt.random_string('alnum', 22));

		$this->db->where('user_id', $userid);
		$this->db->update('users', $fields);
	}

	/**
	 * Registerar en ny användare. Denna metod crypterar user_password och skapar nyckel för att kunna verifiera user_email med verify_email() senare.<br>
	 * För att användaren ska kunna logga in med login() krävs det att verify_email() kallas först med rätt nyckel.
	 *
	 * @param string $email E-mail för den nya användaren
	 * @param string $password Lösenord för nya användaren
	 * @param array $fields Fälten som ska läggas in samman med registerigen.
	 * @return array Allting som fanns i $fields, user_email_authentication_key och user_id
	 */
	public function register($email, $password, $fields) {
		$fields['user_password'] = crypt($password, $this->salt.random_string('alnum', 22));
		$fields['user_email_authentication'] = $email;
		$fields['user_email'] = null;
		$fields['user_email_authentication_key'] = strtoupper(random_string('alnum', 10));
		$fields['user_registered'] = time();
		$fields['user_id'] = $this->add_user($fields);
		unset($fields['user_password']);
		return $fields;
	}

	/**
	 * Gör en simple INSERT och retunerar id som columnen fick dvs user_id
	 *
	 * @param array $fields Fälten som ska sättas in i databasen.
	 * @return integer user_id som användaren fick vid insättning i databasen
	 */
	public function add_user($fields) {
		$this->db->insert('users', $fields);
		return $this->db->insert_id();
	}

	/**
	 * Tolkar en rank string för att göra om den till en array.
	 * Exempel: explode_ranks("413213:Admin;443123:Databasadministratör;") evalueras till:<br>
	 * ﻿Array ( [0] => stdClass Object ( [name] => Admin [color] => 413213 ) [1] => stdClass Object ( [name] => Databasadministratör [color] => 443123 ) )
	 *
	 * @param string $ranks Strängen som ska tolkas
	 * @return array Tolkade rankerna
	 */
	public function explode_ranks($ranks) {
		$return[] = array();
		$matches[] = array();
		preg_match_all('/(.*?):(.*?);/', $ranks, $matches);
		for($i = 0; $i < count($matches[2]);$i++) {
			$o = new stdclass;

			$o->name = $matches[2][$i];

			if($i >= count($matches[1]))
				$o->color = "";
			else
				$o->color = $matches[1][$i];

			$return[$i-1] = $o;
		}
		return $return;
	}

	private function implode_ranks($ranks) {
		$return = "";
		foreach($ranks as $rank){
			$return .= $rank->color.':'.$rank->name.';';
		}
		return $return;
	}

	/**
	 * Kollar om en epostaddress existerar i databasen.
	 *
	 * @param string $email Epostaddressen
	 * @return bool true om epostaddressen fanns, annars false
	 */
	public function does_email_exist($email) {
		$this->db->where('user_email', $email);
		return $this->db->get('users')->num_rows > 0;
	}

	/**
	 * Verifierar en epostaddress. Se register()
	 *
	 * @param integer $userid user_id
	 * @param string $verifycode Koden som register() genererade
	 * @return bool true om verifieringen lyckades, false om den misslyckades
	 */
	public function verify_email($userid, $verifycode) {
		$this->db->where('user_id', $userid);
		$this->db->where('user_email_authentication_key', $verifycode);
		$this->db->select('user_email_authentication');
		$query = $this->db->get('users');
		if($query->num_rows == 0)
			return false;

		$newemail = $query->row()->user_email_authentication;

		if($this->does_email_exist($newemail))
			return false;

		$this->db->where('user_id', $userid);
		$this->db->update('users', array('user_email' => $newemail, 'user_email_authentication_key' => '', 'user_email_authentication' => '', 'user_registered' => time()));

		return true;
	}

	/**
	 * Hittar användaren med den angivna epostaddressen och verifierar lösenordet.
	 *
	 * @param string $email Epostaddressen
	 * @param string $password Lösenordet
	 * @return stdclass|bool Användardata (precis som get_user()) om inloggningen var korrekt, annars false
	 */
	public function login($email, $password) {
		$this->db->select(array_merge($this->select, array('user_password')));
		$this->db->where('user_email', $email);
		$query = $this->db->get('users');

		if($query->num_rows == 0)
			return false;

		$row = $query->row();

		if(crypt($password, $row->user_password) === $row->user_password) {
			$row->user_ranks = $this->explode_ranks($row->user_ranks);
			unset($row->user_password); //Password behövs inte skickas med här.
			$this->update_user(array('user_last_login' => time()), $row->user_id);
			return $row;
		}

		return false;
	}

	/**
	 * Hämtar aktiviteter som användaren har gjort.
	 *
	 * @param string $email Epostaddressen
	 * @param string $password Lösenordet
	 * @return stdclass|bool Användardata (precis som get_user()) om inloggningen var korrekt, annars false
	 */
	 /*
	public function get_user_activity($scope, $userid = null, $limit = 10, $from = 0) {
		if($userid == null)
			$userid = $this->userid;

		if(!$userid || !is_numeric($userid))
			return false;

		$this->db->where('user_id', $userid);
		$this->db->where('activity_visibility >=', $scope);
		$this->db->limit($from, $limit);
		return $this->db->get('user_activities');
	}*/

	/**
	 * Kollar om användaren är inloggad.
	 *
	 * @return bool true om inloggad, annars false
	 */
	public function is_authenticated()
	{
		$userid = $this->userid;

		if(!$userid || !is_numeric($userid))
			return false;

		return true;

	}

	/**
	 * Hämtar aktiviteter som användaren har gjort.
	 *
	 * @param string $tablename namnet på tabellen där man kollar rättigheten
	 * @param int    $item_id vilket id i tabellen man kollar permission på
	 * @param string $action vilken action (create/read/update/delete)
	 * @return bool true/false om man har permission.
	 */
	public function has_permission($tablename = null,  $item_id = 0, $action = 'read')
	{
		$userid = $this->userid;

		if(!$userid || !is_numeric($userid) || !$tablename)
			return false;

		$groups = $this->groupfinder($userid);

		if (!count($groups)) // cant have access if not member in any groups? :]
			return false;

		$asql = "SELECT g.name, r.action
				 FROM groups AS g
				 INNER JOIN mapper as m
				 ON m.group_id = g.group_id
				 INNER JOIN resources as r
				 ON r.resource_id = m.resource_id
				 WHERE r.tablename = ? AND m.item_id = 0 AND r.action = 'ALL'";

		$admins = $this->db->query($asql, array($tablename));

		if ($admins->num_rows() > 0)
		{
			foreach ($admins->result() as $root)
			{
				foreach ($groups as $group)
				{
					if ($group->name == $root->name)
						return true;
				}
			}
		}

		$tablename_id = substr($tablename, 0, -1) . "_id";

		$sql = "SELECT g.name, r.action
				FROM groups AS g
				INNER JOIN mapper as m
				ON m.group_id = g.group_id
				INNER JOIN " . $tablename . " as t
				ON t." . $tablename_id . " = m.item_id
				INNER JOIN resources as r
				ON r.resource_id = m.resource_id
				WHERE t." . $tablename_id . " = ? AND r.tablename = ?";

		$query = $this->db->query($sql, array($item_id, $tablename));

		if ($query->num_rows() > 0)
		{
		   foreach ($query->result() as $row)
		   {
		      foreach ($groups as $group)
		      {
		      	if ($group->name == $row->name && ($row->action == $action || $row->action == '*'))
		      		return true;
		      }
		   }
		}

		return false;

	}

	/**
	 * Hämtar grupper som användaren är medlem i.
	 *
	 * @param int $userid Epostaddressen
	 * @return stdclass|array grupper användaren är medlem i
	 */
	public function groupfinder($userid = null)
	{

		if($userid == null)
			$userid = $this->userid;

		if(!$userid || !is_numeric($userid))
			return false;

		$sql = "SELECT g.name
				FROM groups as g
				INNER JOIN members AS m
				ON m.group_id = g.group_id
				INNER JOIN users as u
				ON m.user_id = u.user_id
				WHERE u.user_id = ?";

		$query = $this->db->query($sql, array($userid));

		return $query->result();

	}
	
	//Widgets
	public function get_all_widgets($user_id) {
		$this->load->model('widgetmodel');
		return $this->widgetmodel->get_all_widgets('user', $user_id);
	}

}