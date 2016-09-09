
<?php
!defined('IN_ONEZ') && exit('Access Denied');
$dbtables=array();

#onez_admin
$dbtables['admin']=array(
  'idname'=>'adminid',
  'fields'=>array(
    array (
      'fieldname' => 'username',
      'fieldtype' => 'text',
      'mylen' => '120',
      'summary' => '',
      'is_index' => '1',
      'is_only' => '',
    ),
    array (
      'fieldname' => 'password',
      'fieldtype' => 'text',
      'mylen' => '50',
      'summary' => '',
      'is_index' => '1',
      'is_only' => '',
    ),
  ),
  'defaults'=>array(
    array (
      'username' => 'admin',
      'password' => md5('admin'),
    ),
  ),
  'summary_create'=>'默认管理账号和密码都是<code>admin</code>',
);

#onez_attrs
$dbtables['attrs']=array(
  'idname'=>'attrid',
  'fields'=>array(
    array (
      'fieldname' => 'subject',
      'fieldtype' => 'text',
      'mylen' => '120',
      'summary' => '',
      'is_index' => '',
      'is_only' => '',
    ),
    array (
      'fieldname' => 'type',
      'fieldtype' => 'text',
      'mylen' => '300',
      'summary' => '',
      'is_index' => '',
      'is_only' => '',
    ),
  ),
);

#onez_devices
$dbtables['devices']=array(
  'idname'=>'deviceid',
  'fields'=>array(
    array (
      'fieldname' => 'subject',
      'fieldtype' => 'text',
      'mylen' => '120',
      'summary' => '',
      'is_index' => '',
      'is_only' => '',
    ),
    array (
      'fieldname' => 'device_token',
      'fieldtype' => 'text',
      'mylen' => '80',
      'summary' => '',
      'is_index' => '1',
      'is_only' => '',
    ),
  ),
);

#onez_history
$dbtables['history']=array(
  'idname'=>'id',
  'fields'=>array(
    array (
      'fieldname' => 'udid',
      'fieldtype' => 'text',
      'mylen' => '50',
      'summary' => '',
      'is_index' => '1',
      'is_only' => '',
    ),
    array (
      'fieldname' => 'you',
      'fieldtype' => 'text',
      'mylen' => '50',
      'summary' => '',
      'is_index' => '1',
      'is_only' => '',
    ),
    array (
      'fieldname' => 'action',
      'fieldtype' => 'text',
      'mylen' => '20',
      'summary' => '',
      'is_index' => '1',
      'is_only' => '',
    ),
    array (
      'fieldname' => 'type',
      'fieldtype' => 'text',
      'mylen' => '20',
      'summary' => '',
      'is_index' => '1',
      'is_only' => '',
    ),
    array (
      'fieldname' => 'deviceid',
      'fieldtype' => 'int',
      'mylen' => '11',
      'summary' => '',
      'is_index' => '1',
      'is_only' => '',
    ),
    array (
      'fieldname' => 'data',
      'fieldtype' => 'long',
      'mylen' => '',
      'summary' => '',
      'is_index' => '',
      'is_only' => '',
    ),
    array (
      'fieldname' => 'text',
      'fieldtype' => 'text',
      'mylen' => '160',
      'summary' => '',
      'is_index' => '',
      'is_only' => '',
    ),
    array (
      'fieldname' => 'time',
      'fieldtype' => 'int',
      'mylen' => '11',
      'summary' => '',
      'is_index' => '1',
      'is_only' => '',
    ),
    array (
      'fieldname' => 'ip',
      'fieldtype' => 'text',
      'mylen' => '20',
      'summary' => '',
      'is_index' => '',
      'is_only' => '',
    ),
    array (
      'fieldname' => 'isread',
      'fieldtype' => 'int',
      'mylen' => '1',
      'summary' => '',
      'is_index' => '1',
      'is_only' => '',
    ),
    array (
      'fieldname' => 'status',
      'fieldtype' => 'text',
      'mylen' => '30',
      'summary' => '',
      'is_index' => '1',
      'is_only' => '',
    ),
    array (
      'fieldname' => 'replyid',
      'fieldtype' => 'int',
      'mylen' => '11',
      'summary' => '',
      'is_index' => '1',
      'is_only' => '',
    ),
    array (
      'fieldname' => 'replytime',
      'fieldtype' => 'int',
      'mylen' => '11',
      'summary' => '',
      'is_index' => '1',
      'is_only' => '',
    ),
    array (
      'fieldname' => 'askinfo',
      'fieldtype' => 'long',
      'mylen' => '',
      'summary' => '',
      'is_index' => '',
      'is_only' => '',
    ),
    array (
      'fieldname' => 'readtime',
      'fieldtype' => 'int',
      'mylen' => '11',
      'summary' => '',
      'is_index' => '',
      'is_only' => '',
    ),
    array (
      'fieldname' => 'isread_u',
      'fieldtype' => 'int',
      'mylen' => '1',
      'summary' => '',
      'is_index' => '1',
      'is_only' => '',
    ),
    array (
      'fieldname' => 'readtime_u',
      'fieldtype' => 'int',
      'mylen' => '11',
      'summary' => '',
      'is_index' => '',
      'is_only' => '',
    ),
  ),
);

