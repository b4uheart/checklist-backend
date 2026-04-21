<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url'));
		$this->load->model('Equipment_model');
		$this->load->model('Checklist_model');
		$this->load->model('Checklist_question_model');
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
		$equipment = $this->Equipment_model->get_all();
		$selected_equipment_id = (int) $this->input->get('equipment_id');
		$selected_year = (int) $this->input->get('year');
		$selected_month = (int) $this->input->get('month');

		if ($selected_year < 2000 || $selected_year > 2100) {
			$selected_year = (int) date('Y');
		}

		if ($selected_month < 1 || $selected_month > 12) {
			$selected_month = (int) date('n');
		}

		if ($selected_equipment_id <= 0 && !empty($equipment)) {
			$selected_equipment_id = (int) $equipment[0]['id'];
		}

		$selected_equipment = null;
		$questions = array();
		$dataMap = array();

		if ($selected_equipment_id > 0) {
			$selected_equipment = $this->Equipment_model->get_by_id($selected_equipment_id);

			if ($selected_equipment) {
				$questions = $this->Checklist_model->get_questions($selected_equipment_id);
				$dataMap = $this->Checklist_model->get_month_data($selected_equipment_id, $selected_year, $selected_month);
			}
		}

		$days_in_month = cal_days_in_month(CAL_GREGORIAN, $selected_month, $selected_year);

		$this->render('dashboard/reports', array(
			'page_title' => 'Equipment Reports | Checklist',
			'page_heading' => 'Equipment Reports',
			'page_subtitle' => 'Review monthly checklist activity on-screen without generating a printable PDF.',
			'breadcrumb_parent' => 'Assets',
			'current_page' => 'reports',
			'equipment' => $equipment,
			'selected_equipment' => $selected_equipment,
			'selected_equipment_id' => $selected_equipment_id,
			'selected_year' => $selected_year,
			'selected_month' => $selected_month,
			'month_name' => date('F', mktime(0, 0, 0, $selected_month, 1)),
			'days_in_month' => $days_in_month,
			'questions' => $questions,
			'dataMap' => $dataMap,
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

	public function checklist_questions($equipment_id)
	{
		$equipment = $this->Equipment_model->get_by_id($equipment_id);

		if (!$equipment) {
			show_404();
		}

		$questions = $this->Checklist_question_model->get_by_id($equipment_id);

		$this->render('dashboard/checklist_questions', array(
			'page_title' => 'Checklist Questions | Checklist',
			'page_heading' => 'Checklist Questions',
			'page_subtitle' => 'Add, update, and remove checklist questions for the selected equipment.',
			'breadcrumb_parent' => 'Assets',
			'current_page' => 'equipment',
			'equipment_item' => $equipment,
			'questions' => $questions,
		));
	}

	public function add_checklist_question($equipment_id)
	{
		$equipment = $this->Equipment_model->get_by_id($equipment_id);

		if (!$equipment || !$this->input->post()) {
			show_404();
		}

		$data = array(
			'equipment_id' => (int) $equipment_id,
			'question' => trim((string) $this->input->post('question')),
			'order_index' => (int) $this->input->post('order_index'),
			'is_mandatory' => 1,
			'type' => 'boolean',
			'category' => null,
			'help_text' => null,
			'remark_required_on_non_comply' => 0,
		);

		if ($data['question'] === '') {
			$this->session->set_flashdata('error', 'Question text is required.');
			redirect('dashboard/checklist-questions/' . $equipment_id);
			return;
		}

		if ($this->Checklist_question_model->create($data)) {
			$this->session->set_flashdata('success', 'Checklist question added successfully.');
		} else {
			$this->session->set_flashdata('error', 'Failed to add checklist question.');
		}

		redirect('dashboard/checklist-questions/' . $equipment_id);
	}

	public function edit_checklist_question($equipment_id, $question_id)
	{
		$equipment = $this->Equipment_model->get_by_id($equipment_id);
		$question = $this->Checklist_question_model->get_question($question_id, $equipment_id);

		if (!$equipment || !$question || !$this->input->post()) {
			show_404();
		}

		$data = array(
			'question' => trim((string) $this->input->post('question')),
			'order_index' => (int) $this->input->post('order_index'),
			'is_mandatory' => 1,
			'type' => 'boolean',
			'category' => null,
			'help_text' => null,
			'remark_required_on_non_comply' => 0,
		);

		if ($data['question'] === '') {
			$this->session->set_flashdata('error', 'Question text is required.');
			redirect('dashboard/checklist-questions/' . $equipment_id);
			return;
		}

		if ($this->Checklist_question_model->update($question_id, $data, $equipment_id)) {
			$this->session->set_flashdata('success', 'Checklist question updated successfully.');
		} else {
			$this->session->set_flashdata('error', 'Failed to update checklist question.');
		}

		redirect('dashboard/checklist-questions/' . $equipment_id);
	}

	public function delete_checklist_question($equipment_id, $question_id)
	{
		$equipment = $this->Equipment_model->get_by_id($equipment_id);
		$question = $this->Checklist_question_model->get_question($question_id, $equipment_id);

		if (!$equipment || !$question) {
			show_404();
		}

		if ($this->Checklist_question_model->delete($question_id, $equipment_id)) {
			$this->session->set_flashdata('success', 'Checklist question deleted successfully.');
		} else {
			$this->session->set_flashdata('error', 'Failed to delete checklist question.');
		}

		redirect('dashboard/checklist-questions/' . $equipment_id);
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
		$equipment_id = (int) $this->input->get('equipment_id');
		$year = (int) $this->input->get('year');
		$month = (int) $this->input->get('month');

		if ($equipment_id <= 0) {
			$equipment_id = 1;
		}

		if ($year < 2000 || $year > 2100) {
			$year = (int) date('Y');
		}

		if ($month < 1 || $month > 12) {
			$month = (int) date('n');
		}

		$equipment = $this->Equipment_model->get_by_id($equipment_id);

		if (!$equipment) {
			show_404();
		}

		$dataMap = $this->Checklist_model->get_month_data($equipment_id, $year, $month);

		$questions = $this->Checklist_model->get_questions($equipment_id);

		$title = 'DAILY CHECK LIST FOR ' . strtoupper(trim($equipment['name']));

		if (!empty($equipment['model'])) {
			$title .= ' - ' . strtoupper(trim($equipment['model']));
		}

		$data = [
			'logo' => base_url('assets/images/mhood.png'),
			'title' => $title,
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

		$file_name = 'checklist-' . $equipment_id . '-' . $year . '-' . str_pad((string) $month, 2, '0', STR_PAD_LEFT) . '.pdf';
		$pdf->Output($file_name, 'I');
		exit;
	}
}
?>
