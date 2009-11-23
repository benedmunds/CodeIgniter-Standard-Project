<div class='mainInfo'>

	<h1>Users</h1>
	<p>Below is a list of the users.</p>
	
	<div id="infoMessage"><?php echo $this->session->flashdata('message');?></div>
	
	<table>
		<tr class="listTitle"><td width='15%'>First Name</td><td width='15%'>Last Name</td><td width='15%'>Company</td><td width='15%'>Email</td><td width='30%'></td><td width='20%'>Group</td><td></td><td width='20%'>Status</td><td width='20%'></td></tr>
		<?php foreach ($users as $user):?>
			<tr><td><?php echo $user['firstName']?></td><td><?php echo $user['lastName']?></td><td><?php echo $user['company'];?></td><td><?php echo $user['email'];?></td><td></td><td><?php echo $user['group_description'];?></td><td>&nbsp;</td><td><?php echo ($user['active']?"<a href='".base_url()."admin/deactivate/".$user['id']."'>Active</a>":"<a href='".base_url()."admin/activate/".$user['id']."'>Inactive</a>");?></td><td></td></tr>
		<?php endforeach;?>
	</table>
	
	<p><a href="<?php echo base_url();?>admin/create_user">Create a new user</a></p>
	
</div>