#onez_person
$dbtables['person']=array(
  'idname'=>'id',
  'fields'=>array(
    array (
      'fieldname' => 'deviceid',
      'fieldtype' => 'int',
      'mylen' => '11',
      'summary' => '',
      'is_index' => '1',
      'is_only' => '',
    ),
    array (
      'fieldname' => 'udid',
      'fieldtype' => 'text',
      'mylen' => '50',
      'summary' => '',
      'is_index' => '1',
      'is_only' => '',
    ),
    array (
      'fieldname' => 'firsttime',
      'fieldtype' => 'int',
      'mylen' => '11',
      'summary' => '',
      'is_index' => '',
      'is_only' => '',
    ),
    array (
      'fieldname' => 'firstip',
      'fieldtype' => 'text',
      'mylen' => '20',
      'summary' => '',
      'is_index' => '',
      'is_only' => '',
    ),
    array (
      'fieldname' => 'lasttime',
      'fieldtype' => 'int',
      'mylen' => '11',
      'summary' => '',
      'is_index' => '',
      'is_only' => '',
    ),
    array (
      'fieldname' => 'lastip',
      'fieldtype' => 'text',
      'mylen' => '20',
      'summary' => '',
      'is_index' => '',
      'is_only' => '',
    ),
    array (
      'fieldname' => 'initdata',
      'fieldtype' => 'long',
      'mylen' => '',
      'summary' => '',
      'is_index' => '',
      'is_only' => '',
    ),
    array (
      'fieldname' => 'lastdata',
      'fieldtype' => 'long',
      'mylen' => '',
      'summary' => '',
      'is_index' => '',
      'is_only' => '',
    ),
    array (
      'fieldname' => 'times',
      'fieldtype' => 'int',
      'mylen' => '11',
      'summary' => '',
      'is_index' => '',
      'is_only' => '',
    ),
  ),
);

#onez_person_attrs
$dbtables['person_attrs']=array(
  'idname'=>'id',
  'fields'=>array(
    array (
      'fieldname' => 'udid',
      'fieldtype' => 'text',
      'mylen' => '50',
      'summary' => '',
      'is_index' => '1',
      'is_only' => '',
    ),
    array (
      'fieldname' => 'attrkey',
      'fieldtype' => 'text',
      'mylen' => '50',
      'summary' => '',
      'is_index' => '1',
      'is_only' => '',
    ),
    array (
      'fieldname' => 'value',
      'fieldtype' => 'long',
      'mylen' => '',
      'summary' => '',
      'is_index' => '',
      'is_only' => '',
    ),
    array (
      'fieldname' => 'time',
      'fieldtype' => 'int',
      'mylen' => '11',
      'summary' => '',
      'is_index' => '',
      'is_only' => '',
    ),
  ),
);

#onez_person_tags
$dbtables['person_tags']=array(
  'idname'=>'id',
  'fields'=>array(
    array (
      'fieldname' => 'udid',
      'fieldtype' => 'text',
      'mylen' => '50',
      'summary' => '',
      'is_index' => '',
      'is_only' => '',
    ),
    array (
      'fieldname' => 'tagname',
      'fieldtype' => 'text',
      'mylen' => '50',
      'summary' => '',
      'is_index' => '',
      'is_only' => '',
    ),
    array (
      'fieldname' => 'time',
      'fieldtype' => 'int',
      'mylen' => '11',
      'summary' => '',
      'is_index' => '',
      'is_only' => '',
    ),
  ),
);

