<?php
class EmployeeSpLetterCommand extends CConsoleCommand
{
    public function run($args)
    {
      $connection=Yii::app()->db;
	  $sql = 'update employeespletter set recordstatus = 0 where enddate  = date_sub(now(),interval 1 day) and recordstatus = 1';
		$command=$connection->createCommand($sql);
		$command->execute();
    }
}
