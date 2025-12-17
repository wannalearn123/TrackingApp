<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\PhysicalDataModel;
use App\Models\TrainingActivityModel;
use App\Libraries\PDFExporter;

class ReportExportController extends BaseController
{
    protected $userModel;
    protected $physicalDataModel;
    protected $trainingActivityModel;
    protected $pdfExporter;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->physicalDataModel = new PhysicalDataModel();
        $this->trainingActivityModel = new TrainingActivityModel();
        $this->pdfExporter = new PDFExporter();
    }

    /**
     * Export dashboard report to PDF
     */
    public function exportDashboard()
    {
        // Gather dashboard data
        $data = [
            'total_users'     => $this->userModel->getTotalUsersCount(),
            'pending_users'     => count($this->userModel->getPendingUsers()),
            'approved_users'    => $this->userModel->getApprovedUsersCount(),
            'active_users'    => $this->userModel->getActiveUsersCount(),
            'completion_rate' => $this->trainingActivityModel->getWeeklyCompletionRate(),
            'bmi_stats'       => $this->physicalDataModel->getBMIStatistics(),
        ];

        // Generate PDF
        $pdfContent = $this->pdfExporter->generateDashboardReport($data);

        // Download PDF
        $filename = 'dashboard_report_' . date('Y-m-d_His') . '.pdf';
        $this->pdfExporter->download($pdfContent, $filename);
    }
}