#onez_rules
$dbtables['rules']=array(
  'idname'=>'ruleid',
  'fields'=>array(
    array (
      'fieldname' => 'groupid',
      'fieldtype' => 'int',
      'mylen' => '11',
      'summary' => '',
      'is_index' => '1',
      'is_only' => '',
    ),
    array (
      'fieldname' => 'step',
      'fieldtype' => 'int',
      'mylen' => '11',
      'summary' => '',
      'is_index' => '1',
      'is_only' => '',
    ),
    array (
      'fieldname' => 'deviceid',
      'fieldtype' => 'int',
      'mylen' => '11',
      'summary' => '',
      'is_index' => '1',
      'is_only' => '',
    ),
    array (
      'fieldname' => 'input_type',
      'fieldtype' => 'text',
      'mylen' => '30',
      'summary' => '',
      'is_index' => '',
      'is_only' => '',
    ),
    array (
      'fieldname' => 'input_typename',
      'fieldtype' => 'text',
      'mylen' => '200',
      'summary' => '',
      'is_index' => '',
      'is_only' => '',
    ),
    array (
      'fieldname' => 'rule',
      'fieldtype' => 'long',
      'mylen' => '',
      'summary' => '',
      'is_index' => '',
      'is_only' => '',
    ),
    array (
      'fieldname' => 'doit',
      'fieldtype' => 'long',
      'mylen' => '',
      'summary' => '',
      'is_index' => '',
      'is_only' => '',
    ),
    array (
      'fieldname' => 'addtime',
      'fieldtype' => 'int',
      'mylen' => '11',
      'summary' => '',
      'is_index' => '',
      'is_only' => '',
    ),
    array (
      'fieldname' => 'updatetime',
      'fieldtype' => 'int',
      'mylen' => '11',
      'summary' => '',
      'is_index' => '',
      'is_only' => '',
    ),
    array (
      'fieldname' => 'addtype',
      'fieldtype' => 'text',
      'mylen' => '30',
      'summary' => '',
      'is_index' => '1',
      'is_only' => '',
    ),
    array (
      'fieldname' => 'userid',
      'fieldtype' => 'int',
      'mylen' => '11',
      'summary' => '',
      'is_index' => '1',
      'is_only' => '',
    ),
    array (
      'fieldname' => 'summary',
      'fieldtype' => 'text',
      'mylen' => '200',
      'summary' => '',
      'is_index' => '1',
      'is_only' => '',
    ),
    array (
      'fieldname' => 'add_info',
      'fieldtype' => 'text',
      'mylen' => '200',
      'summary' => '',
      'is_index' => '',
      'is_only' => '',
    ),
    array (
      'fieldname' => 'hash',
      'fieldtype' => 'text',
      'mylen' => '50',
      'summary' => '',
      'is_index' => '1',
      'is_only' => '',
    ),
  ),
);

#onez_rules_group
$dbtables['rules_group']=array(
  'idname'=>'groupid',
  'fields'=>array(
    array (
      'fieldname' => 'subject',
      'fieldtype' => 'text',
      'mylen' => '120',
      'summary' => '',
      'is_index' => '1',
      'is_only' => '',
    ),
    array (
      'fieldname' => 'type',
      'fieldtype' => 'text',
      'mylen' => '30',
      'summary' => '',
      'is_index' => '1',
      'is_only' => '',
    ),
    array (
      'fieldname' => 'tags',
      'fieldtype' => 'text',
      'mylen' => '500',
      'summary' => '',
      'is_index' => '1',
      'is_only' => '',
    ),
    array (
      'fieldname' => 'workers',
      'fieldtype' => 'text',
      'mylen' => '300',
      'summary' => '',
      'is_index' => '',
      'is_only' => '',
    ),
  ),
);

#onez_tags
$dbtables['tags']=array(
  'idname'=>'tagid',
  'fields'=>array(
    array (
      'fieldname' => 'tagname',
      'fieldtype' => 'text',
      'mylen' => '120',
      'summary' => '',
      'is_index' => '1',
      'is_only' => '',
    ),
    array (
      'fieldname' => 'token_add',
      'fieldtype' => 'text',
      'mylen' => '50',
      'summary' => '',
      'is_index' => '1',
      'is_only' => '',
    ),
    array (
      'fieldname' => 'token_running',
      'fieldtype' => 'text',
      'mylen' => '50',
      'summary' => '',
      'is_index' => '',
      'is_only' => '',
    ),
    array (
      'fieldname' => 'token_remove',
      'fieldtype' => 'text',
      'mylen' => '50',
      'summary' => '',
      'is_index' => '',
      'is_only' => '',
    ),
    array (
      'fieldname' => 'summary',
      'fieldtype' => 'text',
      'mylen' => '300',
      'summary' => '',
      'is_index' => '1',
      'is_only' => '',
    ),
    array (
      'fieldname' => 'level',
      'fieldtype' => 'int',
      'mylen' => '11',
      'summary' => '',
      'is_index' => '',
      'is_only' => '',
    ),
  ),
);

#onez_workers
$dbtables['workers']=array(
  'idname'=>'workerid',
  'fields'=>array(
    array (
      'fieldname' => 'username',
      'fieldtype' => 'text',
      'mylen' => '120',
      'summary' => '',
      'is_index' => '1',
      'is_only' => '',
    ),
    array (
      'fieldname' => 'password',
      'fieldtype' => 'text',
      'mylen' => '50',
      'summary' => '',
      'is_index' => '1',
      'is_only' => '',
    ),
  ),
);
return $dbtables;