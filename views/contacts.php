<?php $this->load->view('common/header'); ?>
<style type='text/css'>
	#contacts_print_table { 
		width:80%; 
		margin:0 auto; 
		text-align:center; 
		font:14px normal Arial, Geneva, sans-serif; 
		color:#333; 
		background:#fff;
		border:4px solid #efefef
	}
	#contacts_print_table th { padding:7px; background:#818181; color:#fff }
	#contacts_print_table tr.even { background:#efefef }
</style>
</head>
<body>
<?php echo $print_excel_link.$table; ?>
</body>
</html>