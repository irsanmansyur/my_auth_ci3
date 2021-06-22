<?php defined('BASEPATH') or exit('No direct script access allowed');

use Dompdf\Dompdf;
use Dompdf\Options;



class Pdf extends Dompdf
{
  /**
   * PDF filename
   * @var String
   */
  public $filename;

  public function __construct()
  {
    parent::__construct();
    $this->filename = "laporan.pdf";
  }
  /**
   * Get an instance of CodeIgniter
   *
   * @access    protected
   * @return    void
   */
  protected function ci()
  {
    return get_instance();
  }
  /**
   * Load a CodeIgniter view into domPDF
   *
   * @access    public
   * @param    string    $view The view to load
   * @param    array    $data The view data
   * @return    void
   */
  public function load_view($view, $data = array())
  {

    $html = $this->ci()->load->view($view, $data, TRUE);
    $this->load_html($html);
    // Render the PDF
    $this->render();
    // Output the generated PDF to Browser
    $this->stream($this->filename, array("Attachment" => true));
  }

  public function view($html, $filename, $paper = "A4", $orientation = "landscape", $stream = true)
  {
    $options = new Options();
    $options->set('isRemoteEnabled', TRUE);
    $dompdf = new Dompdf($options);
    $dompdf->loadHtml($html);
    $dompdf->setPaper($paper, $orientation);
    $dompdf->render();
    if ($stream) {
      $dompdf->stream($filename . ".pdf", array("Attachment" => 0));
      exit(0);
    } else {
      return $dompdf->output();
    }
  }
}
