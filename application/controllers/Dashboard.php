<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url'));
		$this->load->model('Equipment_model');
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
		$equipment = $this->Equipment_model->get_all();
		$this->render('dashboard/equipment', array(
			'page_title' => 'Equipment | Checklist',
			'page_heading' => 'Equipment',
			'page_subtitle' => 'Manage equipment inventory, status, and assigned team members.',
			'breadcrumb_parent' => 'Assets',
			'current_page' => 'equipment',
			'equipment' => $equipment
		));
	}

	public function add_equipment()
	{
		$data = array(
			'name' => $this->input->post('name'),
			'qr_code' => $this->input->post('qr_code'),
			'model' => $this->input->post('model'),
			'location' => $this->input->post('location'),
			'manufacturer' => $this->input->post('manufacturer'),
			'status' => $this->input->post('status')
		);

		if ($this->Equipment_model->create($data)) {
			$this->session->set_flashdata('success', 'Equipment added successfully.');
		} else {
			//add error log

			$this->session->set_flashdata('error', 'Failed to add equipment.');
		}
		redirect('dashboard/equipment');
	}

	public function edit_equipment($id)
	{
		if ($this->input->post()) {
			$data = array(
				'name' => $this->input->post('name'),
				'qr_code' => $this->input->post('qr_code'),
				'model' => $this->input->post('model'),
				'location' => $this->input->post('location'),
				'manufacturer' => $this->input->post('manufacturer'),
				'status' => $this->input->post('status')
			);
			if ($this->Equipment_model->update($id, $data)) {
				$this->session->set_flashdata('success', 'Equipment updated successfully.');
			} else {
				$this->session->set_flashdata('error', 'Failed to update equipment.');
			}
			redirect('dashboard/equipment');
		} else {
			$equipment = $this->Equipment_model->get_by_id($id);
			if ($equipment) {
				$data = array(
					'page_title' => 'Edit Equipment | Checklist',
					'page_heading' => 'Edit Equipment',
					'page_subtitle' => 'Update equipment details.',
					'breadcrumb_parent' => 'Equipment',
					'current_page' => 'equipment',
					'equipment' => $equipment
				);
				$this->render('dashboard/equipment_edit', $data);
			} else {
				show_404();
			}
		}
	}

	public function delete_equipment($id)
	{
		if ($this->Equipment_model->delete($id)) {
			$this->session->set_flashdata('success', 'Equipment deleted successfully.');
		} else {
			$this->session->set_flashdata('error', 'Failed to delete equipment.');
		}
		redirect('dashboard/equipment');
	}

	public function print_equipment()
	{
		while (ob_get_level()) {
			ob_end_clean();
		}

		$this->load->library('pdf');
		$this->load->model('Checklist_model');

		$equipment_id = 1;
		$year = 2026;
		$month = 4;

		$dataMap = $this->Checklist_model->get_month_data($equipment_id, $year, $month);

		$questions = $this->Checklist_model->get_questions($equipment_id);

		$data = [
			'logo' => base_url('assets/images/mhood.png'),
			'title' => 'DAILY CHECK LIST FOR 250 KVA DIESEL GENERATOR - 1',
			'year' => $year,
			'month_name' => date('F', mktime(0, 0, 0, $month, 1)),
			'items' => $questions,
			'dataMap' => $dataMap
		];

		// 🔥 Load view as HTML string
		$html = $this->load->view('pdf/checklist_template', $data, true);

		$pdf = new Pdf('L', 'mm', 'A4', true, 'UTF-8', false);

		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->SetMargins(10, 10, 10);
		$pdf->AddPage('L');

		$pdf->SetFont('dejavusans', '', 8);

		$pdf->writeHTML($html, true, false, true, false, '');

		$pdf->Output('checklist.pdf', 'I');
		exit;
	}
}
?>