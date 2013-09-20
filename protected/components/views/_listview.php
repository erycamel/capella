<div class="view">
<fieldset>
<table>
<tr>
<td>
<img width="103px" height="130px" src="images/employee/photo-<?php
$photoname=$data->oldnik; 
						if ($photoname !== "")
						{
							if (file_exists('images/employee/photo-'.$photoname.'.jpg'))
							{ 
								echo $photoname; 
							} 
							else 
							{ 
								echo 'default'; 
							} 
						} else 
						{
							echo 'default';
						} ?>.jpg"/>
<td>
<td style="font-size:small" width="100%">
<b>Nama: </b> <?php echo CHtml::encode($data->fullname);?><br />
<b>Tgl Lahir: </b> <?php echo CHtml::encode(date(Yii::app()->params["dateviewfromdb"], strtotime($data->birthdate))); ?><br/>
<b>Struktur Organisasi: </b> <?php echo CHtml::encode(($data->orgstructure!==null)?$data->orgstructure->structurename:""); ?>
</td>
</tr>
</table>
</fieldset>
</div>