<?php

/* ========================================================================
 * $Id: error.php 376 2016-09-05 17:20:40Z onez $
 * http://ai.onez.cn/
 * Email: www@onez.cn
 * QQ: 6200103
 * ========================================================================
 * Copyright 2016-2016 佳蓝科技.
 * 
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * 
 *     http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ======================================================================== */


!defined('IN_ONEZ') && exit('Access Denied');
?>
<section class="content">
  <div class="text-center" style="padding-top: 100px">
    <h3><i class="fa fa-times-circle text-red" style="font-size:72px"></i></h3>
    <p><?=$array['message']?></p>
    <?if($array['goto']){?>
    <a href="<?=$array['goto']?>" class="btn btn-primary">确定</a>
    <?}?>
  </div>
</section>