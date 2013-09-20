<?php

class TotalrincigajiController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
    protected $menuname = 'totalrincigaji';

        public function actionHelp()
	{
		if (isset($_POST['id'])) {
			$id= (int)$_POST['id'];
			switch ($id) {
				case 1 : $this->txt = '_help'; break;
				case 2 : $this->txt = '_helpmodif'; break;
			}
		}
	  parent::actionHelp();
	}

    public function actionDownload()
    {
           
    }

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
      parent::actionIndex();
        if (isset($_POST['startperiod']))
      {
         $pdf = new PDF();
        $pdf->title='Perbandingan Gaji';
        $pdf->AddPage('L', 'A4');
        $pdf->setFont('Arial','B',12);
		$connection=Yii::app()->db;
          $sql = "select z.wagetypeid, z.wagename,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 2 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as januari,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 3 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as februari,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 4 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as maret,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 5 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as april,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 6 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as mei,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 7 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as juni,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 8 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as juli,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 9 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as agustus,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 10 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as september,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 11 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as oktober,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 12 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as november,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 1 and year(a.wageendperiod) = ".$_POST['startperiod']."+1 and b.wagetypeid = z.wagetypeid
) as desember
from wagetype z
where z.wagetypeid = 1

union

select z.wagetypeid, z.wagename,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 2 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as januari,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 3 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as februari,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 4 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as maret,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 5 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as april,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 6 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as mei,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 7 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as juni,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 8 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as juli,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 9 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as agustus,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 10 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as september,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 11 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as oktober,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 12 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as november,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 1 and year(a.wageendperiod) = ".$_POST['startperiod']."+1 and b.wagetypeid = z.wagetypeid
) as desember
from wagetype z
where z.wagetypeid = 2

union

select z.wagetypeid, z.wagename,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 2 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as januari,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 3 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as februari,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 4 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as maret,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 5 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as april,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 6 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as mei,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 7 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as juni,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 8 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as juli,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 9 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as agustus,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 10 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as september,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 11 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as oktober,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 12 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as november,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 1 and year(a.wageendperiod) = ".$_POST['startperiod']."+1 and b.wagetypeid = z.wagetypeid
) as desember
from wagetype z
where z.wagetypeid = 3

union

select z.wagetypeid, z.wagename,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 2 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as januari,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 3 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as februari,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 4 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as maret,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 5 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as april,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 6 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as mei,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 7 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as juni,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 8 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as juli,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 9 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as agustus,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 10 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as september,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 11 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as oktober,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 12 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as november,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 1 and year(a.wageendperiod) = ".$_POST['startperiod']."+1 and b.wagetypeid = z.wagetypeid
) as desember
from wagetype z
where z.wagetypeid = 4

union

select z.wagetypeid, z.wagename,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 2 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as januari,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 3 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as februari,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 4 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as maret,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 5 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as april,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 6 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as mei,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 7 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as juni,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 8 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as juli,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 9 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as agustus,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 10 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as september,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 11 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as oktober,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 12 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as november,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 1 and year(a.wageendperiod) = ".$_POST['startperiod']."+1 and b.wagetypeid = z.wagetypeid
) as desember
from wagetype z
where z.wagetypeid = 5

union

select z.wagetypeid, z.wagename,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 2 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as januari,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 3 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as februari,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 4 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as maret,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 5 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as april,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 6 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as mei,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 7 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as juni,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 8 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as juli,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 9 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as agustus,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 10 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as september,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 11 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as oktober,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 12 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as november,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 1 and year(a.wageendperiod) = ".$_POST['startperiod']."+1 and b.wagetypeid = z.wagetypeid
) as desember
from wagetype z
where z.wagetypeid = 6

union

select z.wagetypeid, z.wagename,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 2 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as januari,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 3 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as februari,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 4 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as maret,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 5 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as april,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 6 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as mei,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 7 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as juni,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 8 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as juli,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 9 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as agustus,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 10 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as september,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 11 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as oktober,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 12 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as november,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 1 and year(a.wageendperiod) = ".$_POST['startperiod']."+1 and b.wagetypeid = z.wagetypeid
) as desember
from wagetype z
where z.wagetypeid = 7

union

select z.wagetypeid, z.wagename,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 2 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as januari,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 3 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as februari,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 4 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as maret,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 5 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as april,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 6 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as mei,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 7 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as juni,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 8 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as juli,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 9 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as agustus,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 10 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as september,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 11 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as oktober,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 12 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as november,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 1 and year(a.wageendperiod) = ".$_POST['startperiod']."+1 and b.wagetypeid = z.wagetypeid
) as desember
from wagetype z
where z.wagetypeid = 8

union

select z.wagetypeid, z.wagename,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 2 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as januari,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 3 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as februari,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 4 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as maret,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 5 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as april,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 6 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as mei,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 7 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as juni,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 8 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as juli,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 9 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as agustus,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 10 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as september,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 11 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as oktober,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 12 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as november,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 1 and year(a.wageendperiod) = ".$_POST['startperiod']."+1 and b.wagetypeid = z.wagetypeid
) as desember
from wagetype z
where z.wagetypeid = 9

union

