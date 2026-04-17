<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url'));
	}

	private function render($content_view, $data = array())
	{
		$defaults = array(
			'app_name' => 'Checklist',
			'page_title' => 'Dashboard | Checklist',
			'page_heading' => 'Dashboard',
			'page_subtitle' => 'Track progress, priorities, and team activity from one place.',
			'breadcrumb_parent' => 'Dashboard',
			'current_page' => 'overview',
			'content_view' => $content_view,
		);

		$this->load->view('layouts/dashboard', array_merge($defaults, $data));
	}

	public function index()
	{
		$this->render('dashboard/index', array(
			'page_title' => 'Dashboard Overview | Checklist',
			'page_heading' => 'Dashboard Overview',
			'page_subtitle' => 'A quick snapshot of your workspaces, assignments, and delivery pace.',
			'breadcrumb_parent' => 'Workspace',
			'current_page' => 'overview',
		));
	}

	public function tasks()
	{
		$this->render('dashboard/tasks', array(
			'page_title' => 'Tasks | Checklist',
			'page_heading' => 'Tasks',
			'page_subtitle' => 'Review pending items, priorities, and ownership across the team.',
			'breadcrumb_parent' => 'Workspace',
			'current_page' => 'tasks',
		));
	}

	public function reports()
	{
		$this->render('dashboard/reports', array(
			'page_title' => 'Reports | Checklist',
			'page_heading' => 'Reports',
			'page_subtitle' => 'Monitor completion trends, team output, and upcoming deadlines.',
			'breadcrumb_parent' => 'Workspace',
			'current_page' => 'reports',
		));
	}

	public function equipment()
	{
		$this->render('dashboard/equipment', array(
			'page_title' => 'Equipment | Checklist',
			'page_heading' => 'Equipment',
			'page_subtitle' => 'Manage equipment inventory, status, and assigned team members.',
			'breadcrumb_parent' => 'Assets',
			'current_page' => 'equipment',
		));
	}
}
