<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd"> 
<html>
<head>
<title><?php echo $this->config->item('site_title'); if(isset($title))echo " ".$this->config->item('site_title_delimiter')." ".$title;?></title>
    <link type='text/css' href="<?php echo base_url();?>css/main.css" rel='Stylesheet' />
    <script src="<?php echo base_url();?>js/jquery.js" type="text/javascript"></script>
    <link type="text/css' href='<?php echo base_url();?>css/ui-lightness/jquery-ui.css" rel='Stylesheet' />
    <script src="<?php echo base_url();?>js/jquery-ui.js" type="text/javascript"></script>
    
    <script type='text/javascript'>
        <?php if (isset($js)){echo $js;}?>          
    </script>
    
    <?php 
    	if(isset($head) && is_array($head)) {
    		foreach ($head as $headObject) {
    			echo $headObject; 
    		}  		
    	}
    ?>
</head>
<body <?php if(isset($onload)){echo "onload=$onload";}?>>
	<div id="container">
	
		<div id="header">
			<div id="logo"></div>
		</div>
		
		<div id="mainNav"><?php $this->load->view('partials/menu.tpl.php');?></div>
		
		<div id="breadcrumb"><?php $this->load->view('partials/breadcrumb.tpl.php');?></div>
		<div id="content">
			<?php echo $content;?>
		
			
		</div>
		
		<div id="footer">
			<div id="bottomMenu"><?php $this->load->view('partials/bottom_menu.tpl.php');?></div>
			<div id="copywright"><?php $this->load->view('partials/copywright.tpl.php');?></div>
		</div>
		
	</div>
</body>
</html>