<ul>
  <?php foreach ($this->Menu_model->get_menu('bottom') as $key => $item):?>
  	<?php if ($this->session->userdata('group_id') && $item->group_id == $this->session->userdata('group_id') || $item->group_id == '0'):?>
        <li<?php if($key==0) echo " class='first'";?>>
  		  <?php 
           	  if ($item->url != '') {
           		echo "<a href='" .$item->url. "' target='_blank'>" .$item->title. "</a>";
              }
              else {
               	echo anchor($item->controller .'/'. $item->view,$item->title);
              }
	       ?>
        </li>
        <li class="separator">|</li>
    <?php endif;?>
  <?php endforeach;?>
  <?php if ($this->auth->is_admin()):?>
  	  <li>
           <?php echo anchor('admin','Admin');?>
      </li>
        <li class="separator">|</li>
  <?php endif;?>
  <?php if ($this->auth->logged_in()):?>
  	  <li>
           <?php echo anchor('admin/logout','Logout');?>
      </li>
  <?php else:?>
  	  <li>
           <?php echo anchor('admin/login','Login');?>
      </li>
  <?php endif;?>
</ul>