<?php
Yii::import('zii.widgets.CPortlet');
class InboxUser extends CPortlet
{
    public $title='User Todo';
 
    protected function renderContent()
    {
		$a = Yii::app()->user->name;
          $connection=Yii::app()->db;
          $transaction=$connection->beginTransaction();
          try
          {
            $sql = 'truncate table usertodo';
            $command=$connection->createCommand($sql);
            $command->execute();
            $sql = "insert into usertodo (username,tododate,menuname,description,recordstatus) 
			select '".Yii::app()->user->name."',t.dadate,'Form Request',concat('Need Approve/Reject for FR No : ',t.dano),1
			from deliveryadvice t
			where
			t.recordstatus in (select b.wfbefstat
from workflow a
inner join wfgroup b on b.workflowid = a.workflowid
inner join groupaccess c on c.groupaccessid = b.groupaccessid
inner join usergroup d on d.groupaccessid = c.groupaccessid
inner join useraccess e on e.useraccessid = d.useraccessid
where upper(a.wfname) = upper('listda') and upper(e.username)=upper('".Yii::app()->user->name."')and
t.useraccessid in (select gm.menuvalueid from groupmenuauth gm
inner join menuauth ma on ma.menuauthid = gm.menuauthid
where upper(ma.menuobject) = upper('useraccess') and gm.groupaccessid = c.groupaccessid))
			";
            $command=$connection->createCommand($sql);
            $command->execute();
			
			$sql = "insert into usertodo (username,tododate,menuname,description,recordstatus) 
			select '".Yii::app()->user->name."',t.prdate,'Purchase Requestion',concat('Need Approve/Reject for PR No : ',t.prno),1
			from prheader t
			where
			t.recordstatus in (select b.wfbefstat
from workflow a
inner join wfgroup b on b.workflowid = a.workflowid
inner join groupaccess c on c.groupaccessid = b.groupaccessid
inner join usergroup d on d.groupaccessid = c.groupaccessid
inner join useraccess e on e.useraccessid = d.useraccessid
where upper(a.wfname) = upper('listpr') and upper(e.username)=upper('".Yii::app()->user->name."') and
t.slocid in (select gm.menuvalueid from groupmenuauth gm
inner join menuauth ma on ma.menuauthid = gm.menuauthid
where upper(ma.menuobject) = upper('sloc') and gm.groupaccessid = c.groupaccessid))
			";
            $command=$connection->createCommand($sql);
            $command->execute();
			
			$sql = "insert into usertodo (username,tododate,menuname,description,recordstatus) 
			select '".Yii::app()->user->name."',t.docdate,'Purchase Order',concat('Need Approve/Reject for PO No : ',t.pono),1
			from poheader t
			where
			t.recordstatus in (select b.wfbefstat
from workflow a
inner join wfgroup b on b.workflowid = a.workflowid
inner join groupaccess c on c.groupaccessid = b.groupaccessid
inner join usergroup d on d.groupaccessid = c.groupaccessid
inner join useraccess e on e.useraccessid = d.useraccessid
where upper(a.wfname) = upper('listpo') and upper(e.username)=upper('".Yii::app()->user->name."') and
t.poheaderid in (select zz.poheaderid
from podetail zz
where zz.slocid in (select gm.menuvalueid from groupmenuauth gm
inner join menuauth ma on ma.menuauthid = gm.menuauthid
where upper(ma.menuobject) = upper('sloc') and gm.groupaccessid = c.groupaccessid)
))
			";
            $command=$connection->createCommand($sql);
            $command->execute();
			
			$sql = "insert into usertodo (username,tododate,menuname,description,recordstatus) 
			select '".Yii::app()->user->name."',t.grdate,'Goods Received',
			concat('Need Approve/Reject for GR No : ',t.grno),1
			from grheader t
			where
			t.recordstatus in (select b.wfbefstat
from workflow a
inner join wfgroup b on b.workflowid = a.workflowid
inner join groupaccess c on c.groupaccessid = b.groupaccessid
inner join usergroup d on d.groupaccessid = c.groupaccessid
inner join useraccess e on e.useraccessid = d.useraccessid
where upper(a.wfname) = upper('listgr') and upper(e.username)=upper('".Yii::app()->user->name."') and 
t.poheaderid in (select zz.poheaderid
from podetail zz
where zz.slocid in (select gm.menuvalueid from groupmenuauth gm
inner join menuauth ma on ma.menuauthid = gm.menuauthid
where upper(ma.menuobject) = upper('sloc') and gm.groupaccessid = c.groupaccessid)) or
t.giheaderid in (select zz.giheaderid
from giheader zz)
)
			";
            $command=$connection->createCommand($sql);
            $command->execute();
			
			$sql = "insert into usertodo (username,tododate,menuname,description,recordstatus) 
			select '".Yii::app()->user->name."',t.grdate,'Goods Issue',
			concat('Need Approve/Reject for GI No : ',t.grno),1
			from giheader t
			where
			t.recordstatus in (select b.wfbefstat
from workflow a
inner join wfgroup b on b.workflowid = a.workflowid
inner join groupaccess c on c.groupaccessid = b.groupaccessid
inner join usergroup d on d.groupaccessid = c.groupaccessid
inner join useraccess e on e.useraccessid = d.useraccessid
where upper(a.wfname) = upper('listgi') and upper(e.username)=upper('".Yii::app()->user->name."'))
			";
            $command=$connection->createCommand($sql);
            $command->execute();
			
			$sql = "insert into usertodo (username,tododate,menuname,description,recordstatus) 
			select '".Yii::app()->user->name."',t.invoicedate,'Invoice to Customer',
			concat('Need Approve/Reject for Invoice No : ',t.invoiceno),1
			from invoice t
			where
			t.recordstatus in (select b.wfbefstat
from workflow a
inner join wfgroup b on b.workflowid = a.workflowid
inner join groupaccess c on c.groupaccessid = b.groupaccessid
inner join usergroup d on d.groupaccessid = c.groupaccessid
inner join useraccess e on e.useraccessid = d.useraccessid
where upper(a.wfname) = upper('listinvar') and upper(e.username)=upper('".Yii::app()->user->name."'))
			";
            $command=$connection->createCommand($sql);
            $command->execute();
					
			$sql = "insert into usertodo (username,tododate,menuname,description,recordstatus) 
			select '".Yii::app()->user->name."',t.invoicedate,'Invoice From Supplier',
			concat('Need Approve/Reject for Invoice No : ',t.invoiceno),1
			from invoice t
			where
			t.recordstatus in (select b.wfbefstat
from workflow a
inner join wfgroup b on b.workflowid = a.workflowid
inner join groupaccess c on c.groupaccessid = b.groupaccessid
inner join usergroup d on d.groupaccessid = c.groupaccessid
inner join useraccess e on e.useraccessid = d.useraccessid
where upper(a.wfname) = upper('listinvap') and upper(e.username)=upper('".Yii::app()->user->name."'))
			";
            $command=$connection->createCommand($sql);
            $command->execute();
			
			$sql = "insert into usertodo (username,tododate,menuname,description,recordstatus) 
			select '".Yii::app()->user->name."',t.transdate,'Cash / Bank Receipt',
			concat('Need Approve/Reject for Cash/Bank No : ',t.cashbankno),1
			from cashbank t
			where
			t.recordstatus in (select b.wfbefstat
from workflow a
inner join wfgroup b on b.workflowid = a.workflowid
inner join groupaccess c on c.groupaccessid = b.groupaccessid
inner join usergroup d on d.groupaccessid = c.groupaccessid
inner join useraccess e on e.useraccessid = d.useraccessid
where upper(a.wfname) = upper('listcbin') and upper(e.username)=upper('".Yii::app()->user->name."'))
			";
            $command=$connection->createCommand($sql);
            $command->execute();
			
			$sql = "insert into usertodo (username,tododate,menuname,description,recordstatus) 
			select '".Yii::app()->user->name."',t.transdate,'Cash / Bank Payment',
			concat('Need Approve/Reject for Cash/Bank No : ',t.cashbankno),1
			from cashbank t
			where
			t.recordstatus in (select b.wfbefstat
from workflow a
inner join wfgroup b on b.workflowid = a.workflowid
inner join groupaccess c on c.groupaccessid = b.groupaccessid
inner join usergroup d on d.groupaccessid = c.groupaccessid
inner join useraccess e on e.useraccessid = d.useraccessid
where upper(a.wfname) = upper('listcbout') and upper(e.username)=upper('".Yii::app()->user->name."'))
			";
            $command=$connection->createCommand($sql);
            $command->execute();
			
			$sql = "insert into usertodo (username,tododate,menuname,description,recordstatus) 
			select '".Yii::app()->user->name."',t.sodate,'Sales Order',
			concat('Need Approve/Reject for SO No : ',t.sono),1
			from soheader t
			where
			t.recordstatus in (select b.wfbefstat
from workflow a
inner join wfgroup b on b.workflowid = a.workflowid
inner join groupaccess c on c.groupaccessid = b.groupaccessid
inner join usergroup d on d.groupaccessid = c.groupaccessid
inner join useraccess e on e.useraccessid = d.useraccessid
where upper(a.wfname) = upper('listso') and upper(e.username)=upper('".Yii::app()->user->name."'))
			";
            $command=$connection->createCommand($sql);
            $command->execute();
			
			$sql = "insert into usertodo (username,tododate,menuname,description,recordstatus) 
			select '".Yii::app()->user->name."',t.journaldate,'General Journal',
			concat('Need Approve/Reject for Journal No : ',t.referenceno),1
			from genjournal t
			where
			t.recordstatus in (select b.wfbefstat
from workflow a
inner join wfgroup b on b.workflowid = a.workflowid
inner join groupaccess c on c.groupaccessid = b.groupaccessid
inner join usergroup d on d.groupaccessid = c.groupaccessid
inner join useraccess e on e.useraccessid = d.useraccessid
where upper(a.wfname) = upper('listjournal') and upper(e.username)=upper('".Yii::app()->user->name."'))
			";
            $command=$connection->createCommand($sql);
            $command->execute();
			}
          catch(Exception $e) // an exception is raised if a query fails
          {
              $transaction->rollBack();
          }
		$model=new Usertodo('search');
		if(isset($_GET['Usertodo']))
			$model->attributes=$_GET['Usertodo'];
		if (isset($_GET['pageSize']))
		{
			Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
			unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
		}
		$this->render('InboxUser',array(
			'model'=>$model
		));
    }
}