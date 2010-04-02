<?php $this->load->view('common/header'); ?>
<script type="text/javascript" src="/js/jquery.all.js"></script>
<script type="text/javascript">
	var GreyRobot = {
		baseUrl: "<?php echo base_url(); ?>", 
		page: "<?php echo $page; ?>",
		logging_in: "<?php echo isset($logging_in) ? $logging_in : ''; ?>",
		type: "<?php echo isset($vars['type']) ? $vars['type'] : ''; ?>",
		authenticated: "<?php echo isset($vars['authenticated']) ? $vars['authenticated'] : ''; ?>"
	};
</script>
<?php if (isset($head_items)) echoItems($head_items); ?>
<script type="text/javascript" src="<?php echo base_url(); ?>js/greymatter.js"></script>
<title><?php echo $title; ?></title>
</head>
<body id="main_body" class="<?php echo $page; ?>">

	<?php $this->load->view($page, $vars); ?>

	<?php $this->load->view('common/footer'); ?>

</body>
</html>