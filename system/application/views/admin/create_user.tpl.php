<div class='mainInfo'>

	<h1>Create User</h1>
	<p>Please enter the users information below.</p>
	
	<div id="infoMessage"><?php echo $this->session->flashdata('message');?></div>
	
    <?php echo form_open("admin/create_user");?>
      <p>First Name:</p>
      <?php echo form_input($firstName);?>
      
      <p>Last Name:</p>
      <?php echo form_input($lastName);?>
      
      <p>Company Name:</p>
      <?php echo form_input($company);?>
      
      <p>Email:</p>
      <?php echo form_input($email);?>
      
      <p>Password:</p>
      <?php echo form_input($password);?>
      
      <p>Confirm Password:</p>
      <?php echo form_input($password_confirm);?>
      
      
      <p><?php echo form_submit('submit', 'Create User');?></p>

      
    <?php echo form_close();?>

</div>
