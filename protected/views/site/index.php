<?php $this->pageTitle=Yii::app()->name; 
$model=Useraccess::model()->findbyattributes(array('username'=>Yii::app()->user->name));
?>
<div id="user-pnl"> <!-- tambahan baru -->
				<fieldset>
					<legend>User Information</legend>	
					<div id="user-foto">
						<img src="images/employee/photo-<?php 
						$photoname=($model !==null)?(($model->employee!==null)?$model->employee->oldnik:""):""; 
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
						} ?>.jpg" alt="Foto User" />
					</div>
					<div id="user-info">
						<ul>
							<li>
								<div class="row1">Nama</div>
								<div class="row2"><?php echo ($model !== null)?(($model->employee!==null)?($model->employee->fullname):$model->realname):""?></div>							
							</li>	
		<li>
								<div>NIK</div>
								<div><?php echo ($model !== null)?(($model->employee!==null)?($model->employee->oldnik):""):""?></div>							
							</li>	
							<li>
								<div>Struktur Organisasi</div>
								<div><?php echo ($model !== null)?(($model->employee!==null)?($model->employee->orgstructure->structurename):""):""?></div>							
							</li>		
						</ul>
					</div>		
				</fieldset>
			</div>
<?php  
//echo CHtml::image(Yii::app()->request->baseUrl.'/images/banner.jpg');
if(!Yii::app()->user->isGuest) 
	   {
			$this->widget('DaftarKaryawan'); 
		}
?>
<div id="user-pnl">
<?php  
//echo CHtml::image(Yii::app()->request->baseUrl.'/images/banner.jpg');
if(!Yii::app()->user->isGuest) 
	   {
			$this->widget('InboxUser'); 
		}
?>
</div>
