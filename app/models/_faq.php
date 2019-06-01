<?php 
class _faq
{
	public $data;

	public function favouriteAskedQuestions()
	{
		require_once("app/functions/strip_output.php");
		$html = "";

		if(count($this->data))
		{
			$i = 1;
			foreach ($this->data as $val) {
				$in = ($i==1) ? " in" : "";

				$html .= "<section class=\"panel panel-default\">\n";
				
				$html .= "<section class=\"panel-heading\" role=\"tab\">\n";
				$html .= "<h4 class=\"panel-title\">\n";
				$html .= sprintf(
					"<a role=\"button\" data-toggle=\"collapse\" data-parent=\"#accordion\" href=\"#collapse%s\" aria-expanded=\"true\" aria-controls=\"collapseCon%s\">\n",
					$i,
					$i
				);
				$html .= strip_tags($val["title"])."\n";
				$html .= "</a>\n";
				$html .= "</h4>\n";
				$html .= "</section>\n";

				$html .= sprintf(
					"<section id=\"collapse%d\" class=\"panel-collapse collapse%s\" role=\"tabpanel\">\n",
					$i,
					$in
				);
				$html .= "<section class=\"panel-body\">\n";
				$html .= strip_tags($val["description"], "<p><br><strong><ul><li>")."\n";

				$html .= "</section>\n";
				$html .= "</section>\n";

				$html .= "</section>\n";

				$i++;
			}
		}
		return $html;
	}
}