select z.wagetypeid, z.wagename,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 2 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as januari,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 3 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as februari,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 4 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as maret,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 5 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as april,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 6 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as mei,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 7 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as juni,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 8 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as juli,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 9 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as agustus,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 10 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as september,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 11 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as oktober,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 12 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as november,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 1 and year(a.wageendperiod) = ".$_POST['startperiod']."+1 and b.wagetypeid = z.wagetypeid
) as desember
from wagetype z
where z.wagetypeid = 10


union

select z.wagetypeid, z.wagename,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 2 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as januari,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 3 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as februari,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 4 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as maret,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 5 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as april,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 6 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as mei,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 7 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as juni,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 8 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as juli,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 9 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as agustus,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 10 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as september,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 11 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as oktober,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 12 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as november,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 1 and year(a.wageendperiod) = ".$_POST['startperiod']."+1 and b.wagetypeid = z.wagetypeid
) as desember
from wagetype z
where z.wagetypeid = 11

union

select z.wagetypeid, z.wagename,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 2 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as januari,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 3 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as februari,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 4 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as maret,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 5 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as april,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 6 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as mei,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 7 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as juni,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 8 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as juli,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 9 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as agustus,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 10 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as september,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 11 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as oktober,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 12 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as november,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 1 and year(a.wageendperiod) = ".$_POST['startperiod']."+1 and b.wagetypeid = z.wagetypeid
) as desember
from wagetype z
where z.wagetypeid = 12

union

select z.wagetypeid, z.wagename,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 2 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as januari,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 3 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as februari,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 4 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as maret,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 5 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as april,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 6 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as mei,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 7 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as juni,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 8 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as juli,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 9 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as agustus,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 10 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as september,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 11 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as oktober,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 12 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as november,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 1 and year(a.wageendperiod) = ".$_POST['startperiod']."+1 and b.wagetypeid = z.wagetypeid
) as desember
from wagetype z
where z.wagetypeid = 13

union

select z.wagetypeid, z.wagename,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 2 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as januari,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 3 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as februari,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 4 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as maret,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 5 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as april,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 6 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as mei,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 7 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as juni,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 8 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as juli,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 9 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as agustus,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 10 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as september,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 11 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as oktober,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 12 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as november,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 1 and year(a.wageendperiod) = ".$_POST['startperiod']."+1 and b.wagetypeid = z.wagetypeid
) as desember
from wagetype z
where z.wagetypeid = 14

union

select z.wagetypeid, z.wagename,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 2 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as januari,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 3 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as februari,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 4 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as maret,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 5 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as april,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 6 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as mei,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 7 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as juni,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 8 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as juli,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 9 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as agustus,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 10 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as september,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 11 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as oktober,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 12 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as november,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 1 and year(a.wageendperiod) = ".$_POST['startperiod']."+1 and b.wagetypeid = z.wagetypeid
) as desember
from wagetype z
where z.wagetypeid = 15

union

select z.wagetypeid, z.wagename,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 2 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as januari,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 3 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as februari,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 4 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as maret,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 5 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as april,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 6 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as mei,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 7 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as juni,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 8 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as juli,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 9 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as agustus,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 10 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as september,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 11 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as oktober,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 12 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as november,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 1 and year(a.wageendperiod) = ".$_POST['startperiod']."+1 and b.wagetypeid = z.wagetypeid
) as desember
from wagetype z
where z.wagetypeid = 16

union

select z.wagetypeid, z.wagename,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 2 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as januari,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 3 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as februari,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 4 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as maret,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 5 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as april,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 6 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as mei,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 7 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as juni,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 8 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as juli,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 9 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as agustus,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 10 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as september,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 11 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as oktober,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 12 and year(a.wageendperiod) = ".$_POST['startperiod']." and b.wagetypeid = z.wagetypeid
) as november,
(
  select sum(b.amount)
  from employeewage a
  inner join employeewagedetail b on a.employeewageid = b.employeewageid
  where month(a.wageendperiod) = 1 and year(a.wageendperiod) = ".$_POST['startperiod']."+1 and b.wagetypeid = z.wagetypeid
) as desember
from wagetype z
where z.wagetypeid = 17
";
          $command=$connection->createCommand($sql);
        $dataReader=$command->queryAll();
          $pdf->setFont('Arial','B',6);
          $pdf->setwidths(array(30,20,20,20,20,20,20,20,20,20,20,20,20,20));
          $pdf->row(array('Benefit','Januari','Februari','Maret','April','Mei',
              'Juni','Juli','Agustus','September',
              'Oktober','November',
              'Desember'));
          $pdf->SetTableData();
          foreach($dataReader as $row)
          {
            $pdf->row(array($row['wagename'],
                Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberprice"],$row['januari']),
                Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberprice"],$row['februari']),
                Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberprice"],$row['maret']),
                Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberprice"],$row['april']),
                Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberprice"],$row['mei']),
                Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberprice"],$row['juni']),
                Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberprice"],$row['juli']),
                Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberprice"],$row['agustus']),
                Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberprice"],$row['september']),
                Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberprice"],$row['oktober']),
                Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberprice"],$row['november']),
                Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberprice"],$row['desember'])));
          }

          $pdf->Output('Totalrinciangaji.pdf','D');
      }
      else {
        $this->render('index');
      }
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Totalrinciangaji::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='payrollprocess-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
