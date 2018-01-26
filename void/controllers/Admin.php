<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Controller {

	public function index()
	{
		$this->wip();
	}

    public function access()
    {
        $this->admin();

        $this->var['accessLog'] = $this->_accessLog->getAll();

        $this->loadView('admin/access', $this->var);
    }
}
